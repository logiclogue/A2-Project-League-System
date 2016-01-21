<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');
require_once(dirname(__DIR__) . '/models/TournamentUserAttach.php');

session_start();


/**
 * Model for users to create tournaments.
 *
 * @class TournamentCreate
 * @extends Tournament
 */
/**
 * @param name {String} The name of the tournament.
 * @param description {String} The description of the tournament.
 */
class TournamentCreate extends Tournament
{
	/**
	 * SQL query string for creating a tournament.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		INSERT INTO tournaments (name, description)
		VALUES (:name, :description)
SQL;
	/**
	 * Query for making the creator of the league a league manager.
	 *
	 * @property query_add_league_manager
	 * @type String
	 * @private
	 */
	private $query_add_league_manager = <<<SQL
		INSERT INTO tournament_user_maps (tournament_id, user_id, is_league_manager, is_player)
		VALUES (:tournament_id, :user_id, 1, 0)
SQL;

	/**
	 * Statement object for executing @property query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;


	/**
	 * Method for attaching the current user as the league manager.
	 *
	 * @method addLeagueManager
	 * @private
	 */
	private function addLeagueManager() {
		$stmt = Database::$conn->prepare($this->query_add_league_manager);

		$stmt->bindParam(':user_id', $_SESSION['user']['id']);
		// Bind the tournament id as the last insert id.
		$stmt->bindParam(':tournament_id', Database::$conn->lastInsertId());

		if (!$stmt->execute() || $stmt->rowCount() != 1) {
			$this->error_msg = "Failed to add you as a league manager";
			$this->success = false;
		}
	}

	/**
	 * Main function for creating database object, binding params, and executing query.
	 *
	 * @method create
	 * @private
	 */
	private function create() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':name', $this->data['name']);
		$this->stmt->bindParam(':description', $this->data['description']);

		if (!$this->stmt->execute()) {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
		else {
			// Add league manager if didn't fail.
			$this->addLeagueManager();
		}
	}

	/**
	 * Main function for checking whether user is logged in.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->create();
		}
		else {
			$this->error_msg = "You must be logged in";
			$this->success = false;
		}
	}
}

$TournamentCreate = new TournamentCreate();

?>