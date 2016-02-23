<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');
require_once(dirname(__DIR__) . '/superclasses/Validate.php');

session_start();


/**
 * Model that updates tournament info.
 *
 * @class TournamentUpdate
 * @extends Tournament
 */
/**
 * @param id {Integer} Id of tournament.
 * @param name {String} New name of the tournament.
 * @param description {String} New description of the tournament.
 */
class TournamentUpdate extends Tournament
{
	/**
	 * SQL query string that updates tournament info.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		UPDATE tournaments
		SET name = :name, description = :description
		WHERE id = :id
SQL;


	/**
	 * Validates whether the user can update tournament info.
	 *
	 * @method validate
	 * @private
	 * @return {Boolean} Whether the user has permission.
	 */
	private function validate() {
		$is_league_manager = $this->isLeagueManager($_SESSION['user']['id'], $this->data['id']);
		$tournament_exists = $this->tournamentExistsId($this->data['id']);
		$validateName = Validate::tournamentName($this->data['name']);

		if (!$tournament_exists) {
			$this->error_msg = "Tournament doesn't exists";

			return false;
		}
		if (!$is_league_manager) {
			$this->error_msg = "You don't have permission to do that";

			return false;
		}
		if (!$validateName['success']) {
			$this->error_msg = $validateName['error_msg'];

			return false;
		}

		return true;
	}

	/**
	 * Method that executes @property query.
	 * Thus updating tournament info.
	 *
	 * @method update
	 * @private
	 */
	private function update() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['id']);
		$stmt->bindParam(':name', $this->data['name']);
		$stmt->bindParam(':description', $this->data['description']);

		if (!$stmt->execute()) {
			$this->success = false;
			$this->error_msg = "Failed to update tournament";
		}
	}

	/**
	 * Method that checks login, then calls @method update.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			if ($this->validate()) {
				$this->update();
			}
			else {
				$this->success = false;
			}
		}
		else {
			$this->success = false;
			$this->error_msg = "You must be logged in";
		}
	}
}

?>