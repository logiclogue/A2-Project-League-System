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
	 *
	 *
	 *
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
	 *
	 *
	 *
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
	 * Method for executing queries and retrieving data.
	 *
	 * @method getData
	 * @protected
	 * @param id {Integer} Id to be bound to the query string.
	 * @param query {String} Query string to be executed.
	 * @param variable {Array} Array to hold result from query.
	 * @return {Boolean} Whether successfully executes query.
	 */
	protected static function getData($id, $query, &$variable) {
		$stmt = Database::$conn->prepare($query);

		$stmt->bindParam(':id', $id);

		if ($stmt->execute()) {
			$variable = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Method for telling whether the current user is a player in the tournament.
	 *
	 * @method isPlayer
	 * @protected
	 */
	protected static function isPlayer($id) {
		
	}

	/**
	 * Method for telling whether the current user is a league manager is the tournament.
	 *
	 * @method isLeagueManager
	 * @protected
	 */
	protected static function isLeagueManager() {

	}
}

?>