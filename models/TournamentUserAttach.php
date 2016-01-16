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
	 * Method once logged in, attaching a user.
	 *
	 * @method attach
	 * @private
	 */
	private static function attach() {
		$stmt = Database::$conn->prepare(self::$query);

		$is_league_manager = self::isLeagueManager($_SESSION['user']['id'], self::$data['tournament_id']);
		$is_player = self::isPlayer($_SESSION['user']['id'], self::$data['tournament_id']);

		$stmt->bindParam(':user_id', self::$data['user_id']);
		$stmt->bindParam(':tournament_id', self::$data['tournament_id']);

		if (!$is_league_manager && self::$data['user_id'] != $_SESSION['user']['id']) {
			self::$success = false;

			return;
		}

		if (!$stmt->execute()) {
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
			self::attach();
		}
	}
}

?>
