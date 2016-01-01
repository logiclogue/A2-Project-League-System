<?php

require_once(dirname(__DIR__) . '/php/Login.php');
require_once(dirname(__DIR__) . '/php/Register.php');
require_once(dirname(__DIR__) . '/php/Status.php');
require_once(dirname(__DIR__) . '/php/Logout.php');


/**
 * Class for testing PHP models.
 *
 * @class Main
 * @static
 */
class Main
{
	private static function echo_n($data) {
		echo json_encode($data) . '<br>';
	}


	public static function init() {
		/*$reg = Register::call(array(
			'email' => 'another',
			'password' => 'password',
			'first_name' => 'John',
			'last_name' => 'Doe'
		));*/
		$test = Login::call(array('email' => 'test', 'password' => 'password'));

		self::echo_n($reg);
		self::echo_n($test);
		self::echo_n(Status::call());
		Logout::call();
		self::echo_n(Status::call());
	}
}

Main::init();

?>