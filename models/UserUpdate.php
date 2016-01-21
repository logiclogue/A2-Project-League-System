<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * This model is used to update user details.
 *
 * @class UserUpdate
 * @extends Model
 */
/**
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
	 * Checks to see if the user is logged in.
	 * Calls @method update if true.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->update();
		}
		else {
			$this->success = false;
		}
	}
}

$UserUpdate = new UserUpdate();

?>