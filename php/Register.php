<?php

require "Database.php";


class Register
{
	public static function init() {
		$email = $_GET["email"];
		$first_name = $_GET["first_name"];
		$last_name = $_GET["last_name"];
		$password = $_GET["password"];

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$query = $conn->prepare("INSERT INTO members (email, first_name, last_name, hash) VALUES (?, ?, ?, ?)");
		$query->bind_param("ssss", $email, $first_name, $last_name, $hash);
		$query->execute();

		die("success");
	}
}

Register::init();

?>