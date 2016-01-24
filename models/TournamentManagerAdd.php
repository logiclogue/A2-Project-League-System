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
	 *
	 * @method verifyManager
	 * @private
	 */
	private function verifyManager() {
		// !!!!!!!!!!!!!!!!!!!
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
}

$TournamentManagerAdd = new TournamentManagerAdd();

?>