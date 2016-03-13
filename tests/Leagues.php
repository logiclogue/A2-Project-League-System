<?php

self::testStart('Leagues');


self::unitTest(
	'TournamentCreate',
	'Creating a league',
	array(
		'name' => 'Premier League',
		'description' => 'The top tier of the Primrose Squash Leagues'
	),
	'{"id":"1","success":true}'
);


self::testEnd();

?>