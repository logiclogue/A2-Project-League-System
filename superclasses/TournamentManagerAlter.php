<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');


session_start();


/**
 * Parent class of classes that add or remove league managers.
 *
 * @class TournamentManagerAlter
 * @extends Tournament
 */
class TournamentManagerAlter extends Tournament
{
	/**
	 * SQL query string for changing league manager status.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_league_manager = :is_league_manager
		WHERE
		user_id = :user_id AND
		tournament_id = :tournament_id
SQL;

	/**
	 * SQL query string for counting the number of league managers.
	 *
	 * @property query_managers_count
	 * @type String
	 * @private
	 */
	private $query_managers_count = <<<SQL
		SELECT COUNT(*)
		FROM tournament_user_maps
		WHERE
		is_league_manager = TRUE AND
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
	 * Method for finding the number of league manager.
	 *
	 * @method noOfLeagueManagers
	 * @private
	 * @return {Integer} Number of league managers.
	 */
	private function noOfLeagueManagers() {
		$stmt = Database::$conn->prepare($this->query_managers_count);

		$stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		if ($stmt->execute()) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT(*)'];
		}
		else {
			// 1 - so can't claim league if error.
			return 1;
		}
	}

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
		$is_league_manager = $this->isLeagueManager($_SESSION['user']['id'], $this->data['tournament_id']);
		$does_tournament_exist = $this->tournamentExists();
		$does_user_exist = $this->userExists($this->data['user_id']);

		// If there are no league managers, then the league is free to be claimed.
		if ($this->noOfLeagueManagers() == 0) {
			return true;
		}

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
	 * @method general
	 * @private
	 */
	private function general() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);
		$this->stmt->bindParam(':is_league_manager', $this->is_league_manager);

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
	 * @method subMain
	 * @protected
	 */
	protected function subMain() {
		if (isset($_SESSION['user'])) {
			$this->general();
		}
		else {
			$this->error_msg = "You must be logged in";

			$this->success = false;
		}
	}
}

?>