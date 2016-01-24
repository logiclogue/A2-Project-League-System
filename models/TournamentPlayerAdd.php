<?php

require_once(dirname(__DIR__) . '/superclasses/TournamentPlayer.php');


/**
 * Model for adding a user as a player to a tournament.
 *
 * @class TournamentPlayerAdd
 * @extends TournamentPlayer
 */
/**
 * @param user_id {Integer} Id of the user to be added to the tournament.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentPlayerAdd extends TournamentPlayer
{
	/**
	 * SQL query string for changing a user to a player.
	 *
	 * @property query
	 * @type String
	 * @protected
	 */
	protected $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_player = TRUE
		WHERE
		user_id = :user_id AND
		tournament_id = :tournament_id
SQL;


	/**
	 * Calls @method subMain.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->subMain();
	}
}

$TournamentPlayerAdd = new TournamentPlayerAdd();

?>