<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/Validate.php');

session_start();


/**
 * Register model used to register onto the system.
 *
 * @class Register
 * @extends Model
 */
/**
 * @param email {String} The email of the user.
 * @param first_name {String} The first name of the user.
 * @param last_name {String} The last name of the user.
 * @param password {String} The password of the user.
 */
class Register extends Model
{
	/**
	 * SQL query string for inserting user data into the database.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		INSERT INTO users (email, first_name, last_name, hash)
		VALUES (:email, :first_name, :last_name, :hash)
SQL;
	
	/**
	 * For executing the query string.
	 *
	 * @property result
	 * @type Object
	 * @private
	 */
	private $stmt;
	/**
	 * Hash of the password entered.
	 *
	 * @property hash
	 * @type String
	 * @private
	 */
	private $hash;


	/**
	 * Used to bind the parameters to @property query.
	 * Data inputted by user is bound.
	 *
	 * @method bindParams
	 * @private
	 */
	private function bindParams() {
		$this->stmt->bindParam(':email', $this->data['email']);
		$this->stmt->bindParam(':first_name', $this->data['first_name']);
		$this->stmt->bindParam(':last_name', $this->data['last_name']);
		$this->stmt->bindParam(':hash', $this->hash);
	}

	/**
	 * Validate email, first name, last name, and password.
	 *
	 * @method validate
	 * @private
	 * @return {Boolean} Whether all is valid.
	 */
	private function validate() {
		$validateFirstName = Validate::userName($this->data['first_name'], 'First name');
		$validateLastName = Validate::userName($this->data['last_name'], 'Last name');
		$validateEmail = Validate::email($this->data['email']);
		$validatePassword = Validate::password($this->data['password']);

		if (!$validateFirstName['success']) {
			$this->error_msg = $validateFirstName['error_msg'];

			return false;
		}
		if (!$validateLastName['success']) {
			$this->error_msg = $validateLastName['error_msg'];

			return false;
		}
		if (!$validateEmail['success']) {
			$this->error_msg = $validateEmail['error_msg'];

			return false;
		}
		if (!$validatePassword['success']) {
			$this->error_msg = $validatePassword['error_msg'];

			return false;
		}

		return true;
	}

	/**
	 * Prepares query.
	 * Hashes password.
	 * Executes query.
	 *
	 * @method main
	 * @public
	 */
	public function main() {
		if ($this->validate()) {
			$this->stmt = Database::$conn->prepare($this->query);
			$this->hash = password_hash($this->data['password'], PASSWORD_BCRYPT);

			$this->bindParams();
			
			if (!$this->stmt->execute()) {
				$this->success = false;
			}
		}
		else {
			$this->success = false;
		}
	}
}

$Register = new Register();

?>