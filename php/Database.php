<?php

/**
 * The Database class connects the the database when the file is included.
 *
 * @class Database
 */
class Database
{
	/**
	 * This variable is the connection variable for connecting to the database.
	 *
	 * @property conn
	 * @type Object
	 * @static
	 */
	public static $conn;
	/**
	 * SQL query string for deleting all tables
	 *
	 * @property query_delete
	 * @type String
	 * @private
	 * @static
	 */
	private static $query_delete = <<<SQL
		DROP TABLE `results`, `result_user_maps`, `tournaments`, `tournament_user_maps`, `users`
SQL;


	/**
	 * This method is used to create the tables and columns in the database.
	 * The `database.sql` file provides the SQL query string to do this.
	 *
	 * @method create
	 * @public
	 * @static
	 * @return {Boolean} Whether success.
	 */
	public static function create() {
		$query = file_get_contents(dirname(__DIR__) . '/database.sql');
		$stmt = self::$conn->prepare($query);

		return $stmt->execute();
	}

	/**
	 * Method that deletes all the tables in the database.
	 *
	 * @method delete
	 * @public
	 * @static
	 * @return {Boolean} Whether success.
	 */
	public static function delete() {
		$stmt = self::$conn->prepare(self::$query_delete);

		$stmt->execute();

		// Issues when with this query because it doesn't change any rows.
		return true;
	}

	/**
	 * Resets database.
	 * Deletes then recreates.
	 *
	 * @method reset
	 * @public
	 * @static
	 * @return {Boolean} Whether success.
	 */
	public static function reset() {
		$delete_success = self::delete();
		$create_success = self::create();

		return $delete_success && $create_success;
	}

	/**
	 * This method is called when the file is included.
	 * It is used to connect to the database.
	 * Also to set @property conn to new PDO.
	 *
	 * @method init
	 * @public
	 * @static
	 */
	public static function init() {
		$string = file_get_contents(dirname(__DIR__) . '/env.json');
		$data = json_decode($string, true);
		$connData = $data['database'];

		self::$conn = new PDO('mysql:host=' . $connData['servername'] . ';dbname=' . $connData['database'], $connData['username'], $connData['password']);
	}
}


// @method init called straight away.
Database::init();

?>