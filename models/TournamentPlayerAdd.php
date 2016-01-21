<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/models/Tournament.php');
require_once(dirname(__DIR__) . '/models/TournamentUserAttach.php');
require_once(dirname(__DIR__) . '/models/UserGet.php');

session_start();


/**
 * Method for adding a user as a player to a tournament.
 *
 * @class TournamentPlayerAdd
 * @extends Tournament
 */
/**
 * @param user_id {Integer} Id of the user to be added to the tournament.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentPlayerAdd extends Tournament
{
	/**
	 * SQL query string for changing a user to a player.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_player = true
		WHERE
		user_id = :user_id AND
		tournament_id = :tournament_id
SQL;

	/**
	 * Database object for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;


	/**
	 * Checks any faults and executes query.
	 *
	 * @method executeQuery
	 * @private
	 */
	private function executeQuery() {
		if (!$this->stmt->execute() || $this->stmt->rowCount() != 1) {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
	}

	/**
	 * Method for verifying whether the user can carry out the task.
	 * Returns false if:
	 * - User doesn't exist.
	 * - Tournament doesn't exist.
	 * - Either:
	 *   - Not a league manager.
	 *   - Attaching someone else.
	 *
	 * @method verify
	 * @private
	 * @return {Boolean} Whether can.
	 */
	private function verify() {
		$is_league_manager = $this->isLeagueManager($_SESSION['user']['id'], $this->data['tournament_id']);
		$does_tournament_exist = $this->tournamentExists();
		$does_user_exist = $UserGet->call(array('id' => $this->data['user_id']))['success']; //!!! NEEDS ATTENTION

		if (!$does_tournament_exist) {
			$this->error_msg = "Tournament doesn't exist";

			return false;
		}
		else if ($is_league_manager || $this->data['user_id'] == $_SESSION['user']['id']) {
			return true;
		}
		else {
			$this->error_msg = "You don't have permission to do that";

			return false;
		}
	}

	/**
	 * Main method for making the user a player in the tournament.
	 *
	 * @method add
	 * @private
	 */
	private function add() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		// Verify whether the user can carry out the action.
		if ($this->verify()) {
			// Attach user if not already.
			$this->attachUser($this->data['tournament_id'], $this->data['user_id']);
			// Execute query
			$this->executeQuery();
		}
		else {
			$this->success = false;
		}
	}

	/**
	 * Method that checks whether the user is logged in.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->add();
		}
		else {
			$this->error_msg = "You must be logged in";

			$this->success = false;
		}
	}
}

$TournamentPlayerAdd = new TournamentPlayerAdd();

?>