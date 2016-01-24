<?php

require_once(dirname(__DIR__) . '/superclasses/TournamentPlayer.php');


/**
 * Model for removing a player from a tournament.
 *
 * @class TournamentPlayerRemove
 * @extends TournamentPlayer
 */
/**
 * @param user_id {Integer} Id of the user to be removed from the tournament.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentPlayerRemove extends TournamentPlayer
{
	/**
	 * Player becomes false when removing a player.
	 *
	 * @property is_player
	 * @protected
	 */
	protected $is_player = false;


	/**
	 * Calls @method subMain
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->subMain();
	}
}

$TournamentPlayerRemove = new TournamentPlayerRemove();

?>