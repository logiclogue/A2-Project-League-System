<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/EloRating.php');

session_start();


/**
 * Model that returns fixture list for a tournament or user.
 * Lists all matches that are still to be played.
 *
 * @class FixturesGet
 * @extends Model
 */
/*&
 * @param player_id {Integer} Find all matches that a user still has to play.
 * @param tournament_id {Integer} Find all matches that still need to be played in a tournament.
 *
 * @return fixtures
 *   @return [].player1_id {Integer} Id of player 1.
 *   @return [].player2_id {Integer} Id of player 2.
 *   @return [].player1_name {String} Full name of player 1.
 *   @return [].player2_name {String} Full name of player 2.
 *   @return [].player1_rating {Integer} Rating of player 1.
 *   @return [].player2_rating {Integer} Rating of player 2.
 *   @return [].expected {Float} Odds of player 1 winning.
 *   @return [].expected_percent {Integer} Percentage chance of player 1 winning.
 *   @return [].tournament_id {Integer} Id of tournament that the match is in.
 *   @return [].tournament_name {String} Name of tournament that the match is in.
 *   @return [].is_league_manager {Boolean} Whether the user is a league manager.
 */
class FixturesGet extends Model
{
	/**
	 * SQL query string that fetches the matches to be played.
	 *
	 * @property query
	 * @private
	 */
	private $query = <<<SQL
		SELECT
		u1.id player1_id,
		u2.id player2_id,
		CONCAT(u1.first_name, ' ', u1.last_name) player1_name,
		CONCAT(u2.first_name, ' ', u2.last_name) player2_name,
		t.id tournament_id,
		t.name tournament_name,
		CASE WHEN tuu.is_league_manager IS NULL THEN FALSE ELSE tuu.is_league_manager END is_league_manager
		FROM users u1

		INNER JOIN users u2
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u1.id
		INNER JOIN tournament_user_maps tu2
		ON tu2.user_id = u2.id AND tu.tournament_id = tu2.tournament_id
		INNER JOIN tournaments t
		ON t.id = tu.tournament_id
		LEFT JOIN tournament_user_maps tuu
		ON tuu.user_id = :user_id AND t.id = tuu.tournament_id

		WHERE
		tu.is_player = TRUE AND
		tu2.is_player = TRUE AND
		u1.id <> u2.id AND
		CASE WHEN :tournament_id IS NULL THEN TRUE ELSE t.id = :tournament_id END AND
		CASE WHEN :player_id IS NULL THEN u1.id > u2.id ELSE u1.id = :player_id END AND
		(
			SELECT COUNT(*)
			FROM result_user_maps ru1
			INNER JOIN result_user_maps ru2
			ON ru2.result_id = ru1.result_id
			INNER JOIN results r
			ON r.id = ru1.result_id
			WHERE
			ru1.user_id <> ru2.user_id AND
			r.tournament_id = tu.tournament_id AND
			ru1.user_id = u1.id AND
			ru2.user_id = u2.id
		) = 0
SQL;


	/**
	 * Method that gets the user ratings and puts them in every fixture including the expected result for player 1.
	 *
	 * @method attachRatings
	 * @private
	 */
	private function attachRatings() {
		foreach($this->return_data['fixtures'] as &$fixture) {
			$fixture['player1_rating'] = EloRating::userRating($fixture['player1_id'], $this->data['tournament_id']);
			$fixture['player2_rating'] = EloRating::userRating($fixture['player2_id'], $this->data['tournament_id']);
			$fixture['expected'] = EloRating::expected($fixture['player1_rating'], $fixture['player2_rating']);
			$fixture['expected_percent'] = round($fixture['expected'] * 100);
		}
	}

	/**
	 * Main method that execute @property query and binds input data.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':player_id', $this->data['player_id']);
		$stmt->bindParam(':tournament_id', $this->data['tournament_id']);
		$stmt->bindParam(':user_id', $_SESSION['user']['id']);

		if ($stmt->execute()) {
			$this->return_data['fixtures'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->attachRatings();
		}
		else {
			$this->success = false;
			$this->error_msg = "Failed to execute query";
		}
	}
}

?>