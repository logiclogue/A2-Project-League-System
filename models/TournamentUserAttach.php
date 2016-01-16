<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/models/Tournament.php');

session_start();


/**
 * Model that can attach a user to a particular tournament.
 *
 * @class TournamentUserAttach
 * @extends Tournament
 * @static
 */
/**
 * @param user_id {Integer} Id of the user to attach.
 * @param tournament_id {Integer} Id of the tournament to attach to.
 */
class TournamentUserAttach extends Tournament
{
	/**
	 * SQL query string for attaching a user.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		INSERT INTO tournament_user_maps (user_id, tournament_id, is_player, is_league_manager)
		VALUES (:user_id, :tournament_id, FALSE, FALSE)
SQL;
	/**
	 * SQL query to see if user is already attached to the tournament.
	 *
	 * @property query_is_attached
	 * @type String
	 * @private
	 */
	private static $query_is_attached = <<<SQL
		SELECT COUNT(*)
		FROM tournament_user_maps
		WHERE user_id = :user_id
SQL;

	/**
	 * Database statment object.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Method for checking whether the user is already attached to the tournament.
	 *
	 * @method isAttached
	 * @private
	 * @return {Boolean} Whether the user is attached to the tournament.
	 */
	private static function isAttached() {
		$stmt = Database::$conn->prepare(self::$query_is_attached);

		$stmt->bindParam(':user_id', self::$data['user_id']);

		if ($stmt->execute()) {
			if ($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT(*)'] == '1') {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	 * Method for executing the query.
	 *
	 * @method executeQuery
	 * @private
	 */
	private static function executeQuery() {
		if (!self::$stmt->execute()) {
			self::$error_msg = "Failed to execute query";

			self::$success = false;
		}
	}

	/**
	 * Method for verifying whether the user can carry out the task.
	 * Doesn't execute if:
	 * - Already in the tournament.
	 * - Either:
	 *   - Not a league manager.
	 *   - Attaching someone else.
	 *
	 * @method verify
	 * @private
	 * @return {Boolean} Whether can.
	 */
	private static function verify() {
		$is_league_manager = self::isLeagueManager($_SESSION['user']['id'], self::$data['tournament_id']);

		if (self::isAttached()) {
			self::$error_msg = 'Already attached to the tournament';

			return false;
		}
		else if (!$is_league_manager || self::$data['user_id'] == self::$_SESSION['user']['id']) {
			self::$error_msg = "You don't have permission to do that";

			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Method once logged in, attaching a user.
	 *
	 * @method attach
	 * @private
	 */
	private static function attach() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::$stmt->bindParam(':user_id', self::$data['user_id']);
		self::$stmt->bindParam(':tournament_id', self::$data['tournament_id']);

		if (self::verify()) {
			self::executeQuery();
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
			self::attach();
		}
		else {
			self::$error_msg = "You must be logged in";

			self::$success = false;
		}
	}
}

?>
