<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Model that fetches tournament data based on id.
 *
 * @class TournamentGet
 * @extends Model
 */
/**
 * @param id {Integer} Id of the tournament.
 *
 * @return name {String} Name of the tournament.
 * @return description {String} Description of the tournament.
 * @return league_managers {Array} Array of league managers.
 *  @return league_managers[] {Object} Result of @class UserGet for each league manager.
 * @return players {Array} Array of players in the tournament.
 *  @return players[] {Object} Result of @class UserGet for each player.
 */
class TournamentGet extends Model
{
	/**
	 * SQL query string for fetching tournament data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
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
	private $query_players = <<<SQL
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
	private $query_league_managers = <<<SQL
		SELECT u.first_name, u.last_name
		FROM users u
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u.id
		WHERE tu.tournament_id = :id AND tu.is_league_manager = true
SQL;


	/**
	 * Method that queries players in the tournament.
	 *
	 * @method getPlayers
	 * @private
	 */
	private function getPlayers() {
		$stmt = Database::$conn->prepare($this->query_players);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data['players'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->success = false;
		}
	}

	/**
	 * Method that queries league managers in the tournament.
	 *
	 * @method getLeagueManagers
	 * @private
	 */
	private function getLeagueManagers() {
		$stmt = Database::$conn->prepare($this->query_league_managers);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data['league_managers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->success = false;
		}
	}

	/**
	 * Method that gets the data about the tournament.
	 *
	 * @method getTournamentData
	 * @private
	 */
	private function getTournamentData() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
		}
		else {
			$this->success = false;
		}
	}

	/**
	 * Method that fetches the database info.
	 *
	 * @method main
	 * @protected
	 * @return {Array} Tournament data.
	 */
	protected function main() {
		$this->getTournamentData();
		$this->getPlayers();
		$this->getLeagueManagers();
	}
}

$TournamentGet = new TournamentGet();

?>