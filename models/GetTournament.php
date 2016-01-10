<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Model that fetches tournament data based on id.
 *
 * @class GetTournament
 * @extends Model
 * @static
 */
/**
 * @param id {Integer} Id of the tournament.
 *
 * @return name {String} Name of the tournament.
 * @return description {String} Description of the tournament.
 * @return league_managers {Array} Array of league managers.
 *  @return league_managers[] {Object} Result of @class GetUser for each league manager.
 * @return players {Array} Array of players in the tournament.
 *  @return players[] {Object} Result of @class GetUser for each player.
 */
class GetTournament extends Model
{

}

?>