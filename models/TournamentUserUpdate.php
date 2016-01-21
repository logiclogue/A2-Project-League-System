<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');
require_once(dirname(__DIR__) . '/models/TournamentGet.php');

session_start();


/**
 * Model for updating a user in a tournament.
 *
 * @class TournamentUserUpdate
 * @extends Tournament
 */
/**
 * @param user_id {Integer} Id of user to update.
 * @param tournament_id {Integer} Id of tournament that user is in.
 * @param is_league_manager {Boolean} Whether the user is now a league manager.
 * @param is_player {Boolean} Whether the user is now a player in the tournament.
 * @param leave {Boolean} Whether delete the user from the tournament (is_league_manager = false, is_player = false). (optional)
 * @param join {Boolean} Whether joining the tournament (is_league_manager = false, is_player = true). (optional)
 */
class TournamentUserUpdate extends Tournament
{
	/**
	 * SQL query string for updating the user in the tournament.
	 * Using `REPLACE` because it can `INSERT` or `UPDATE` whether record exists.
	 *
	 * @property query
	 * @private
	 */
	private $query = <<<SQL
		REPLACE INTO tournament_user_maps (user_id, tournament_id, is_league_manager, is_player)
		VALUES (:user_id, :tournament_id, :is_league_manager, :is_player)
SQL;

	/**
	 * Database object variable.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;


	/**
	 * Method for binding the boolean value of is_league_manager and is_player.
	 * Binds to @property query.
	 *
	 * @method bindBools
	 * @private
	 * @param is_league_manager {Boolean} Whether the user is now a league manager.
	 * @param is_player {Boolean} Whether the user is now a player in the tournament.
	 * @return {Boolean} Whether able to update the user.
	 */
	private function bindBools($is_league_manager, $is_player) {
		$is_user_league_manager = $this->isLeagueManager($_SESSION['user']['id'], $data['tournament_id']);
		$league_managers_count = 0;

		if ($is_user_league_manager || $league_managers_count) {
			$this->stmt->bindParam(':is_league_manager', $is_league_manager);
		}
		else {
			return false;
		}

		if ($is_user_league_manager || $league_managers_count || $data['user_id'] == $_SESSION['user']['id']) {
			$this->stmt->bindParam(':is_player', $is_player);
		}
		else {
			return false;
		}
	}

	/**
	 * Method for binding the common parameters to @property query.
	 *
	 * @method bindParams
	 * @private
	 * @return {Boolean} @method bindBools.
	 */
	private function bindParams() {
		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		return $this->bindBools($this->data['is_league_manager'], $this->data['is_player']);
	}

	/**
	 * Method that checks to see if the user wants to join or leave the leagues.
	 *
	 * @method checkCommand
	 * @private
	 * @return {Boolean} @method bindBools.
	 */
	private function checkCommand() {
		if ($this->data['join']) {
			return $this->bindBools(false, true);
		}
		else if ($this->data['leave']) {
			return $this->bindBools(false, false);
		}
	}

	/**
	 * Main method for executing the database statement.
	 * Updating the user.
	 *
	 * @method update
	 * @private
	 */
	private function update() {
		$this->stmt = Database::$conn->prepare($this->query);

		if (!$this->bindParams()) {
			$this->success = false;
		}

		$this->checkCommand();

		if (!$this->stmt->execute()) {
			$this->success = false;
		}
	}

	/**
	 * Main method which checks to see if user is logged in.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->update();
		}
		else {
			$this->success = false;
		}
	}
}

$TournamentUserUpdate = new TournamentUserUpdate();

?>