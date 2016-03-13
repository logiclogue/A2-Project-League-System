<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/Validate.php');

session_start();


/**
 * This model is used to update user details.
 *
 * @class UserUpdate
 * @extends Model
 */
/*&
 * @param first_name {String} The new first name of the user.
 * @param last_name {String} The new last name of the user.
 * @param home_phone {String} The new home phone number of the user.
 * @param mobile_phone {String} THe new mobile phone number of the user.
 */
class UserUpdate extends Model
{
	/**
	 * SQL query string to update the user's data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE users
		SET
		first_name = CASE WHEN :first_name IS NULL THEN first_name ELSE :first_name END,
		last_name = CASE WHEN :last_name IS NULL THEN last_name ELSE :last_name END,
		home_phone = :home_phone,
		mobile_phone = :mobile_phone
		WHERE id = :id
SQL;

	/**
	 * Database object variable.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;


	/**
	 * Main method once @method main has checked login.
	 *
	 * @method update
	 * @private
	 */
	private function update() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':id', $_SESSION['user']['id']);
		$this->stmt->bindParam(':first_name', $this->data['first_name']);
		$this->stmt->bindParam(':last_name', $this->data['last_name']);
		$this->stmt->bindParam(':home_phone', $this->data['home_phone']);
		$this->stmt->bindParam(':mobile_phone', $this->data['mobile_phone']);

		if (!$this->stmt->execute()) {
			$this->success = false;
		}
	}

	/**
	 * Method that validates the inputs.
	 * Validating first name, last name, and phone numbers.
	 *
	 * @method validate
	 * @private
	 * @return {Boolean} Whether valid.
	 */
	private function validate() {
		$validateFirstName = Validate::userName($this->data['first_name'], 'First name');
		$validateLastName = Validate::userName($this->data['last_name'], 'Last name');
		$validateHomePhone = Validate::phoneNumber($this->data['home_phone']);
		$validateMobilePhone = Validate::phoneNumber($this->data['mobile_phone']);

		if (!$validateFirstName['success']) {
			$this->error_msg = $validateFirstName['error_msg'];

			return false;
		}
		if (!$validateLastName['success']) {
			$this->error_msg = $validateLastName['error_msg'];

			return false;
		}
		if (!$validateHomePhone['success'] && isset($this->data['home_phone'])) {
			$this->error_msg = $validateHomePhone['error_msg'];

			return false;
		}
		if (!$validateMobilePhone['success'] && isset($this->data['mobile_phone'])) {
			$this->error_msg = $validateMobilePhone['error_msg'];

			return false;
		}

		return true;
	}

	/**
	 * Checks to see if the user is logged in.
	 * Calls @method update if true.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user']) && $this->validate()) {
			$this->update();
		}
		else {
			$this->success = false;
		}
	}
}

?>