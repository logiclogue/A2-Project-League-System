<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


/**
 * Model that fetches tournament data based on id.
 *
 * @class TournamentGet
 * @extends Tournament
 */
/**
 * @param id {Integer} Id of the tournament.
 *
 * @return id {Integer} Id of the tournament.
 * @return name {String} Name of the tournament.
 * @return description {String} Description of the tournament.
 * @return is_league_manager {Boolean} Whether the user calling is a league manager.
 * @return league_managers {Array} Array of league managers.
 *  @return league_managers[].id {Integer} Id of the league manager.
 *  @return league_managers[].first_name {String} First name of the league manager.
 *  @return league_managers[].last_name {String} Last name of the league manager.
 * @return players {Array} Array of players in the tournament.
 *  @return players[].id {Integer} Id of the player.
 *  @return players[].first_name {String} First name of the player.
 *  @return players[].last_name {String} Last name of the player.
 */
class TournamentGet extends Tournament
{
	/**
	 * SQL query string for fetching tournament data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT id, name, description
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
	 * @private
	 */
	private $query_league_managers = <<<SQL
		SELECT u.id, u.first_name, u.last_name
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


		// Shows whether the current user is a league manager.
		$this->return_data['is_league_manager'] = $this->isLeagueManager($_SESSION['user']['id'], $this->data['id']);
	}

	/**
	 * Method that fetches the database info.
	 *
	 * @method main
	 * @protected
	 * @return {Array} Tournament data.
	 */
	protected function main() {
		if ($this->tournamentExistsId($this->data['id'])) {
			$this->getTournamentData();
			$this->getPlayers();
			$this->getLeagueManagers();
		}
		else {
			$this->success = false;
			$this->error_msg = "Tournament doesn't exist";
		}
	}
}

$TournamentGet = new TournamentGet();

?>