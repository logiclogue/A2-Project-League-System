<?php

class Database
{
	public static $conn;


	public static function main() {
		$string = file_get_contents("../env.json");
		$data = json_decode($string, true);
		$connData = $data["database"];

		self::$conn = new mysqli($connData["servername"], $connData["username"], $connData["password"], $connData["database"]);

		if (self::$conn->connect_error) {
			die("Connection failed" . self::$conn->connect_error);
		}
	}
}

Database::main();

?>