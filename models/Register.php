<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Register model used to register onto the system.
 *
 * @class Register
 * @extends Model
 * @static
 */
/**
 * @param email {String} The email of the user.
 * @param first_name {String} The first name of the user.
 * @param last_name {String} The last name of the user.
 * @param password {String} The password of the user.
 *
 * @return {Boolean} Whether successfully registered.
 */
class Register extends Model
{
	/**
	 * SQL query string for inserting user data into the database.
	 *
	 * @property query
	 * @type String
	 */
	private static $query = <<<SQL
		INSERT INTO users (email, first_name, last_name, hash)
		VALUES (:email, :first_name, :last_name, :hash)
SQL;
	
	/**
	 * For executing the query string.
	 *
	 * @property result
	 * @type Object
	 */
	private static $result;
	/**
	 * Hash of the password entered.
	 *
	 * @property hash
	 * @type String
	 */
	private static $hash;


	/**
	 * Used to bind the parameters to @property query.
	 * Data inputted by user is bound.
	 *
	 * @method bindParams
	 */
	private static function bindParams() {
		self::$result->bindParam(':email', self::$data['email']);
		self::$result->bindParam(':first_name', self::$data['first_name']);
		self::$result->bindParam(':last_name', self::$data['last_name']);
		self::$result->bindParam(':hash', self::$hash);
	}

	/**
	 * Prepares query.
	 * Hashes password.
	 * Executes query.
	 *
	 * @method main
	 * @return {Boolean} On successfully registered.
	 */
	public static function main() {
		self::$result = Database::$conn->prepare(self::$query);
		self::$hash = password_hash(self::$data['password'], PASSWORD_BCRYPT);

		self::bindParams();
		
		if (self::$result->execute()) {
			return true;
		}
		else {
			return false;
		}
	}
}

Register::init();

?>