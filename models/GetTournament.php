<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Model that fetches tournament data based on id.
 *
 * @class GetTournament
 * @extends Model
 * @static
 */
/**
 * @param id {Integer} Id of the tournament.
 *
 * @return name {String} Name of the tournament.
 * @return description {String} Description of the tournament.
 * @return league_managers {Array} Array of league managers.
 *  @return league_managers[] {Object} Result of @class GetUser for each league manager.
 * @return players {Array} Array of players in the tournament.
 *  @return players[] {Object} Result of @class GetUser for each player.
 */
class GetTournament extends Model
{
	/**
	 * SQL query string for fetching tournament data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private static $query = <<<SQL
		SELECT name, description
		FROM tournaments
		WHERE id = :id
SQL;
	/**
	 * SQL query string for fetching the players in the tournament.
	 *
	 * @property query_players
	 * @type String
	 * @private
	 */
	private static $query_players = <<<SQL
		SELECT u.first_name, u.last_name
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
	 * @private
	 */
	private static $query_league_managers = <<<SQL
		SELECT u.first_name, u.last_name
		FROM users u
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u.id
		WHERE tu.tournament_id = :id AND tu.is_league_manager = true
SQL;

	/**
	 * Array to be returned containing all tournament data.
	 *
	 * @property tournament
	 * @type Array
	 * @private
	 */
	private static $tournament = array();


	private static function getData($query, &$variable) {
		$stmt = Database::$conn->prepare($query);

		$stmt->bindParam(':id', self::$data['id']);

		if ($stmt->execute()) {
			$variable = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return true;
		}
		else {
			return false;
		}
	}

	private static function getPlayers() {
		return self::getData(self::$query_players, self::$tournament['players']);
	}

	private static function getLeagueManagers() {
		return self::getData(self::$query_league_managers, self::$tournament['league_managers']);
	}

	private static function getTournamentData() {
		$is_success = self::getData(self::$query, self::$tournament);

		self::$tournament = self::$tournament[0];

		return $is_success;
	}

	/**
	 * Method that fetches the database info.
	 *
	 * @method main
	 * @protected
	 * @return {Array} Tournament data.
	 */
	protected static function main() {
		if (self::getTournamentData() && self::getPlayers() && self::getLeagueManagers()) {
			return self::$tournament;
		}
		else {
			return false;
		}
	}
}

?>