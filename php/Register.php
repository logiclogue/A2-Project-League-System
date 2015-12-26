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
	
	private static $result;
	private static $hash;


	private static function bindParams() {
		self::$result->bindParam(':email', self::$data['email']);
		self::$result->bindParam(':first_name', self::$data['first_name']);
		self::$result->bindParam(':last_name', self::$data['last_name']);
		self::$result->bindParam(':hash', $hash);
	}

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