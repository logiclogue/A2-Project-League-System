<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Model for querying a user based on the id.
 *
 * @class GetUser
 * @extends Model
 * @static
 */
/**
 * @param id {Integer} Id of the user to be fetched.
 */
class GetUser extends Model
{
	/**
	 * SQL query string for fetching the user's data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		SELECT first_name, last_name
		FROM users
		WHERE id = :id
SQL;


	/**
	 * Main method.
	 *
	 * @method main
	 * @protected
	 * @return {Array} User data.
	 */
	protected static function main() {
		$stmt = Database::$conn->prepare(self::$query);

		$stmt->bindParam(':id', self::$data['id']);

		if ($stmt->execute()) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			return false;
		}
	}
}

GetUser::init();

?>