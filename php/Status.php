<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


class Status extends Model
{
	private static $status_object = array('logged_in' => false);


	private static function getStatus() {
		return self::$status_object;
	}

	public static function main() {
		if (isset($_SESSION['id'])) {
			self::$status_object['logged_in'] = true;
		}

		return self::getStatus();
	}
}

Status::init();

?>