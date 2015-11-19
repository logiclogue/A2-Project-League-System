<?php

require dirname(__DIR__) . '/php/Database.php';


class Login
{
	public static function init() {
		$email = $_GET['email'];
		$password = $_GET['password'];

		$query = Database::$conn->prepare('SELECT hash FROM users WHERE email=:email');
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();

		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$hash = $result[0]['hash'];

		if (password_verify($password, $hash)) {
			die('logged in');
		}
		else {
			die('incorrect email or password');
		}

		$query->close();
	}
}

Login::init();

?>