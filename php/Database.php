<?php

class Database
{
	public static $conn;


	public static function init() {
		$string = file_get_contents(dirname(__DIR__) . '/env.json');
		$data = json_decode($string, true);
		$connData = $data['database'];

		self::$conn = new PDO('mysql:host=' . $connData['servername'] . ';dbname=' . $connData['database'], $connData['username'], $connData['password']);

		if (self::$conn->connect_error) {
			die('Connection failed' . self::$conn->connect_error);
		}
	}
}

Database::init();

?>