<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');
require_once(dirname(__DIR__) . '/models/UserGet.php');

session_start();


/**
 *
 *
 * @class TournamentPlayer
 * @extends Tournament
 */
class TournamentPlayer extends Tournament
{
	/**
	 * Database object for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @protected
	 */
	protected $stmt;


	/**
	 * Checks any faults and executes query.
	 *
	 * @method executeQuery
	 * @protected
	 */
	protected function executeQuery() {
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
	 * @protected
	 * @return {Boolean} Whether can.
	 */
	protected function verifyPlayer() {
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
	 * @protected
	 */
	protected function general() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);

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