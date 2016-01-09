<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Model for updating a user in a tournament.
 *
 * @class UpdateTournamentUser
 * @extends Model
 * @static
 */
/**
 * @param user_id {Integer} Id of user to update.
 * @param tournament_id {Integer} Id of tournament that user is in.
 * @param is_league_manager {Boolean} Whether the user is now a league manager.
 * @param is_player {Boolean} Whether the user is now a player in the tournament.
 * @param leave {Boolean} Whether delete the user from the tournament (is_league_manager = false, is_player = false). (optional)
 * @param join {Boolean} Whether joining the tournament (is_league_manager = false, is_player = true). (optional)
 *
 * @return {Boolean} Whether successfully updated the user in the tournament.
 */
class UpdateTournamentUser extends Model
{
	/**
	 * SQL query string for updating the user in the tournament.
	 * Using `REPLACE` because it can `INSERT` or `UPDATE` whether record exists.
	 *
	 * @property query
	 * @private
	 */
	private static $query = <<<SQL
		REPLACE INTO tournament_user_maps (user_id, tournament_id, is_league_manager, is_player)
		VALUES (:user_id, :tournament_id, :is_league_manager, :is_player)
SQL;

	/**
	 * Database object variable.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private static $stmt;


	/**
	 * Method for binding the boolean value of is_league_manager and is_player.
	 * Binds to @property query.
	 *
	 * @method bindBools
	 * @param is_league_manager {Boolean} Whether the user is now a league manager.
	 * @param is_player {Boolean} Whether the user is now a player in the tournament.
	 * @private
	 */
	private static function bindBools($is_league_manager, $is_player) {
		self::$stmt->bindParam(':is_league_manager', $is_league_manager);
		self::$stmt->bindParam(':is_player', $is_player);
	}

	/**
	 * Method for binding the common parameters to @property query.
	 *
	 * @method bindParams
	 * @private
	 */
	private static function bindParams() {
		self::$stmt->bindParam(':user_id', self::$data['user_id']);
		self::$stmt->bindParam(':tournament_id', self::$data['tournament_id']);
		self::bindBools(self::$data['is_league_manager'], self::$data['is_player']);
	}

	/**
	 * Main method for executing the database statment.
	 * Updating the user.
	 *
	 * @method update
	 * @private
	 * @return {Boolean} Whether successfully updated.
	 */
	private static function update() {
		self::$stmt = Database::$conn->prepare(self::$query);

		self::bindParams();

		// Checks to see if user wants to join or leave the leagues.
		if (self::$data['join']) {
			self::bindBools(false, true);
		}
		else if (self::$data['leave']) {
			self::bindBools(false, false);
		}

		return self::$stmt->execute();
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

UpdateTournamentUser::init();

?>