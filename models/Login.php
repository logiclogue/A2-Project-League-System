<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Login model for logging into the system.
 * 
 * @class Login
 * @extends Model
 * @static
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
	private static $query = <<<SQL
		SELECT id, email, first_name, last_name, hash
		FROM users
		WHERE email=:email
SQL;

	/**
	 * Connects to the database.
	 * Binds query and parameters.
	 *
	 * @property result
	 * @type Object
	 * @private
	 */
	private static $result;
	/**
	 * Stores result from database.
	 * User data.
	 *
	 * @property user
	 * @type Object
	 * @private
	 */
	private static $user = array();


	/**
	 * Stores the user details in the current user session.
	 *
	 * @method storeSession
	 * @return {Boolean} true.
	 */
	private static function storeSession() {
		$_SESSION['user'] = array();
		$_SESSION['user']['id'] = self::$user['id'];
		$_SESSION['user']['email'] = self::$user['email'];
		$_SESSION['user']['first_name'] = self::$user['first_name'];
		$_SESSION['user']['last_name'] = self::$user['last_name'];

		return true;
	}

	/**
	 * Checks to see if password entered matches the password associated to the email entered.
	 *
	 * @method verify]
	 * @private
	 * @return {Boolean} Whether password entered is correct one.
	 */
	private static function verify() {
		self::$user = self::$result->fetchAll(PDO::FETCH_ASSOC)[0];

		// check if password matches
		if (password_verify(self::$data['password'], self::$user['hash'])) {
			return self::storeSession();
		}
		else {
			return false;
		}
	}


	/**
	 * Defines @property result.
	 * Binds parameters to @property query.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether executed query and successfully logged in.
	 */
	protected static function main() {
		self::$result = Database::$conn->prepare(self::$query);

		self::$result->bindParam(':email', self::$data['email']);
		
		// check if query is successful
		if (self::$result->execute()) {
			return self::verify();
		}
		else {
			return false;
		}
	}
}

Login::init();

?>