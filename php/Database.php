<?php

class Database
{
	public static $conn;


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

	public static function init() {
		$string = file_get_contents(dirname(__DIR__) . '/env.json');
		$data = json_decode($string, true);
		$connData = $data['database'];

		self::$conn = new PDO('mysql:host=' . $connData['servername'] . ';dbname=' . $connData['database'], $connData['username'], $connData['password']);
	}
}

Database::init();

?>