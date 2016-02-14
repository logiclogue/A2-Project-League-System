<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/EloRating.php');


/**
 * Class for generating a league table.
 *
 * @class TournamentLeagueTable
 * @extends Model
 */
/**
 * @param id {Integer} If of the tournament.
 *
 * @return table {Array} Array that holds all the players in order.
 *   @return [].user_id {Integer} Id of player.
 *   @return [].name {String} Full name of player.
 *   @return [].played {Integer} Number of games played.
 *   @return [].wins {Integer} Number of games won.
 *   @return [].loses {Integer} Number of games lost.
 *   @return [].points {Integer} Number of points from games played.
 *   @return [].rating {Integer} Rating of player in the specific tournament.
 */
class TournamentLeagueTable extends Model
{
	/**
	 * SQL query string for generating the league table.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT
		ru.user_id,
		CONCAT(u.first_name, ' ', u.last_name) name,
		COUNT(ru.user_id) played,
		SUM(ru.score = 3) wins,
		SUM(ru.score <> 3) loses,
		SUM(ru.score) points
		FROM result_user_maps ru
		INNER JOIN users u
		ON u.id = user_id
		INNER JOIN results r
		ON r.id = ru.result_id
		WHERE r.tournament_id = :id
		GROUP BY user_id
		ORDER BY points DESC
SQL;


	/**
	 * Method gets all user ratings.
	 * Loops over all player and appends their rating.
	 * Gets rating from @class EloRating and @method userRating.
	 *
	 * @method getPlayerRatings
	 * @private
	 */
	private function getPlayerRatings() {
		foreach ($this->return_data['table'] as &$player) {
			$player['rating'] = EloRating::userRating($player['user_id'], $this->data['id']);
		}
	}

	/**
	 * Method the executes @property query.
	 * Returns league table.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data['table'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->getPlayerRatings();
		}
		else {
			$this->success = false;
			$this->error_msg = "Failed to execute query";
		}
	}
}

$TournamentLeagueTable = new TournamentLeagueTable();

?>