<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


/**
 * Parent class of classes that add or remove players.
 *
 * @class TournamentPlayerAlter
 * @extends Tournament
 */
class TournamentPlayerAlter extends Tournament
{
	/**
	 * SQL query string for updating a player
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_player = :is_player
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
	 *   - Altering someone else.
	 *
	 * @method verifyPlayer
	 * @private
	 * @return {Boolean} Whether can.
	 */
	private function verifyPlayer() {
		$is_league_manager = $this->isLeagueManager($_SESSION['user']['id'], $this->data['tournament_id']);
		$does_tournament_exist = $this->tournamentExists();
		$does_user_exist = $this->userExists($this->data['user_id']);

		if (!$does_tournament_exist) {
			$this->error_msg = "Tournament doesn't exist";

			return false;
		}
		else if (!$does_user_exist) {
			$this->error_msg = "User doesn't exist";

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
	 * Method that creates database object.
	 * Binds parameters.
	 * Checks to see if able to execute query.
	 * Then execute query.
	 * 
	 * @method general
	 * @private
	 */
	private function general() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);
		$this->stmt->bindParam(':is_player', $this->is_player);

		// Verify whether the user can carry out the action.
		if ($this->verifyPlayer()) {
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
	 * Method that checks login.
	 * Then calls @method general
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