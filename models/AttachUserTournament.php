<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Model used by a league manager to attach a user to their league.
 *
 * @class AttachUserTournament
 * @extends Model
 * @static
 */
/**
 * @param user_id {Integer} Id of the user that is going to be attached to the tournament.
 * @param tournament_id {Integer} Id of the tournament that the user is going to be attached to.
 * @param is_league_manager {Boolean} Whether the attached user is a league manager.
 * @param is_player {Boolean} Whether the attached user is playing in the tournament.
 */
class AttachUserTournament extends Model
{
	/**
	 * SQL query string for attaching a player a player to a tournament.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		INSERT INTO tournament_user_maps (user_id, tournament_id, is_league_manager, is_player)
		VALUES (:user_id, :tournament_id, :is_league_manager, :is_player)
SQL;


	/**
	 * Main method once checked login.
	 *
	 * @method attach
	 * @private
	 * @return {Boolean} Whether successfully attached to a tournament. 
	 */
	private static function attach() {
		$stmt = Database::$conn->prepare(self::$query);

		$stmt->bindParam(':user_id', self::$data['user_id']);
		$stmt->bindParam(':tournament_id', self::$data['tournament_id']);
		$stmt->bindParam(':is_league_manager', self::$data['is_league_manager']);
		$stmt->bindParam(':is_player', self::$data['is_player']);

		return $stmt->execute();
	}

	/**
	 * Method that checks login.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether successfully attached to a tournament.
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			return self::attach();
		}
		else {
			return false;
		}
	}
}

AttachUserTournament::init();

?>