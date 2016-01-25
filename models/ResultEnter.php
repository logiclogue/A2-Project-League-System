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
	 * Database object for executing @property query_info
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;
	/**
	 * Id of the result that is being entered.
	 *
	 * @property id_of_result
	 * @type Integer
	 * @private
	 */
	private $id_of_result;


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
		$this->stmt = Database::$conn->prepare($this->query_info);

		$this->stmt->bindParam(':tournament_id', $this->data['tournament_id']);
		// date is format yymmdd_hhmmss
		$this->stmt->bindParam(':date', date('ymdHis'));

		if ($this->stmt->execute()) {
			$this->id_of_result = Database::$conn->lastInsertId();
		}
		else {
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
			$this->insertInfo();
			$this->insertScore($this->data['player1_id'], $this->data['player1_score']);
			$this->insertScore($this->data['player2_id'], $this->data['player2_score']);
		}
		else {
			$this->success = false;
			$this->error_msg = "You must be logged in";
		}
	}
}

?>