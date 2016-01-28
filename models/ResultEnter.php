<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


/**
 * Model used for entering a result.
 *
 * @class ResultEnter
 * @extends Tournament
 */
/**
 * @param tournament_id {Integer} Id of the tournament.
 * @param player1_id {Integer} Id of player 1.
 * @param player2_id {Integer} Id of player 2.
 * @param player1_score {Integer} Player 1's score.
 * @param player2_score {Integer} Player 2's score.
 */
class ResultEnter extends Tournament
{
	/**
	 * SQL query string for inserting result info.
	 *
	 * @property query_info
	 * @type String
	 * @private
	 */
	private $query_info = <<<SQL
		INSERT INTO results (tournament_id, date)
		VALUES (:tournament_id, :date)
SQL;
	/**
	 * SQL query string for inserting result score.
	 *
	 * @property query_score
	 * @type String
	 * @private
	 */
	private $query_score = <<<SQL
		INSERT INTO result_user_maps (result_id, user_id, score, rating, rating_change)
		VALUES (:result_id, :user_id, :score, 0, 0)
SQL;

	/**
	 * Id of the result that is being entered.
	 *
	 * @property id_of_result
	 * @type Integer
	 * @private
	 */
	private $id_of_result;


	/**
	 * Main validation method.
	 *
	 * @method validate
	 * @private
	 * @return {Boolean} Whether valid to enter result.
	 */
	private function validate() {
		// Check if player is in league.
		if (!$this->isPlayer($this->data['player1_id'], $this->data['tournament_id'])) {
			$this->error_msg = "User not in the league";

			return false;
		}
		// - If not, then check is league manager.
		else if (!$this->isLeagueManager($this->data['player1_id'], $this->data['tournament_id'])) {
			$this->error_msg = "You don't have permission to do that";
		}
		// Check if opponent is in league.
		else if (!$this->isPlayer($this->data['player2_id'], $this->data['tournament_id'])) {
			$this->error_msg = "Opponent not in the league";

			return false;
		}
		// Check if opponent is not self.
		else if ($this->data['player1_id'] == $this->data['player2_id']) {
			$this->error_msg = "You can't enter a result against yourself";

			return false;
		}
		// Check if result already exists.
		// Check if score is valid.

		return true;
	}

	/**
	 * Method for inserting the score of a player.
	 *
	 * @method insertScore
	 * @private
	 */
	private function insertScore($user_id, $score) {
		$stmt = Database::$conn->prepare($this->query_score);

		$stmt->bindParam(':result_id', $this->id_of_result);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':score', $score);

		$stmt->execute();
	}

	/**
	 * Method used to insert general result info.
	 *
	 * @method insertInfo
	 * @private
	 */
	private function insertInfo() {
		$stmt = Database::$conn->prepare($this->query_info);

		$stmt->bindParam(':tournament_id', $this->data['tournament_id']);
		// date is format yymmdd_hhmmss
		$stmt->bindParam(':date', date('ymdHis'));

		if ($stmt->execute()) {
			$this->id_of_result = Database::$conn->lastInsertId();
		}
		else {
			$this->success = false;
			$this->error_msg = "Failed to execute query";
		}
	}

	/**
	 * Calls all general methods.
	 *
	 * @method general
	 * @private
	 */
	private function general() {
		if ($this->validate()) {
			$this->insertInfo();
			$this->insertScore($this->data['player1_id'], $this->data['player1_score']);
			$this->insertScore($this->data['player2_id'], $this->data['player2_score']);
		}
		else {
			$this->success = false;
		}
	}

	/**
	 * Checks login.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->general();
		}
		else {
			$this->success = false;
			$this->error_msg = "You must be logged in";
		}
	}
}

?>