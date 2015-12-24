<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


class Register extends Model
{
	private static $query = <<<SQL
		INSERT INTO users (email, first_name, last_name, hash)
		VALUES (:email, :first_name, :last_name, :hash)
SQL;


	public static function main() {
		$email = self::$data['email'];
		$first_name = self::$data['first_name'];
		$last_name = self::$data['last_name'];
		$password = self::$data['password'];

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$query = Database::$conn->prepare(self::$query);
		$query->bindParam(':email', $email);
		$query->bindParam(':first_name', $first_name);
		$query->bindParam(':last_name', $last_name);
		$query->bindParam(':hash', $hash);
		
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