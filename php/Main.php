<?php

require_once(dirname(__DIR__) . '/php/Login.php');
require_once(dirname(__DIR__) . '/php/Register.php');
require_once(dirname(__DIR__) . '/php/Status.php');
require_once(dirname(__DIR__) . '/php/Logout.php');


class Main
{
	public static function init() {
		/*$reg = Register::call(array(
			'email' => 'another',
			'password' => 'password',
			'first_name' => 'John',
			'last_name' => 'Doe'
		));*/
		$test = Login::call(array('email' => 'test', 'password' => 'password'));

		echo json_encode($reg);
		echo json_encode($test);
		echo json_encode(Status::call());
		Logout::call();
		echo json_encode(Status::call());
	}
}

Main::init();

?>