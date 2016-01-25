<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Model used for entering a result.
 *
 * @class ResultEnter
 * @extends Model
 */
/**
 * @param tournament_id {Integer} Id of the tournament.
 * @param player1_id {Integer} Id of player 1.
 * @param player2_id {Integer} Id of player 2.
 * @param player1_score {Integer} Player 1's score.
 * @param player2_score {Integer} Player 2's score.
 */
class ResultEnter extends Model
{
	private $query = <<<SQL
		INSERT INTO results (tournament_id, date)
		VALUES (:tournament_id, :date)
SQL;

	private $stmt;


	/**
	 * Main method.
	 *
	 * @method enter
	 * @private
	 */
	private function enter() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);
		$this->stmt->bindParam(':date', date('ymd'));

		if (!$this->stmt->execute()) {
			$this->success = false;
			$this->error_msg = "Failed to execute query";
		}
	}


	/**
	 * Checks login then calls @method enter.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->enter();
		}
		else {
			$this->success = false;
			$this->error_msg = "You must be logged in";
		}
	}
}

?>