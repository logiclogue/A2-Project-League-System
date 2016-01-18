<?php

require_once(dirname(__DIR__) . '/models/Login.php');
require_once(dirname(__DIR__) . '/models/Register.php');
require_once(dirname(__DIR__) . '/models/Status.php');
require_once(dirname(__DIR__) . '/models/Logout.php');
require_once(dirname(__DIR__) . '/models/UserUpdate.php');
require_once(dirname(__DIR__) . '/models/TournamentCreate.php');
require_once(dirname(__DIR__) . '/models/UserGet.php');
require_once(dirname(__DIR__) . '/models/TournamentUserUpdate.php');
require_once(dirname(__DIR__) . '/models/TournamentGet.php');
require_once(dirname(__DIR__) . '/models/TournamentUserAttach.php');
require_once(dirname(__DIR__) . '/models/TournamentPlayerAdd.php');


/**
 * Class for testing PHP models.
 *
 * @class Test
 * @static
 */
class Test
{
	private static function echo_n($data) {
		echo (json_encode($data, JSON_PRETTY_PRINT)) . '<br>';
	}


	public static function init() {
		echo 'Database reset: ';
		self::echo_n(Database::reset());

		$reg = Register::call(array(
			'email' => 'me@email.com',
			'password' => 'password',
			'first_name' => 'Jordan',
			'last_name' => 'Lord'
		));

		self::echo_n(Login::call(array(
			'email' => 'test',
			'password' => 'password'
		)));

		echo 'Create tournament: ';
		self::echo_n(TournamentCreate::call(array(
			'name' => 'Premier League',
			'description' => 'The top tier of the Primrose Squash leagues'
		)));

		echo 'Add player in tournament: ';
		self::echo_n(TournamentPlayerAdd::call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		echo 'User data: ';
		self::echo_n(UserGet::call(array('id' => 2)));

		self::echo_n(Logout::call(array()));
	}
}

Test::init();

?>