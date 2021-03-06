<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/superclasses/EloRating.php');
require_once(dirname(__DIR__) . '/models/ResultGet.php');


/**
 * Class for generating a league table.
 *
 * @class TournamentLeagueTable
 * @extends Model
 */
/*&
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
	 * Array that stores the table data.
	 *
	 * @property table
	 * @private
	 * @type Array
	 */
	private $table = array();

	/**
	 * SQL query string for getting the players in the leauge.
	 *
	 * @property query
	 * @private
	 * @type String
	 */
	private $query = <<<SQL
		SELECT
		u.id user_id,
		CONCAT(u.first_name, ' ', u.last_name) name,
		0 played,
		0 wins,
		0 loses,
		0 points,
		null rating
		FROM tournament_user_maps tu
		INNER JOIN users u
		ON u.id = tu.user_id
		WHERE
		tu.tournament_id = :id AND
		tu.is_player = TRUE
SQL;


	/**
	 * If that player is unpopulated, then populate the table.
	 *
	 * @method populateTable
	 * @private
	 */
	private function populateTable() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

			foreach($users as &$user) {
				$this->table[$user['user_id']] = $user;
			}
		}
		else {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
	}

	/**
	 * Calculate points and put in table.
	 *
	 * @method calcuate
	 * @private
	 */
	private function calculate() {
		$ResultGet = new ResultGet(true);
		$results = $ResultGet->call(array(
			'tournament_id' => $this->data['id']
		))['results'];

		foreach ($results as &$result) {
			$points1 = 0;
			$points2 = 0;
			$this->table[$result['player1_id']]['played'] += 1;
			$this->table[$result['player2_id']]['played'] += 1;

			// Player 1 wins.
			if ($result['score1'] == 3) {
				$points1 = 6 - $result['score2'];
				$points2 = 1 + $result['score2'];
				$this->table[$result['player1_id']]['wins'] += 1;
				$this->table[$result['player2_id']]['loses'] += 1;
			}
			// Player 2 wins.
			else if ($result['score2'] == 3) {
				$points1 = 1 + $result['score1'];
				$points2 = 6 - $result['score1'];
				$this->table[$result['player2_id']]['wins'] += 1;
				$this->table[$result['player1_id']]['loses'] += 1;
			}

			// Add points to total.
			$this->table[$result['player1_id']]['points'] += $points1;
			$this->table[$result['player2_id']]['points'] += $points2;
		}
	}

	/**
	 * Order table and return.
	 *
	 * @method order
	 * @private
	 */
	private function order() {
		// Set table to return data.
		foreach ($this->table as &$user) {
			$this->table[$user['user_id']]['rating'] = EloRating::userRating($user['user_id']);

			array_push($this->return_data['table'], $user);
		}

		// Order table.
		usort($this->return_data['table'], function($a, $b) {
			// If level on points then order by wins.
			if ($a['points'] == $b['points']) {
				return $b['wins'] > $a['wins'];
			}

			// Else order by points.
			return $b['points'] > $a['points'];
		});
	}

	/**
	 * Method the executes @property query.
	 * Returns league table.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->return_data['table'] = array();

		$this->populateTable();
		$this->calculate();
		$this->order();		
	}
}

?>