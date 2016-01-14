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
	private static $query = <<<SQL
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
	private static $stmt;
	/**
	 * Hash of the password entered.
	 *
	 * @property hash
	 * @type String
	 * @private
	 */
	private static $hash;


	/**
	 * Used to bind the parameters to @property query.
	 * Data inputted by user is bound.
	 *
	 * @method bindParams
	 * @private
	 */
	private static function bindParams() {
		self::$stmt->bindParam(':email', self::$data['email']);
		self::$stmt->bindParam(':first_name', self::$data['first_name']);
		self::$stmt->bindParam(':last_name', self::$data['last_name']);
		self::$stmt->bindParam(':hash', self::$hash);
	}

	/**
	 * Prepares query.
	 * Hashes password.
	 * Executes query.
	 *
	 * @method main
	 * @public
	 */
	public static function main() {
		self::$stmt = Database::$conn->prepare(self::$query);
		self::$hash = password_hash(self::$data['password'], PASSWORD_BCRYPT);

		self::bindParams();
		
		if (!self::$stmt->execute()) {
			self::$success = false;
		}
	}
}

Register::init();

?>