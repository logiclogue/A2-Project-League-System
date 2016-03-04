<?php

self::testStart('Registering');


// Resetting the database.
Database::reset();

self::unitTest(
	'Register',
	'Registering a user',
	array(
		'email' => 'me@email.com',
		'password' => 'password',
		'first_name' => 'Jordan',
		'last_name' => 'Lord'
	),
	'{"id":"0","success":true}'
);

self::unitTest(
	'Login',
	'Logging in as the user just created',
	array(
		'email' => 'me@email.com',
		'password' => 'password'
	),
	'{"success":true}'
);

self::unitTest(
	'Status',
	'Checking the status of the user to see if it has logged in as the correct user',
	array(),
	'{"logged_in":true,"user":{"id":"1","email":"me@email.com","first_name":"Jordan","last_name":"Lord"},"success":true}'
);

self::unitTest(
	'Register',
	'Register a new user',
	array(
		'email' => 'new@email.com',
		'password' => 'pass123',
		'first_name' => 'New',
		'last_name' => 'User'
	),
	'{"id":"1","success":true}'
);

self::unitTest(
	'UserGet',
	'Check to see if the user has successfully been registered',
	array(
		'id' => '1'
	),
	''
);

self::unitTest(
	'Register',
	'Register another user',
	array(
		'email' => 'another@user.com',
		'password' => 'password',
		'first_name' => 'Another',
		'last_name' => 'User'
	),
	'{"id":"2","success":true}'
);


self::testEnd();

?>