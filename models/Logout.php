<?php

require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Logout model called when the user logs out.
 *
 * @class Logout
 * @extends Model
 * @static
 */
/**
 */
class Logout extends Model
{
	/**
	 * Method that destroys the session.
	 *
	 * @method main
	 * @protected
	 */
	protected static function main() {
		session_unset();
		session_destroy();
	}
}

Logout::init();

?>