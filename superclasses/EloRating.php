<?php

require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Class with functions for calculating new elo rating.
 *
 * @class EloRating
 */
class EloRating
{
	/**
	 * New rating of the player.
	 *
	 * @property new_rating
	 * @public
	 */
	public $new_rating;
	/**
	 * Rating change.
	 * New rating - old rating.
	 *
	 * @property rating_change
	 * @public
	 */
	public $rating_change;
	/**
	 * K factor for the weight of rating change.
	 *
	 * @property k_factor
	 * @public
	 */
	public $k_factor = 20;


	/**
	 * SQL query for getting the player's latest rating.
	 *
	 * @property query_get_rating
	 * @type String
	 * @private
	 * @static
	 */
	private static $query_get_rating = <<<SQL
		SELECT
		ru.user_id,
		r.tournament_id,
		r.date,
		CASE WHEN COUNT(*) = 0 THEN :default_rating ELSE ru.rating END rating
		FROM result_user_maps ru
		INNER JOIN results r
		ON r.id = ru.result_id
		WHERE
		ru.user_id = :user_id AND
		r.tournament_id = :tournament_id
		ORDER BY r.date
		LIMIT 1
SQL;

	/**
	 * Start rating for all players.
	 *
	 * @property default_rating
	 * @public
	 * @static
	 */
	public static $default_rating = 1300;


	/**
	 * Method gets rating of a user using @property query_get_rating.
	 *
	 * @method getPlayerRating
	 * @public
	 * @static
	 * @param user_id {Integer} Id of the user to get rating.
	 * @param tournament_id {Integer} Id of the tournament.
	 * @return {Integer} Latest rating of the user.
	 */
	public static function userRating($user_id, $tournament_id) {
		$stmt = Database::$conn->prepare(self::$query_get_rating);

		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':tournament_id', $tournament_id);
		$stmt->bindParam(':default_rating', self::$default_rating);

		if ($stmt->execute()) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['rating'];
		}
		else {
			return false;
		}
	}

	/**
	 * Method that calculates a probability of a player winning.
	 *
	 * @method expected
	 * @param rating_a {Integer} Rating of player A.
	 * @param rating_b {Integer} Rating of player B.
	 * @return {Float} Odds of player A beating player B.
	 * @static
	 */
	public static function expected($rating_a, $rating_b) {
		return 1 / (1 + pow(10, ($rating_b - $rating_a) / 400));
	}

	/**
	 * Method that calculates a new rating based on the score.
	 *
	 * @method newRating
	 * @param rating_a {Integer} Rating of player A.
	 * @param k_factor {Integer} The k factor of the match.
	 * @param points_a {Float} Result of the match (0 = defeat, 0.5 = draw, 1 = win).
	 * @param expected_a {Float} Expected result as calculated from @method expected.
	 * @return {Integer} New rating of player A.
	 * @static
	 */
	public static function newRating($rating_a, $k_factor, $points_a, $expected_a) {
		return $rating_a + $k_factor * ($points_a - $expected_a);
	}


	/**
	 * Method that is called when an instance of the class is made.
	 *
	 * @method __construct
	 * @public
	 */
	public function __construct($player_a_id, $player_b_id, $tournament_id, $player_a_score, $player_b_score) {
		$player_a_rating = self::userRating($player_a_id, $tournament_id);
		$player_b_rating = self::userRating($player_b_id, $tournament_id);
		$points;

		// Calculate new score
		if ($player_a_score > $player_b_score) {
			$points = 1;
		}
		else if ($player_a_score == $player_b_score) {
			$points = 0.5;
		}
		else {
			$points = 0;
		}

		$expected = self::expected($player_a_rating, $player_b_rating);
		$this->new_rating = self::newRating($player_a_rating, $this->k_factor, $points, $expected);
		$this->rating_change = $this->new_rating - $player_a_rating;
	}
}

?>