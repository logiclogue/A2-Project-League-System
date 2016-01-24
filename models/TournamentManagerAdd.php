<?php

require_once(dirname(__DIR__) . '/models/Tournament.php');

session_start();


class TournamentManagerAdd extends Tournament
{

}

$TournamentManagerAdd = new TournamentManagerAdd();

?>