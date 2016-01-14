<?php

require_once(dirname(__DIR__) . '/models/Login.php');
require_once(dirname(__DIR__) . '/models/Register.php');
require_once(dirname(__DIR__) . '/models/Status.php');
require_once(dirname(__DIR__) . '/models/Logout.php');
require_once(dirname(__DIR__) . '/models/UpdateUser.php');
require_once(dirname(__DIR__) . '/models/TournamentCreate.php');
require_once(dirname(__DIR__) . '/models/UserGet.php');
require_once(dirname(__DIR__) . '/models/TournamentUserUpdate.php');
require_once(dirname(__DIR__) . '/models/TournamentGet.php');


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


	private static function login() {
		return Login::call(array(
			'email' => 'test',
			'password' => 'password'
		));
	}

	public static function init() {
		echo 'Database reset: ';
		self::echo_n(Database::reset());

		/*$reg = Register::call(array(
			'email' => 'another',
			'password' => 'password',
			'first_name' => 'John',
			'last_name' => 'Doe'
		));*/
		$test = self::login();

		//self::echo_n($reg);
		echo 'Logged in: ';
		self::echo_n($test);
		self::echo_n(Status::call(array()));
		
		Logout::call(array());
		
		self::echo_n(Status::call(array()));
		self::echo_n($_SESSION);

		self::login();
		self::echo_n(UpdateUser::call(array(
			'first_name' => 'Jordan',
			'last_name' => 'Lord',
			'home_phone' => null,
			'mobile_phone' => null
		)));

		echo 'logout: ';
		self::echo_n(Logout::call(array()));

		self::echo_n($_SESSION);

		echo 'Create tournament: ';
		self::echo_n(TournamentCreate::call(array(
			'name' => 'Premier League',
			'description' => 'The top tier of the Primrose Squash leagues'
		)));

		self::echo_n(UserGet::call(array('id' => 1)));

		self::echo_n(TournamentUserUpdate::call(array(
			'user_id' => 1,
			'tournament_id' => 1,
			'is_league_manager' => true,
			'is_player' => true
		)));
		/*self::echo_n(TournamentUserUpdate::call(array(
			'user_id' => 1,
			'tournament_id' => 1,
			'is_league_manager' => false,
			'is_player' => false
		)));*/

		self::echo_n(TournamentGet::call(array('id' => 1)));
	}
}

Test::init();

?>