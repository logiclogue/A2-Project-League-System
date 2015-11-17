<?php

require 'Database.php';


class Register
{
	public static function init() {
		$email = $_GET['email'];
		$first_name = $_GET['first_name'];
		$last_name = $_GET['last_name'];
		$password = $_GET['password'];

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$query = Database::$conn->prepare("INSERT INTO members (email, first_name, last_name, hash) VALUES (:email, :first_name, :last_name, :hash)");
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':first_name', $first_name, PDO::PARAM_STR);
		$query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
		$query->bindParam(':hash', $hash, PDO::PARAM_STR);
		
		if ($query->execute()) {
			die('Success');
		}
		else {
			die('Failure to create user');
		}
	}
}

Register::init();

?>