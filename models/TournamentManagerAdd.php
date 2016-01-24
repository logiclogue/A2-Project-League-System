<?php

require_once(dirname(__DIR__) . '/superclasses/TournamentManagerAlter.php');


/**
 * Model for adding a user as a manager of a tournament.
 *
 * @class TournamentManagerAdd
 * @extends TournamentManagerAlter
 */
/**
 * @param user_id {Integer} Id of the user to make a manager.
 * @param tournament_id {Integer} Id of the tournament.
 */
class TournamentManagerAdd extends TournamentManagerAlter
{
	/**
	 * User becomes a league manager.
	 *
	 * @property is_league_manager
	 * @protected
	 */
	protected $is_league_manager = true;


	/**
	 * Main method calls @method subMain.
	 *
	 * @property main
	 * @protected
	 */
	protected function main() {
		$this->subMain();
	}
}

$TournamentManagerAdd = new TournamentManagerAdd();

?>