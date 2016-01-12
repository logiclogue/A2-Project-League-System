<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');


/**
 * Model that fetches tournament data based on id.
 *
 * @class GetTournament
 * @extends Tournament
 * @static
 */
/**
 * @param id {Integer} Id of the tournament.
 *
 * @return name {String} Name of the tournament.
 * @return description {String} Description of the tournament.
 * @return league_managers {Array} Array of league managers.
 *  @return league_managers[] {Object} Result of @class GetUser for each league manager. // !!!
 * @return players {Array} Array of players in the tournament.
 *  @return players[] {Object} Result of @class GetUser for each player. // !!!
 */
class GetTournament extends Tournament
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
	 * Array to be returned containing all tournament data.
	 *
	 * @property tournament
	 * @type Array
	 * @private
	 */
	private static $tournament = array();


	/**
	 * Method that queries players in the tournament.
	 *
	 * @method getPlayers
	 * @private
	 * @return {Boolean} Whether successfully retrieved data.
	 */
	private static function getPlayers() {
		return self::getData(self::$data['id'], self::$query_players, self::$tournament['players']);
	}

	/**
	 * Method that queries league managers in the tournament.
	 *
	 * @method getLeagueManagers
	 * @private
	 * @return {Boolean} Whether successfully retrieved data.
	 */
	private static function getLeagueManagers() {
		return self::getData(self::$data['id'], self::$query_league_managers, self::$tournament['league_managers']);
	}

	/**
	 * Method that gets the data about the tournament.
	 *
	 * @method getTournamentData
	 * @private
	 * @return {Boolean} Whether successfully retrieved data.
	 */
	private static function getTournamentData() {
		$is_success = self::getData(self::$data['id'], self::$query, self::$tournament);

		// only one tournament, so set it equal to first result.
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