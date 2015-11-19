<?php

require dirname(__DIR__) . '/php/Database.php';


class Login
{
	public static $json;

	private static $errorMsg = 'Incorrect email or password';


	public static function execute() {
		if (isset(self::$json)) {
			// decode json string
			$json = json_decode(self::$json, true);

			// extract data from json
			$email = $json['email'];
			$password = $json['password'];

			// sql query
			$query = Database::$conn->prepare('SELECT hash FROM users WHERE email=:email');
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->execute();

			// fetch relevant data
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			$hash = $result[0]['hash'];

			// check if password is correct
			if (password_verify($password, $hash)) {
				$_SESSION['id'] = $email;
			}

			$query->close();
		}
	}

	public static function init() {
		if (isset($_GET['json'])) {
			self::$json = $_GET['json'];
			self::execute();
		}
	}
}

Login::init();

?>