<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Model for updating a user in a tournament.
 *
 * @class UpdateUserTournament
 * @extends Model
 * @static
 */
/**
 * @param user_id {Integer} Id of user to update.
 * @param tournament_id {Integer} Id of tournament that user is in.
 * @param is_league_manager {Boolean} Whether the user is now a league manager.
 * @param is_player {Boolean} Whether the user is now a player in the tournament.
 */
class UpdateUserTournament extends Model
{
	/**
	 * SQL query string for updating the user in the tournament.
	 *
	 * @property query
	 * @private
	 */
	private static $query = <<<SQL
		UPDATE tournament_user_maps
		SET
		is_league_manager = :is_league_manager,
		is_player = :is_player
		WHERE
		user_id = :user_id AND
		tournament_id = :tournament_id
SQL;


	/**
	 * Main method for executing the database statment.
	 * Updating the user.
	 *
	 * @method update
	 * @private
	 * @return {Boolean} Whether successfully updated.
	 */
	private static function update() {
		$stmt = Database::$conn->prepare(self::$query);

		$stmt->bindParam(':user_id', self::$data['user_id']);
		$stmt->bindParam(':tournament_id', self::$data['tournament_id']);
		$stmt->bindParam(':is_league_manager', self::$data['is_league_manager']);
		$stmt->bindParam(':is_player', self::$data['is_player']);

		return $stmt->execute();
	}

	/**
	 * Main method which checks to see if user is logged in.
	 *
	 * @method main
	 * @protected
	 * @return {Boolean} Whether successfully updated.
	 */
	protected static function main() {
		if (isset($_SESSION['user'])) {
			return self::update();
		}
		else {
			return false;
		}
	}
}

UpdateUserTournament::init();

?>