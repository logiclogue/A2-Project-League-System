<?php

/**
 * The Database class connects the the database when the file is included.
 *
 * @class Database
 * @static
 */
class Database
{
	/**
	 * This variable is the connection variable for connecting to the database.
	 *
	 * @property conn
	 * @type Object
	 */
	public static $conn;


	/**
	 * This method is used to create the tables and columns in the database.
	 * It `database.sql` file provides the SQL to do this.
	 *
	 * @method create
	 */
	public static function create() {
		$query = file_get_contents(dirname(__DIR__) . '/database.sql');
		$result = self::$conn->prepare($query);

		if ($result->execute()) {
			echo 'Success';
		}
		else {
			echo 'Failure';
		}
	}

	/**
	 * This method is called when the file is included.
	 * It is used to connect to the database.
	 * Also to set @property conn to new PDO.
	 *
	 * @method init
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