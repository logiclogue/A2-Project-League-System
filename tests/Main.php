<?php

self::testStart('Main test');


Database::reset();

self::unitTest(
	'Register',
	'Register user',
	array(
		'email' => 'me@email.com',
		'password' => 'password',
		'first_name' => 'Jordan',
		'last_name' => 'Lord'
	),
	'{"success":true}'
);

self::unitTest(
	'Register',
	'Register user',
	array(
		'email' => 'new@email.com',
		'password' => 'pass123',
		'first_name' => 'New',
		'last_name' => 'User'
	),
	'{"success":true}'
);

self::unitTest(
	'Register',
	'Register user',
	array(
		'email' => 'another@user.com',
		'password' => 'password',
		'first_name' => 'Another',
		'last_name' => 'User'
	),
	'{"success":true}'
);

self::unitTest(
	'Login',
	'Login',
	array(
		'email' => 'me@email.com',
		'password' => 'password'
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentCreate',
	'Create tournament',
	array(
		'name' => 'Premier League',
		'description' => 'A league'
	),
	'{"id":"1","success":true}'
);

self::unitTest(
	'TournamentUpdate',
	'Update tournament info',
	array(
		'id' => 1,
		'name' => 'Premier League',
		'description' => 'Top tier of Primrose Squash Leagues'
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentGet',
	'Tournament data',
	array(
		'id' => 1
	),
	'{"id":"1","name":"Premier League","description":"Top tier of Primrose Squash Leagues","is_league_manager":true,"players":[],"league_managers":[{"id":"1","first_name":"Jordan","last_name":"Lord"}],"success":true}'
);

self::unitTest(
	'TournamentPlayerAttach',
	'Add player in tournament',
	array(
		'user_id' => 1,
		'tournament_id' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentManagerRemove',
	'Remove league manager',
	array(
		'user_id' => 1,
		'tournament_id' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentManagerAttach',
	'Add league manager',
	array(
		'user_id' => 1,
		'tournament_id' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentManagerAttach',
	'Add league_manager',
	array(
		'user_id' => 2,
		'tournament_id' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentPlayerAttach',
	'Add player in tournament',
	array(
		'user_id' => 2,
		'tournament_id' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'TournamentPlayerAttach',
	'Add player in tournament',
	array(
		'user_id' => 3,
		'tournament_id' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'ResultEnter',
	'Input result',
	array(
		'tournament_id' => 1,
		'player1_id' => 3,
		'player2_id' => 2,
		'player1_score' => 3,
		'player2_score' => 1
	),
	'{"success":true}'
);

self::unitTest(
	'ResultGet',
	'Get result',
	array(
		'tournament_id' => 1
	),
	'{"results":[{"id":"1","tournament_id":"1","tournament_name":"Premier League","date":"' . date('Y-m-d H:i:s') . '","player1_id":"3","player2_id":"2","player1_name":"Another User","player2_name":"New User","player1_rating":"1300","player2_rating":"1300","player1_rating_change":"10","player2_rating_change":"-10","score1":"3","score2":"1"}],"success":true}'
);

self::unitTest(
	'UserGet',
	'Get user',
	array(
		'id' => 1
	),
	'{"first_name":"Jordan","last_name":"Lord","id":"1","rating":1300,"leagues_playing":[{"id":"1","name":"Premier League"}],"leagues_managing":[{"id":"1","name":"Premier League"}],"success":true}'
);

self::unitTest(
	'UserSearch',
	'Search for user',
	array(
		'name' => 'a'
	),
	'{"users":[{"id":"1","name":"Jordan Lord"},{"id":"3","name":"Another User"}],"success":true}'
);

self::unitTest(
	'TournamentSearch',
	'Search for tournament',
	array(
		'name' => 'a'
	),
	'{"tournaments":[{"id":"1","name":"Premier League"}],"success":true}'
);

self::unitTest(
	'FixturesGet',
	'Get fixtures',
	array(
		'user_id' => 1
	),
	'{"fixtures":[{"player1_id":"2","player2_id":"1","player1_name":"New User","player2_name":"Jordan Lord","tournament_id":"1","tournament_name":"Premier League","is_league_manager":"1","player1_rating":"1290","player2_rating":1300,"expected":0.485612815834,"expected_percent":49},{"player1_id":"3","player2_id":"1","player1_name":"Another User","player2_name":"Jordan Lord","tournament_id":"1","tournament_name":"Premier League","is_league_manager":"1","player1_rating":"1310","player2_rating":1300,"expected":0.514387184166,"expected_percent":51}],"success":true}'
);

self::unitTest(
	'TournamentLeagueTable',
	'League table',
	array(
		'id' => 1
	),
	'{"table":[{"user_id":"3","name":"Another User","played":1,"wins":1,"loses":"0","points":5,"rating":"1310"},{"user_id":"2","name":"New User","played":1,"wins":"0","loses":1,"points":2,"rating":"1290"},{"user_id":"1","name":"Jordan Lord","played":"0","wins":"0","loses":"0","points":"0","rating":1300}],"success":true}'
);

self::unitTest(
	'UserRatings',
	'User ratings',
	array(),
	'{"ratings":[],"success":true}'
);

self::unitTest(
	'ResultEnter',
	'Enter result',
	array(
		'tournament_id' => 1,
		'player1_id' => 1,
		'player2_id' => 2,
		'player1_score' => 1,
		'player2_score' => 3
	),
	'{"success":true}'
);

self::unitTest(
	'ResultDelete',
	'Delete result',
	array(
		'id' => 2
	),
	'{"success":true}'
);


self::testEnd();

?>