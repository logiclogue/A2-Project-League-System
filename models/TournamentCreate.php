<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');
require_once(dirname(__DIR__) . '/models/TournamentUserAttach.php');

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
	 * Query for making the creator of the league a league manager.
	 *
	 * @property query_add_league_manager
	 * @type String
	 * @private
	 */
	private static $query_add_league_manager = <<<SQL
		INSERT INTO tournament_user_maps (tournament_id, user_id, is_league_manager, is_player)
		VALUES (:tournament_id, :user_id, 1, 0)
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
	 * @method addLeagueManager
	 * @private
	 */
	private static function addLeagueManager() {
		$stmt = Database::$conn->prepare(self::$query_add_league_manager);

		$stmt->bindParam(':user_id', $_SESSION['user']['id']);
		// Bind the tournament id as the last insert id.
		$stmt->bindParam(':tournament_id', Database::$conn->lastInsertId());

		if (!$stmt->execute() || $stmt->rowCount() != 1) {
			self::$error_msg = "Failed to add you as a league manager";
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
			self::$error_msg = "Failed to execute query";
			self::$success = false;
		}
		else {
			// Add league manager if didn't fail.
			self::addLeagueManager();
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
		}
		else {
			self::$error_msg = "You must be logged in";
			self::$success = false;
		}
	}
}

TournamentCreate::init();

?>