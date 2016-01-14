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
/**
 * @param first_name {String} The new first name of the user.
 * @param last_name {String} The new last name of the user.
 * @param home_phone {String} The new home phone number of the user.
 * @param mobile_phone {String} THe new mobile phone number of the user.
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
		first_name = CASE WHEN :first_name IS NULL THEN first_name ELSE :first_name END,
		last_name = CASE WHEN :last_name IS NULL THEN last_name ELSE :last_name END,
		home_phone = :home_phone,
		mobile_phone = :mobile_phone
		WHERE id = :id
SQL;

	/**
	 * Database object variable.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Main method once @method main has checked login.
	 *
	 * @method update
	 * @private
	 */
	private static function update() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':id', $_SESSION['user']['id']);
		self::$stmt->bindParam(':first_name', self::$data['first_name']);
		self::$stmt->bindParam(':last_name', self::$data['last_name']);
		self::$stmt->bindParam(':home_phone', self::$data['home_phone']);
		self::$stmt->bindParam(':mobile_phone', self::$data['mobile_phone']);

		if (!self::$stmt->execute()) {
			self::$success = false;
		}
	}

	/**
	 * Checks to see if the user is logged in.
	 * Calls @method update if true.
	 *
	 * @method main
	 * @protected
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			self::update();
		}
		else {
			self::$success = false;
		}
	}
}

UpdateUser::init();

?>