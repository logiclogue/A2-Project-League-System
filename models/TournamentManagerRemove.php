<?php

require_once(dirname(__DIR__) . '/superclasses/TournamentManagerAlter.php');


/**
 * Model for removing a league manager from a tournament.
 *
 * @class TournamentManagerRemove
 * @extends TournamentManagerAlter
 */
/**
 * @param user_id {Integer} Id of the league manager to remove.
 * @param tournament_id {Integer} Id of the tournament
 */
class TournamentManagerRemove extends TournamentManagerAlter
{
	/**
	 * No longer a league manager.
	 *
	 * @property is_league_manager
	 * @protected
	 */
	protected $is_league_manager = false;


	/**
	 * Main method that calls @method subMain.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->subMain();
	}
}

$TournamentManagerRemove = new TournamentManagerRemove();

?>