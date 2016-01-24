<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


/**
 * Model that can attach a user to a particular tournament.
 *
 * @class TournamentUserAttach
 * @extends Tournament
 */
/**
 * @param user_id {Integer} Id of the user to attach.
 * @param tournament_id {Integer} Id of the tournament to attach to.
 */
class TournamentUserAttach extends Tournament
{
	/**
	 * SQL query string for attaching a user.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		INSERT INTO tournament_user_maps (user_id, tournament_id, is_player, is_league_manager)
		VALUES (:user_id, :tournament_id, FALSE, FALSE)
SQL;
	/**
	 * SQL query to see if user is already attached to the tournament.
	 *
	 * @property query_is_attached
	 * @type String
	 * @private
	 */
	private $query_is_attached = <<<SQL
		SELECT COUNT(*)
		FROM tournament_user_maps
		WHERE user_id = :user_id
SQL;

	/**
	 * Database statment object.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;


	/**
	 * Method for checking whether the user is already attached to the tournament.
	 *
	 * @method isAttached
	 * @private
	 * @return {Boolean} Whether the user is attached to the tournament.
	 */
	private function isAttached() {
		$stmt = Database::$conn->prepare($this->query_is_attached);

		$stmt->bindParam(':user_id', $this->data['user_id']);

		if ($stmt->execute() && $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['COUNT(*)'] == '1') {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * Method for executing the query.
	 *
	 * @method executeQuery
	 * @private
	 */
	private function executeQuery() {
		if (!$this->stmt->execute()) {
			$this->error_msg = "Failed to execute query";

			$this->success = false;
		}
	}

	/**
	 * Method for verifying whether the user can carry out the task.
	 * Doesn't execute if:
	 * - Already in the tournament.
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

		if ($this->isAttached()) {
			$this->error_msg = 'Already attached to the tournament';

			return false;
		}
		else if (!$this->tournamentExists()) {
			$this->error_msg = "Tournament doesn't exist";

			return false;
		}
		else if (!$is_league_manager || $this->data['user_id'] == $this->_SESSION['user']['id']) {
			$this->error_msg = "You don't have permission to do that";

			return false;
		}
		else {
			return true;
		}
	}

	/**
	 * Method once logged in, attaching a user.
	 *
	 * @method attach
	 * @private
	 */
	private function attach() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':user_id', $this->data['user_id']);
		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		if ($this->verify()) {
			$this->executeQuery();
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
			$this->attach();
		}
		else {
			$this->error_msg = "You must be logged in";

			$this->success = false;
		}
	}
}

$TournamentUserAttach = new TournamentUserAttach();

?>
