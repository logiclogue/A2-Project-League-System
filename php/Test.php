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
require_once(dirname(__DIR__) . '/models/TournamentPlayerRemove.php');


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
		$Register = new Register();
		$Login = new Login();
		$TournamentGet = new TournamentGet();
		$TournamentCreate = new TournamentCreate();
		$TournamentPlayerAdd = new TournamentPlayerAdd();
		$TournamentPlayerRemove = new TournamentPlayerRemove();
		$UserGet = new UserGet();
		$Logout = new Logout();
		

		echo 'Database reset: ';
		self::echo_n(Database::reset());

		self::echo_n($Register->call(array(
			'email' => 'me@email.com',
			'password' => 'password',
			'first_name' => 'Jordan',
			'last_name' => 'Lord'
		)));

		self::echo_n($Login->call(array(
			'email' => 'me@email.com',
			'password' => 'password'
		)));

		echo 'Create tournament: ';
		self::echo_n($TournamentCreate->call(array(
			'name' => 'Premier League',
			'description' => 'The top tier of the Primrose Squash leagues'
		)));

		echo 'Tournament data: ';
		self::echo_n($TournamentGet->call(array(
			'id' => 1
		)));

		echo 'Add player in tournament: ';
		self::echo_n($TournamentPlayerAdd->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		echo 'Remove player from touranment: ';
		self::echo_n($TournamentPlayerRemove->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		self::echo_n($Logout->call(array()));
	}
}

Test::init();

?>