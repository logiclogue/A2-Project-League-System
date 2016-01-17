<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Model for querying a user based on the id.
 *
 * @class UserGet
 * @extends Model
 * @static
 */
/**
 * @param id {Integer} Id of the user to be fetched.
 *
 * @return id {Integer} Id of the user.
 * @return first_name {String} First name of the user.
 * @return last_name {String} Last name of the user.
 */
class UserGet extends Model
{
	/**
	 * SQL query string for fetching the user's data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		SELECT first_name, last_name, id
		FROM users
		WHERE id = :id
SQL;

	/**
	 * Database object for executing query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Method that verifies whether the requested user is the one returned.
	 *
	 * @method verifyResult
	 * @private
	 * @return {Boolean} Whether the result matches request.
	 */
	private static function verifyResult() {
		if (self::$return_data['id'] == self::$data['id']) {
			return true;
		}
		else {
			self::$error_msg = "User doesn't exist";
			self::$success = false;

			return false;
		}
	}

	/**
	 * Method that executes the query.
	 *
	 * @method executeQuery
	 * @private
	 * @return {Boolean} Whether executed query successfully.
	 */
	private static function executeQuery() {
		if (self::$stmt->execute()) {
			self::$return_data = self::$stmt->fetchAll(PDO::FETCH_ASSOC)[0];

			return true;
		}
		else {
			self::$error_msg = "Failed to execute query";
			self::$success = false;

			return false;
		}
	}

	/**
	 * Main method.
	 *
	 * @method main
	 * @protected
	 */
	protected static function main() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':id', self::$data['id']);

		if (self::executeQuery()) {
			self::verifyResult();
		}
	}
}

UserGet::init();

?>