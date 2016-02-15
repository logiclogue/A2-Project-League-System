<?php

require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Helpful functions for dealing with results.
 *
 * @class ResultMethods
 */
class ResultMethods
{
	/**
	 * SQL query that checks whether a result exists or not.
	 *
	 * @property query_result_exists
	 * @type String
	 * @private
	 * @static
	 */
	private static $query_result_exists = <<<SQL
		SELECT COUNT(*) result_exists
		FROM results r
		INNER JOIN result_user_maps ru1
		ON r.id = ru1.result_id
		INNER JOIN result_user_maps ru2
		ON r.id = ru2.result_id
		WHERE
		ru1.user_id <> ru2.user_id AND
		ru1.user_id = :player1_id AND
		ru2.user_id = :player2_id AND
		r.tournament_id = :tournament_id
SQL;


	/**
	 * Method that tests whether a match has already been played.
	 *
	 * @method resultExists
	 * @public
	 * @static
	 * @param player1_id {Integer} Id of player in match.
	 * @param player2_id {Integer} Id of player in match.
	 * @param tournament_id {Integer} Id of tournament the match is in.
	 * @return {Boolean} Whether that result has been entered.
	 */
	public static function resultExists($player1_id, $player2_id, $tournament_id) {
		$stmt = Database::$conn->prepare(self::$query_result_exists);

		$stmt->bindParam(':player1_id', $player1_id);
		$stmt->bindParam(':player2_id', $player2_id);
		$stmt->bindParam(':tournament_id', $tournament_id);

		$stmt->execute();

		if ($stmt->fetchAll(PDO::FETCH_ASSOC)[0]['result_exists']) {
			return true;
		}
		else {
			return false;
		}
	}
}

?>