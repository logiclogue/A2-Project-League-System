<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/models/Tournament.php');
require_once(dirname(__DIR__) . '/models/TournamentUserAttach.php');

session_start();


/**
 * Method for adding a user as a player to a tournament.
 *
 * @class TournamentPlayerAdd
 * @extends Tournament
 * @static
 */
/**
 * @param user_id {Integer} Id of the user to be added to the tournament.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentPlayerAdd extends Tournament
{
	/**
	 * SQL query string for changing a user to a player.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_player = true
		WHERE
		user_id = :user_id AND
		tournament_id = :tournament_id
SQL;

	/**
	 * Database object for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Checks any faults and executes query.
	 *
	 * @method executeQuery
	 * @private
	 */
	private static function executeQuery() {
		if (!self::$stmt->execute() || self::$stmt->rowCount() != 1) {
			self::$success = false;
		}
	}

	/**
	 * Main method for making the user a player in the tournament.
	 *
	 * @method add
	 * @private
	 */
	private static function add() {
		// Attach user if not already.
		TournamentUserAttach::call(array(
			'user_id' => self::$data['user_id'],
			'tournament_id' => self::$data['tournament_id']
		));

		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':user_id', self::$data['user_id']);
		self::$stmt->bindParam(':tournament_id', self::$data['tournament_id']);

		// Verify whether the user can carry out the action.
		if (self::$data['user_id'] == $_SESSION['user']['id'] || self::isLeagueManager($_SESSION['user']['id'])) {
			self::executeQuery();
		}
		else {
			self::$success = false;
		}
	}

	/**
	 * Method that checks whether the user is logged in.
	 *
	 * @method main
	 * @protected
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			self::add();
		}
		else {
			self::$success = false;
		}
	}
}

?>