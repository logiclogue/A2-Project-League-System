<?php

require_once(dirname(__DIR__) . '/php/Login.php');
require_once(dirname(__DIR__) . '/php/Register.php');
require_once(dirname(__DIR__) . '/php/Status.php');
require_once(dirname(__DIR__) . '/php/Logout.php');


/**
 * Class for testing PHP models.
 *
 * @class Test
 * @static
 */
class Test
{
	private static function echo_n($data) {
		echo json_encode($data, JSON_PRETTY_PRINT) . '<br>';
	}


	public static function init() {
		/*$reg = Register::call(array(
			'email' => 'another',
			'password' => 'password',
			'first_name' => 'John',
			'last_name' => 'Doe'
		));*/
		$test = Login::call(array('email' => 'test', 'password' => 'password'));

		//self::echo_n($reg);
		self::echo_n($test);
		self::echo_n(Status::call(array()));
		Logout::call(array());
		self::echo_n(Status::call(array()));
		self::echo_n($_SESSION);
	}
}

Test::init();

?>