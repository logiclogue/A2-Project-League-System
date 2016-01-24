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
	 * Player becomes true when adding a player.
	 *
	 * @property is_player
	 * @protected
	 */
	protected $is_player = true;


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