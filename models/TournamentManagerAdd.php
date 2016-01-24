<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');

session_start();


/**
 * Model for adding a user as a manager of a tournament.
 *
 * @class TournamentManagerAdd
 * @extends Tournament
 */
/**
 * @param user_id {Integer} Id of the user to make a manager.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentManagerAdd extends Tournament
{
	/**
	 * SQL query string for making a user a manager.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_league_manager = TRUE
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
	 * Verifies whether the user can carry out the task.
	 * Returns false if:
	 * - User doesn't exist.
	 * - Tournament doesn't exist.
	 * - Not a league manager.
	 *
	 * @method verifyManager
	 * @private
	 * @return {Boolean} Whether can.
	 */
	private function verifyManager() {
		$UserGet = new UserGet();

		$is_league_manager = $this->isLeagueManager($_SESSION['user']['id'], $this->data['tournament_id']);
		$does_tournament_exist = $this->tournamentExists();
		$does_user_exist = $UserGet->call(array('id' => $this->data['user_id']))['success'];

		if (!$does_tournament_exist) {
			$this->error_msg = "Tournament doesn't exist";

			return false;
		}
		else if (!$does_user_exist) {
			$this->error_msg = "User doesn't exist";

			return false;
		}
		else if ($is_league_manager) {
			return true;
		}
		else {
			$this->error_msg = "You don't have permission to do that";

			return false;
		}
	}

	/**
	 * Main method for making the user a league manager
	 *
	 * @method add
	 * @private
	 */
	private function add() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		// Verify whether the user can carry out the action.
		if ($this->verifyManager()) {
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

$TournamentManagerAdd = new TournamentManagerAdd();

?>