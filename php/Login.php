<?php

require "Database.php";


class Login
{
	public static function main() {
		$email = $_GET["email"];
		$password = $_GET["password"];
		$query = Database::$conn->prepare("SELECT hash FROM members WHERE email=?");
		$query->bind_param("s", $email);
		$query->execute();
		$query->bind_result($hash);
		$query->fetch();

		if (password_verify($password, $hash)) {
			die("logged in");
		}
		else {
			die("incorrect email or password");
		}

		$query->close();
	}
}

Login::main();

?>