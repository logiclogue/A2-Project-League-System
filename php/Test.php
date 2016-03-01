<?php

require_once(dirname(__DIR__) . '/models/Login.php');
require_once(dirname(__DIR__) . '/models/Register.php');
require_once(dirname(__DIR__) . '/models/Status.php');
require_once(dirname(__DIR__) . '/models/Logout.php');
require_once(dirname(__DIR__) . '/models/UserUpdate.php');
require_once(dirname(__DIR__) . '/models/UserGet.php');
require_once(dirname(__DIR__) . '/models/UserSearch.php');
require_once(dirname(__DIR__) . '/models/UserRatings.php');
require_once(dirname(__DIR__) . '/models/TournamentCreate.php');
require_once(dirname(__DIR__) . '/models/TournamentUpdate.php');
require_once(dirname(__DIR__) . '/models/TournamentGet.php');
require_once(dirname(__DIR__) . '/models/TournamentPlayerAttach.php');
require_once(dirname(__DIR__) . '/models/TournamentPlayerRemove.php');
require_once(dirname(__DIR__) . '/models/TournamentManagerAttach.php');
require_once(dirname(__DIR__) . '/models/TournamentManagerRemove.php');
require_once(dirname(__DIR__) . '/models/TournamentSearch.php');
require_once(dirname(__DIR__) . '/models/TournamentLeagueTable.php');
require_once(dirname(__DIR__) . '/models/TournamentDelete.php');
require_once(dirname(__DIR__) . '/models/ResultEnter.php');
require_once(dirname(__DIR__) . '/models/ResultGet.php');
require_once(dirname(__DIR__) . '/models/ResultDelete.php');
require_once(dirname(__DIR__) . '/models/FixturesGet.php');


/**
 * Class for testing PHP models.
 *
 * @class Test
 * @static
 */
class Test
{
	private static function echo_n($data) {
		echo (json_encode($data, JSON_PRETTY_PRINT)) . '<br><br>';
	}


	public static function init() {
		$Register = new Register();
		$Login = new Login();
		$TournamentGet = new TournamentGet();
		$TournamentCreate = new TournamentCreate();
		$TournamentUpdate = new TournamentUpdate();
		$TournamentPlayerAttach = new TournamentPlayerAttach();
		$TournamentPlayerRemove = new TournamentPlayerRemove();
		$TournamentManagerAttach = new TournamentManagerAttach();
		$TournamentManagerRemove = new TournamentManagerRemove();
		$TournamentSearch = new TournamentSearch();
		$TournamentLeagueTable = new TournamentLeagueTable();
		$TournamentDelete = new TournamentDelete();
		$ResultEnter = new ResultEnter();
		$ResultGet = new ResultGet();
		$ResultDelete = new ResultDelete();
		$FixturesGet = new FixturesGet();
		$UserGet = new UserGet();
		$UserSearch = new UserSearch();
		$UserRatings = new UserRatings();
		$Logout = new Logout();
		

		echo 'Database reset: ';
		self::echo_n(Database::reset());

		echo 'Register user: ';
		self::echo_n($Register->call(array(
			'email' => 'me@email.com',
			'password' => 'password',
			'first_name' => 'Jordan',
			'last_name' => 'Lord'
		)));

		echo 'Register user: ';
		self::echo_n($Register->call(array(
			'email' => 'new@email.com',
			'password' => 'pass123',
			'first_name' => 'New',
			'last_name' => 'User'
		)));

		echo 'Register user: ';
		self::echo_n($Register->call(array(
			'email' => 'another@user.com',
			'password' => 'password',
			'first_name' => 'Another',
			'last_name' => 'User'
		)));

		echo 'Login: ';
		self::echo_n($Login->call(array(
			'email' => 'me@email.com',
			'password' => 'password'
		)));

		echo 'Create tournament: ';
		self::echo_n($TournamentCreate->call(array(
			'name' => 'Premier League',
			'description' => 'A league'
		)));

		echo 'Update tournament info: ';
		self::echo_n($TournamentUpdate->call(array(
			'id' => 1,
			'name' => 'Premier League',
			'description' => 'Top tier of Primrose Squash Leagues'
		)));

		echo 'Tournament data: ';
		self::echo_n($TournamentGet->call(array(
			'id' => 1
		)));

		echo 'Add player in tournament: ';
		self::echo_n($TournamentPlayerAttach->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		/*echo 'Remove player from touranment: ';
		self::echo_n($TournamentPlayerRemove->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));*/

		echo 'Remove league manager: ';
		self::echo_n($TournamentManagerRemove->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		echo 'Add league manager: ';
		self::echo_n($TournamentManagerAttach->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		/*echo 'Logout: ';
		self::echo_n($Logout->call(array()));


		echo 'Login as new user: ';
		self::echo_n($Login->call(array(
			'email' => 'new@email.com',
			'password' => 'pass1'
		)));*/

		echo 'Add league_manager: ';
		self::echo_n($TournamentManagerAttach->call(array(
			'user_id' => 2,
			'tournament_id' => 1
		)));

		echo 'Add player in tournament: ';
		self::echo_n($TournamentPlayerAttach->call(array(
			'user_id' => 2,
			'tournament_id' => 1
		)));

		echo 'Add player in tournament: ';
		self::echo_n($TournamentPlayerAttach->call(array(
			'user_id' => 3,
			'tournament_id' => 1
		)));

		echo 'Input result: ';
		self::echo_n($ResultEnter->call(array(
			'tournament_id' => 1,
			'player1_id' => 3,
			'player2_id' => 2,
			'player1_score' => 3,
			'player2_score' => 1
		)));

		echo 'Get result: ';
		self::echo_n($ResultGet->call(array(
			'tournament_id' => 1
		)));

		echo 'Get user: ';
		self::echo_n($UserGet->call(array(
			'id' => 1
		)));

		echo 'Search for user: ';
		self::echo_n($UserSearch->call(array(
			'name' => 'a'
		)));

		echo 'Search for tournament: ';
		self::echo_n($TournamentSearch->call(array(
			'name' => 'a'
		)));

		echo 'Get fixtures: ';
		self::echo_n($FixturesGet->call(array(
			'user_id' => 1
		)));

		echo 'League table: ';
		self::echo_n($TournamentLeagueTable->call(array(
			'id' => 1
		)));

		echo 'User ratings: ';
		self::echo_n($UserRatings->call(array()));

		echo 'Enter result: ';
		self::echo_n($ResultEnter->call(array(
			'tournament_id' => 1,
			'player1_id' => 1,
			'player2_id' => 2,
			'player1_score' => 1,
			'player2_score' => 3
		)));

		echo 'Delete result: ';
		self::echo_n($ResultDelete->call(array(
			'id' => 2
		)));
	}
}

Test::init();

?>