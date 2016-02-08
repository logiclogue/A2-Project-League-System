<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');


/**
 * Model for retrieving information on a particular result.
 *
 * @class ResultGet
 * @extends Model
 */
/**
 * @param result_id {Integer} Id of the result.
 * @param player1_id {Integer} Id of player 1.
 * @param player2_id {Integer} Id of player 2.
 * @param tournament_id {Integer} Id of tournament.
 *
 * @return results {Array}
 *   @return [].id {Integer} Id of the result.
 *   @return [].tournament_id {Integer} Id of the tournament.
 *   @return [].tournament_name {String} Name of the tournament.
 *   @return [].date {String} Date-time the match was played.
 *   @return [].player1_id {Integer} Id of player 1.
 *   @return [].player2_id {Integer} Id of player 2.
 *   @return [].player1_name {String} Name of player 1.
 *   @return [].player2_name {String} Name of player 2.
 *   @return [].score1 {Integer} Score of player 1.
 *   @return [].score2 {Integer} Score of player 2.
 **/
class ResultGet extends Model
{
	/**
	 * SQL query string for getting result information.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT
		r.id,
		r.tournament_id,
		t.name tournament_name,
		r.date,
		ru1.user_id player1_id,
		ru2.user_id player2_id,
		CONCAT(u1.first_name, ' ', u1.last_name) player1_name,
		CONCAT(u2.first_name, ' ', u2.last_name) player2_name,
		ru1.score score1,
		ru2.score score2
		FROM result_user_maps ru1

		INNER JOIN result_user_maps ru2
		ON ru2.result_id = ru1.result_id
		INNER JOIN results r
		ON r.id = ru1.result_id
		
		INNER JOIN users u1
		ON ru1.user_id = u1.id
		INNER JOIN users u2
		ON ru2.user_id = u2.id
		INNER JOIN tournaments t
		ON r.tournament_id = t.id
		INNER JOIN tournament_user_maps tu1
		ON tu1.user_id = u1.id
		INNER JOIN tournament_user_maps tu2
		ON tu2.user_id = u2.id

		WHERE
		ru1.user_id <> ru2.user_id AND
		CASE WHEN :player1_id IS NULL AND :player2_id IS NULL
		THEN ru1.user_id > ru2.user_id ELSE TRUE END AND
		r.id = CASE WHEN :result_id IS NULL THEN r.id ELSE :result_id END AND
		ru1.user_id = CASE WHEN :player1_id IS NULL THEN ru1.user_id ELSE :player1_id END AND
		ru2.user_id = CASE WHEN :player2_id IS NULL THEN ru2.user_id ELSE :player2_id END AND
		r.tournament_id = CASE WHEN :tournament_id IS NULL THEN r.tournament_id ELSE :tournament_id END AND
		tu1.is_player = TRUE AND
		tu2.is_player = TRUE

		ORDER BY r.date DESC
SQL;


	/**
	 * Main method that executes @property query.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':result_id', $this->data['result_id']);
		$stmt->bindParam(':player1_id', $this->data['player1_id']);
		$stmt->bindParam(':player2_id', $this->data['player2_id']);
		$stmt->bindParam(':tournament_id', $this->data['tournament_id']);

		if ($stmt->execute()) {
			$this->return_data['results'] = array();
			$this->return_data['results'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
	}
}

$ResultGet = new ResultGet();

?>