<?php

require dirname(__DIR__) . '/php/Database.php';


class Status
{
	private static $status_object = array('logged_in' => false);


	private static function printStatus() {
		die(json_encode(self::$status_object));
	}

	public static function init() {
		if (isset($_SESSION['id'])) {
			self::$status_object['logged_in'] = true;

			self::printStatus();
		}
		else {
			self::printStatus();
		}
	}
}

Status::init();

?>