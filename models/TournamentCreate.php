<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');
require_once(dirname(__DIR__) . '/superclasses/Validate.php');

session_start();


/**
 * Model for users to create tournaments.
 *
 * @class TournamentCreate
 * @extends Tournament
 */
/*&
 * @param name {String} The name of the tournament.
 * @param description {String} The description of the tournament.
 *
 * @return id {Integer} Id of the tournament just created.
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
	 * Id of the tournament that has just been created.
	 *
	 * @property tournament_id
	 * @private
	 */
	private $tournament_id;


	/**
	 * Method which returns the tournament data.
	 * Data collected from @class TournamentGet.
	 *
	 * @method returnTournamentData
	 * @private
	 */
	private function returnTournamentData() {
		$this->return_data['id'] = $this->tournament_id;
	}

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
		$stmt->bindParam(':tournament_id', $this->tournament_id);

		if (!$stmt->execute() || $stmt->rowCount() != 1) {
			$this->error_msg = "Failed to add you as a league manager";
			$this->success = false;
		}
		else {
			$this->returnTournamentData();
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
			// Sets @property tournament_id
			$this->tournament_id = Database::$conn->lastInsertId();

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
			$validateName = Validate::tournamentName($this->data['name']);
			$validateDescription = Validate::tournamentDescription($this->data['description']);

			if (!$validateName['success']) {
				$this->error_msg = $validateName['error_msg'];
				$this->success = false;
			}
			else if (!$validateDescription['success']) {
				$this->error_msg = $validateDescription['error_msg'];
				$this->success = false;
			}
			else {
				$this->create();
			}
		}
		else {
			$this->error_msg = "You must be logged in";
			$this->success = false;
		}
	}
}

?>