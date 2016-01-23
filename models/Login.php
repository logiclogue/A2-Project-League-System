<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Login model for logging into the system.
 * 
 * @class Login
 * @extends Model
 */
/**
 * @param email {String} Email of the user.
 * @param password {String} Password of the user.
 */
class Login extends Model
{
	/**
	 * SQL query string for getting the details of the user.
	 * Finds user by email.
	 *
	 * @property query
	 * @type String
	 */
	private $query = <<<SQL
		SELECT id, email, first_name, last_name, hash
		FROM users
		WHERE email=:email
SQL;

	/**
	 * Connects to the database.
	 * Binds query and parameters.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;
	/**
	 * Stores result from database.
	 * User data.
	 *
	 * @property user
	 * @type Object
	 * @private
	 */
	private $user = array();


	/**
	 * Stores the user details in the current user session.
	 *
	 * @method storeSession
	 * @private
	 */
	private function storeSession() {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = $this->user['id'];
		$_SESSION['user']['email'] = $this->user['email'];
		$_SESSION['user']['first_name'] = $this->user['first_name'];
		$_SESSION['user']['last_name'] = $this->user['last_name'];
	}

	/**
	 * Checks to see if password entered matches the password associated to the email entered.
	 *
	 * @method verify
	 * @private
	 */
	private function verify() {
		$this->user = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0];

		// check if password matches
		if (password_verify($this->data['password'], $this->user['hash'])) {
			$this->storeSession();
		}
		else {
			$this->success = false;
			$this->error_msg = 'Incorrect email or password';
		}
	}


	/**
	 * Defines @property result.
	 * Binds parameters to @property query.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':email', $this->data['email']);
		
		// check if query is successful
		if ($this->stmt->execute()) {
			$this->verify();
		}
		else {
			$this->success = false;
			$this->error_msg = 'Failed to execute query';
		}
	}
}

$Login = new Login();

?>