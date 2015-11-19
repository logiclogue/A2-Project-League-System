<?php

require dirname(__DIR__) . '/php/Database.php';


class Register
{
	public static function init() {
		$json = json_decode($_GET['json'], true);

		$email = $json['email'];
		$first_name = $json['first_name'];
		$last_name = $json['last_name'];
		$password = $json['password'];

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$query = Database::$conn->prepare("INSERT INTO users (email, first_name, last_name, hash) VALUES (:email, :first_name, :last_name, :hash)");
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