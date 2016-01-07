<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Model for users to create tournaments.
 *
 * @class CreateTournament
 * @extends Model
 * @static
 */
class CreateTournament extends Model
{
	/**
	 * SQL query string for creating a tournament.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		INSERT INTO tournaments (name, description)
		VALUES (:name, :description)
SQL;

	/**
	 * Statement object for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Main function for 
	 *
	 * @method create
	 * @private
	 * @return {Boolean} Whether success of creating a tournament.
	 */
	private static function create() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':name', self::$data['name']);
		self::$stmt->bindParam(':description', self::$data['description']);

		return self::$stmt->execute();
	}

	/**
	 * Main function for checking whether user is logged in.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} @method create.
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			return self::create();
		}
		else {
			return false;
		}
	}
}

CreateTournament::init();

?>