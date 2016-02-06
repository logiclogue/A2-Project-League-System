<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Model that returns fixture list for a tournament or user.
 * Lists all matches that are still to be played.
 *
 * @class FixturesGet
 * @extends Model
 */
/**
 * @param player_id {Integer} Find all matches that a user still has to play.
 * @param tournament_id {Integer} Find all matches that still need to be played in a tournament.
 *
 * @return fixtures
 *   @return [].player1_id {Integer} Id of player 1.
 *   @return [].player2_id {Integer} Id of player 2.
 *   @return [].player1_name {String} Full name of player 1.
 *   @return [].player2_name {String} Full name of player 2.
 *   @return [].tournament_id {Integer} Id of tournament that the match is in.
 *   @return [].tournament_name {String} Name of tournament that the match is in.
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
		tu.tournament_id tournament_id,
		t.name tournament_name
		FROM users u1

		INNER JOIN users u2
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u1.id
		INNER JOIN tournament_user_maps tu2
		ON tu2.user_id = u2.id
		INNER JOIN tournaments t
		ON tu.tournament_id = t.id

		WHERE
		tu.tournament_id = tu2.tournament_id AND
		tu.is_player = TRUE AND
		tu2.is_player = TRUE AND
		u1.id <> u2.id AND
		CASE WHEN :tournament_id IS NULL THEN TRUE ELSE tu.tournament_id = :tournament_id END AND
		CASE WHEN :player_id IS NULL THEN u1.id > u2.id ELSE u1.id = :player_id END
SQL;


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

		if ($stmt->execute()) {
			$this->return_data['fixtures'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->success = false;
			$this->error_msg = "Failed to execute query";
		}
	}
}

$FixturesGet = new FixturesGet();

?>