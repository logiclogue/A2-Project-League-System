<?php

require_once(dirname(__DIR__) . '/superclasses/Tournament.php');

session_start();


class TournamentManagerRemove extends Tournament
{

}

$TournamentManagerRemove = new TournamentManagerRemove();

?>