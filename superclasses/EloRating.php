<?php

/**
 * Class with functions for calculating new elo rating.
 *
 * @class EloRating
 */
class EloRating
{
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
		return $rating_a + $k_factor($points_a - $expected_a);
	}
}

?>