<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


/**
 * Model that is called to delete a particular result.
 *
 * @method ResultDelete
 * @extends Tournament
 */
/*&
 * @param id {Integer} Id of the result to delete.
 */
class ResultDelete extends Tournament
{
	/**
	 * SQL query string for deleting a result.
	 * Also deletes the users' association with the result.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		DELETE r.*, ru.*
		FROM results r
		INNER JOIN result_user_maps ru
		ON ru.result_id = r.id
		WHERE r.id = :id
SQL;

	/**
	 * Data associated with the result that the user wants to delete.
	 *
	 * @property result_data
	 * @type Array
	 * @private
	 */
	private $result_data;


	/**
	 * Method that actually deletes the result.
	 *
	 * @method delete
	 * @private
	 */
	private function delete() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['id']);

		if (!$stmt->execute()) {
			$this->success = false;
			$this->error_msg = "Failed to execute SQL query";
		}
	}

	/**
	 * Validates whether the user can delete the result.
	 *
	 * @method validate
	 * @private
	 */
	private function validate() {
		// Check if user is logged in.
		if (!isset($_SESSION['user'])) {
			$this->error_msg = "You must be logged in";

			return false;
		}
		// Check if user is league manager.
		if ($this->isLeagueManager($_SESSION['user']['id'], $this->result_data['tournament_id'])) {
			return true;
		}
		// If not, check if it is the user's result.
		else if ($this->result_data['player1_id'] == $_SESSION['user']['id'] || $this->result_data['player2_id'] == $_SESSION['user']['id']) {
			return true;
		}
		else {
			$this->error_msg = "You don't have permission";

			return false;
		}

		return true;
	}

	/**
	 * Method that gets the result data from @class ResultGet.
	 *
	 * @method getResult
	 * @private
	 */
	private function getResult() {
		$ResultGet = new ResultGet(true);

		$this->result_data = $ResultGet->call(array(
			'result_id' => $this->data['id']
		))['results'][0];
	}

	/**
	 * Main method.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->getResult();

		if ($this->validate()) {
			$this->delete();
		}
		else {
			$this->success = false;
		}
	}
}

?>