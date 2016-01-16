<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');


/**
 * Parent class for general tournament stuff.
 *
 * @class Tournament
 * @extends Model
 * @static
 */
class Tournament extends Model
{
	/**
	 * SQL query string for fetching the players in the tournament.
	 *
	 * @property query_players
	 * @type String
	 * @protected
	 */
	protected static $query_players = <<<SQL
		SELECT u.id, u.first_name, u.last_name
		FROM users u
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u.id
		WHERE tu.tournament_id = :id AND tu.is_player = true
SQL;
	/**
	 * SQL query string for fetching the league managers of the tournament.
	 *
	 * @property query_leauge_managers
	 * @type String
	 * @protected
	 */
	protected static $query_league_managers = <<<SQL
		SELECT u.id, u.first_name, u.last_name
		FROM users u
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u.id
		WHERE tu.tournament_id = :id AND tu.is_league_manager = true
SQL;

	/**
	 * SQL query string for checking whether the user is a player in a particular league.
	 *
	 * @property query_player_count
	 * @type String
	 * @private
	 */
	private static $query_player_count = <<<SQL
		SELECT COUNT(*)
		FROM tournament_user_maps
		WHERE
		tournament_id = :tournament_id AND
		user_id = :user_id AND
		is_player = 1
SQL;
	/**
	 * SQL query string for checking whether the user is league manager of a particular league.
	 *
	 * @property query_league_manager_count
	 * @type String
	 * @private
	 */
	private static $query_league_manager_count = <<<SQL
		SELECT COUNT(*)
		FROM tournament_user_maps
		WHERE
		tournament_id = :tournament_id AND
		user_id = :user_id AND
		is_league_manager = 1
SQL;
	/**
	 * SQL query string for checking whether a tournament exists.
	 *
	 * @property query_tournament_count
	 * @type String
	 * @private
	 */
	protected static $query_tournament_count = <<<SQL
		SELECT COUNT(*)
		FROM tournaments
		WHERE id = :id
SQL;
	/**
	 * SQL query for attaching a user to a tournament.
	 *
	 * @property query_attach
	 * @type String
	 * @private
	 */
	private static $query_attach = <<<SQL
		INSERT INTO tournament_user_maps (tournament_id, user_id, is_player, is_league_manager)
		VALUES (:tournament_id, :user_id, FALSE, FALSE)
SQL;


	/**
	 * Method for telling whether the current user is a player in the tournament.
	 *
	 * @method isPlayer
	 * @protected
	 * @param user_id {Integer} Id of the user to query.
	 * @param tournament_id {Integer} Id of the tournament to query.
	 * @return {Boolean} Whether the user is a player in that tournament.
	 */
	protected static function isPlayer($user_id, $tournament_id) {
		$stmt = Database::$conn->prepare(self::$query_player_count);

		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':tournament_id', $tournament_id);

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
	 * Method for telling whether the current user is a league manager is the tournament.
	 *
	 * @method isLeagueManager
	 * @protected
	 * @param user_id {Integer} Id of the user to query.
	 * @param tournament_id {Integer} Id of the tournament to query.
	 * @return {Boolean} Whether the user is a league manager in that tournament.
	 */
	protected static function isLeagueManager($user_id, $tournament_id) {
		$stmt = Database::$conn->prepare(self::$query_league_manager_count);

		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':tournament_id', $tournament_id);

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
	 * Method for checking whether a tournament exists
	 *
	 * @method isTournament
	 * @protected
	 * @param id {Integer} Id of the tournament.
	 * @return {Boolean} Whether the tournament exists.
	 */
	protected static function isTournament($id) {
		$stmt = Database::$conn->prepare(self::$query_tournament_count);

		$stmt->bindParam(':id', $id);

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
	 * Attaches a user to a tournament.
	 *
	 * @method attachUser
	 * @protected
	 * @param tournament_id {Integer} Id of the tournament.
	 * @param user_id {Integer} Id of the user.
	 * @return {Boolean} Whether successful.
	 */
	protected static function attachUser($tournament_id, $user_id) {
		$stmt = Database::$conn->prepare(self::$query_attach);

		$stmt->bindParam(':tournament_id', $tournament_id);
		$stmt->bindParam(':user_id', $user_id);

		if ($stmt->execute()) {
			return true;
		}
		else {
			return false;
		}
	}
}

?>