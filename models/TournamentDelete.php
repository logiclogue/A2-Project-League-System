<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


/**
 * Class that deletes a tournament.
 *
 * @class TournamentDelete
 * @extends Tournament
 */
/**
 * @param id {Integer} Id of the tournament
 */
class TournamentDelete extends Tournament
{
	/**
	 * SQL query string for deleting the league.
	 * Also deletes all associations with the league.
	 * This includes results.
	 *
	 * @property query_league
	 * @type String
	 * @private
	 */
	private $query_league = <<<SQL
		DELETE t.*, tu.*, ru.*, r.*
		FROM tournaments t
		LEFT JOIN tournament_user_maps tu
		ON t.id = tu.tournament_id
		LEFT JOIN results r
		ON r.tournament_id = t.id
		LEFT JOIN result_user_maps ru
		ON ru.result_id = r.id
		WHERE t.id = :id
SQL;

	/**
	 * Method that uses @property query_league to delete the league.
	 *
	 * @method delete
	 * @private
	 */
	private function delete() {
		$stmt = Database::$conn->prepare($this->query_league);

		$stmt->bindParam(':id', $this->data['id']);

		if (!$stmt->execute()) {
			$this->success = false;
			$this->error_msg = "Failed to delete the league";
		}
	}

	/**
	 * Checks whether the user can delete the league.
	 *
	 * @method verify
	 * @private
	 * @return {Boolean} Whether the league is deletable.
	 */
	private function verify() {
		if (!isset($_SESSION['user'])) {
			$this->error_msg = "You must be logged in";

			return false;
		}
		if (!$this->isLeagueManager($_SESSION['user']['id'], $this->data['id'])) {
			$this->error_msg = "You must be a league manager";

			return false;
		}

		return true;
	}

	/**
	 * Result of @method verify determines whether it calls @method delete.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if ($this->verify()) {
			$this->delete();
		}
		else {
			$this->success = false;
		}
	}
}

?>