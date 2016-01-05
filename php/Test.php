<?php

require_once(dirname(__DIR__) . '/models/Login.php');
require_once(dirname(__DIR__) . '/models/Register.php');
require_once(dirname(__DIR__) . '/models/Status.php');
require_once(dirname(__DIR__) . '/models/Logout.php');
require_once(dirname(__DIR__) . '/models/UpdateUser.php');


/**
 * Class for testing PHP models.
 *
 * @class Test
 * @static
 */
class Test
{
	private static function echo_n($data) {
		echo (json_encode($data, JSON_PRETTY_PRINT)) . '<br>';
	}


	private static function login() {
		return Login::call(array(
			'email' => 'test',
			'password' => 'password'
		));
	}

	public static function init() {
		/*$reg = Register::call(array(
			'email' => 'another',
			'password' => 'password',
			'first_name' => 'John',
			'last_name' => 'Doe'
		));*/
		$test = self::login();

		//self::echo_n($reg);
		self::echo_n($test);
		self::echo_n(Status::call(array()));
		
		Logout::call(array());
		
		self::echo_n(Status::call(array()));
		self::echo_n($_SESSION);

		self::login();
		self::echo_n(UpdateUser::call(array(
			'first_name' => 'Jordan',
			'last_name' => 'Lord',
			'home_phone' => null,
			'mobile_phone' => null
		)));
	}
}

Test::init();

?>