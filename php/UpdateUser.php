<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * This model is used to update user details.
 *
 * @class UpdateUser
 * @extends Model
 * @static
 */
class UpdateUser extends Model
{
	/**
	 * SQL query string to update the user's data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		UPDATE users
		SET
		first_name = :first_name
		last_name = :last_name
		home_phone = :home_phone
		mobile_number = :mobile_number
		WHERE id = :id
SQL;


	/**
	 * 
	 *
	 * @method update
	 * @private
	 * @return {Boolean} Whether successfully updated.
	 */
	private static function update() {

	}

	/**
	 * Checks to see if the user is logged in.
	 * Calls @method update if true.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether successfully updated.
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			return self::update();
		}
		else {
			return false;
		}
	}
}

?>