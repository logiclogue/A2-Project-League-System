<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Model for getting the status of the current user.
 *
 * @class Status
 * @extends Model
 */
/*&
 * @return logged_in {Boolean} Whether you are logged in.
 * @return user {Array} User data if logged in:
 *  @return user.id {Integer} Your id.
 *  @return user.email {String} Your email address.
 *  @return user.first_name {String} Your first name.
 *  @return user.last_name {String} Your last name.
 *
 */
class Status extends Model
{
	/**
	 * Method that stores user data in @property return_data.
	 *
	 * @method logged_in
	 * @private
	 */
	private function logged_in() {
		$this->return_data['user'] = $_SESSION['user'];
	}

	/**
	 * Method that checks if the user is logged in.
	 * Then sets @property return_data.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->return_data['logged_in'] = false;

		// if logged in
		if (isset($_SESSION['user'])) {
			$this->return_data['logged_in'] = true;
			$this->logged_in();
		}
	}
}

?>