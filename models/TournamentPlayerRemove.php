<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');
require_once(dirname(__DIR__) . '/models/UserGet.php');

session_start();


/**
 * Model for removing a player from a tournament.
 *
 * @class TournamentPlayerRemove
 * @extends Tournament
 */
/**
 * @param user_id {Integer} Id of the user to be removed from the tournament.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentPlayerRemove extends Tournament
{
	/**
	 * SQL query string for removing a player.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_player = FALSE
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
	 * Main method for remove the player from the tournament.
	 *
	 * @method remove
	 * @private
	 */
	private function remove() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		// Verify whether the user can carry out the action.
		if ($this->verifyPlayer()) {
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
			$this->remove();
		}
		else {
			$this->error_msg = "You must be logged in";

			$this->success = false;
		}
	}
}

$TournamentPlayerRemove = new TournamentPlayerRemove();

?>