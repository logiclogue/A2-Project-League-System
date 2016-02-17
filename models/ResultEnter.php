<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/Tournament.php');
require_once(dirname(__DIR__) . '/superclasses/EloRating.php');
require_once(dirname(__DIR__) . '/superclasses/ResultMethods.php');

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
		VALUES (:result_id, :user_id, :score, :new_rating, :rating_change)
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
	 * Method that checks whether the entered score is valid.
	 *
	 * @method validScore
	 * @private
	 */
	private function validScore() {
		if ($this->data['player1_score'] >= 0 && $this->data['player1_score'] <= 3 && $this->data['player2_score'] >= 0 && $this->data['player2_score'] <= 3) {
			if (($this->data['player1_score'] != 3 && $this->data['player2_score'] == 3) || ($this->data['player2_score'] != 3 && $this->data['player1_score'] == 3)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Main validation method.
	 *
	 * @method validate
	 * @private
	 * @return {Boolean} Whether valid to enter result.
	 */
	private function validate() {
		// Check if player 1 is in league.
		if (!$this->isPlayer($this->data['player1_id'], $this->data['tournament_id'])) {
			$this->error_msg = "Player 1 is not in the league";

			return false;
		}		
		// Check if player 2 is in league.
		if (!$this->isPlayer($this->data['player2_id'], $this->data['tournament_id'])) {
			$this->error_msg = "Player 2 is not in the league";

			return false;
		}

		// Check if player 1 is not player 2.
		if ($this->data['player1_id'] == $this->data['player2_id']) {
			$this->error_msg = "You can't enter a result against the same player";

			return false;
		}

		// Check if user is one of the players.
		if ($_SESSION['user']['id'] != $this->data['player1_id'] &&
			$_SESSION['user']['id'] != $this->data['player2_id'] &&
			!$this->isLeagueManager($_SESSION['user']['id'], $this->data['tournament_id'])) {
			$this->error_msg = "You must be a player or league manager to enter this result";

			return false;
		}
		
		// Check if result already exists.
		if (ResultMethods::resultExists($this->data['player1_id'], $this->data['player2_id'], $this->data['tournament_id'])) {
			$this->error_msg = "Result already exists";

			return false;
		}
		// Check if score is valid.
		if (!$this->validScore()) {
			$this->error_msg = "Not a valid score";

			return false;
		}

		return true;
	}

	/**
	 * Method for inserting the score of a player.
	 *
	 * @method insertScore
	 * @param user_id {Integer} Id of the user whose score to input.
	 * @param score {Integer} Score that the user achieved.
	 * @param new_rating {Integer} New rating of the user.
	 * @param rating_change {Integer} Rating change.
	 * @private
	 */
	private function insertScore($user_id, $score, $new_rating, $rating_change) {
		$stmt = Database::$conn->prepare($this->query_score);

		$stmt->bindParam(':result_id', $this->id_of_result);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':score', $score);
		$stmt->bindParam(':new_rating', $new_rating);
		$stmt->bindParam(':rating_change', $rating_change);

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
			$player1_elo = new EloRating($this->data['player1_id'], $this->data['player2_id'], $this->data['tournament_id'], $this->data['player1_score'], $this->data['player2_score']);
			$player2_elo = new EloRating($this->data['player2_id'], $this->data['player1_id'], $this->data['tournament_id'], $this->data['player2_score'], $this->data['player1_score']);

			$this->insertInfo();
			$this->insertScore($this->data['player1_id'], $this->data['player1_score'], $player1_elo->new_rating, $player1_elo->rating_change);
			$this->insertScore($this->data['player2_id'], $this->data['player2_score'], $player2_elo->new_rating, $player2_elo->rating_change);
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

$ResultEnter = new ResultEnter();

?>