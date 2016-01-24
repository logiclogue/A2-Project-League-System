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
	 * SQL query string for removing a player.
	 *
	 * @property query
	 * @type String
	 * @protected
	 */
	protected $query = <<<SQL
		UPDATE tournament_user_maps
		SET is_player = FALSE
		WHERE
		user_id = :user_id AND
		tournament_id = :tournament_id
SQL;


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