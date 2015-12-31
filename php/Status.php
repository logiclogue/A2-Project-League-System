<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Model for getting the status of the current user.
 *
 * @class Status
 * @extends Model
 * @static
 */
class Status extends Model
{
	/**
	 * The status object holds the status data.
	 *
	 * @property status_object
	 * @type Array
	 * @private
	 */
	private static $status_object;


	/**
	 * Method that stores user data in @property status_object.
	 *
	 * @method logged_in
	 * @private
	 */
	private static function logged_in() {
		self::$status_object['user'] = $_SESSION['user'];
	}

	/**
	 * Method that checks if the user is logged in.
	 * Also returns @property status_obejct.
	 *
	 * @method main
	 * @protected
	 * @return {Array} @property status_object.
	 */
	protected static function main() {
		self::$status_object = array('logged_in' => false);

		// if logged in
		if (isset($_SESSION['user']['id'])) {
			self::$status_object['logged_in'] = true;
			self::logged_in();
		}

		return self::$status_object;
	}
}

Status::init();

?>