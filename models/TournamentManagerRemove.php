<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');

session_start();


class TournamentManagerRemove extends Tournament
{

}

$TournamentManagerRemove = new TournamentManagerRemove();

?>