<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');
require_once(dirname(__DIR__) . '/models/TournamentUserUpdate.php');

session_start();


/**
 * Model for users to create tournaments.
 *
 * @class TournamentCreate
 * @extends Tournament
 * @static
 */
/**
 * @param name {String} The name of the tournament.
 * @param description {String} The description of the tournament.
 */
class TournamentCreate extends Tournament
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
	 * Method for attaching the current user as the league manager.
	 *
	 * @method attachLeagueManager
	 * @private
	 */
	private static function attachLeagueManager() {
		if (!TournamentUserUpdate::call(array(
			'user_id' => $_SESSION['user']['id'],
			'tournament_id' => Database::$conn->lastInsertId(),
			'is_league_manager' => true,
			'is_player' => false
		))['success']) {
			self::$success = false;
		}
	}

	/**
	 * Main function for creating database object, binding params, and executing query.
	 *
	 * @method create
	 * @private
	 */
	private static function create() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':name', self::$data['name']);
		self::$stmt->bindParam(':description', self::$data['description']);

		if (!self::$stmt->execute()) {
			self::$success = false;
		}
	}

	/**
	 * Main function for checking whether user is logged in.
	 *
	 * @method main
	 * @protected
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			self::create();
			self::attachLeagueManager();
		}
		else {
			self::$success = false;
		}
	}
}

TournamentCreate::init();

?>