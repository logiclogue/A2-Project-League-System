<!DOCTYPE html>
<html>
<head>
<title>Unit tests</title>
</head>
<body>

<table>
	<thead>
		<th>Test</th>
		<th>Input data</th>
		<th>Expected result</th>
		<th>Result</th>
		<th>Pass</th>
	</thead>
	<tbody>
<?php

/**
 * Class for testing PHP models.
 *
 * @class Test
 * @static
 */
class Test
{
	/**
	 * Method that requires all the files.
	 *
	 * @method requireAll
	 * @private
	 * @static
	 */
	private static function requireAll() {
		// Require all models.
		foreach (scandir(dirname(__DIR__) . '/models/') as $filename) {
			$path = dirname(__DIR__) . '/models/' . $filename;

			if (is_file($path)) {
				require_once($path);
			}
		}
	}

	/**
	 *
	 *
	 *
	 */
	private static function unitTest($modelName, $data) {
		$model = new $modelName(true);
		
		echo '<tr>';
		echo '<td>' . $modelName . '</td>';
		echo '<td>' . json_encode($data) . '</td>';
		echo '</tr>';
	}


	/**
	 *
	 *
	 *
	 */
	public static function init() {
		self::requireAll();
		

		// Database reset
		Database::reset();

		echo 'Register user: ';
		self::unitTest('Register', array(
			'email' => 'me@email.com',
			'password' => 'password',
			'first_name' => 'Jordan',
			'last_name' => 'Lord'
		));

		echo 'Register user: ';
		self::unitTest('Register', array(
			'email' => 'new@email.com',
			'password' => 'pass123',
			'first_name' => 'New',
			'last_name' => 'User'
		));

		echo 'Register user: ';
		self::unitTest('Register', array(
			'email' => 'another@user.com',
			'password' => 'password',
			'first_name' => 'Another',
			'last_name' => 'User'
		));

		echo 'Login: ';
		self::unitTest($Login->call(array(
			'email' => 'me@email.com',
			'password' => 'password'
		)));

		echo 'Create tournament: ';
		self::unitTest($TournamentCreate->call(array(
			'name' => 'Premier League',
			'description' => 'A league'
		)));

		echo 'Update tournament info: ';
		self::unitTest($TournamentUpdate->call(array(
			'id' => 1,
			'name' => 'Premier League',
			'description' => 'Top tier of Primrose Squash Leagues'
		)));

		echo 'Tournament data: ';
		self::unitTest($TournamentGet->call(array(
			'id' => 1
		)));

		echo 'Add player in tournament: ';
		self::unitTest($TournamentPlayerAttach->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		/*echo 'Remove player from touranment: ';
		self::unitTest($TournamentPlayerRemove->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));*/

		echo 'Remove league manager: ';
		self::unitTest($TournamentManagerRemove->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		echo 'Add league manager: ';
		self::unitTest($TournamentManagerAttach->call(array(
			'user_id' => 1,
			'tournament_id' => 1
		)));

		/*echo 'Logout: ';
		self::unitTest($Logout->call(array()));


		echo 'Login as new user: ';
		self::unitTest($Login->call(array(
			'email' => 'new@email.com',
			'password' => 'pass1'
		)));*/

		echo 'Add league_manager: ';
		self::unitTest($TournamentManagerAttach->call(array(
			'user_id' => 2,
			'tournament_id' => 1
		)));

		echo 'Add player in tournament: ';
		self::unitTest($TournamentPlayerAttach->call(array(
			'user_id' => 2,
			'tournament_id' => 1
		)));

		echo 'Add player in tournament: ';
		self::unitTest($TournamentPlayerAttach->call(array(
			'user_id' => 3,
			'tournament_id' => 1
		)));

		echo 'Input result: ';
		self::unitTest($ResultEnter->call(array(
			'tournament_id' => 1,
			'player1_id' => 3,
			'player2_id' => 2,
			'player1_score' => 3,
			'player2_score' => 1
		)));

		echo 'Get result: ';
		self::unitTest($ResultGet->call(array(
			'tournament_id' => 1
		)));

		echo 'Get user: ';
		self::unitTest($UserGet->call(array(
			'id' => 1
		)));

		echo 'Search for user: ';
		self::unitTest($UserSearch->call(array(
			'name' => 'a'
		)));

		echo 'Search for tournament: ';
		self::unitTest($TournamentSearch->call(array(
			'name' => 'a'
		)));

		echo 'Get fixtures: ';
		self::unitTest($FixturesGet->call(array(
			'user_id' => 1
		)));

		echo 'League table: ';
		self::unitTest($TournamentLeagueTable->call(array(
			'id' => 1
		)));

		echo 'User ratings: ';
		self::unitTest($UserRatings->call(array()));

		echo 'Enter result: ';
		self::unitTest($ResultEnter->call(array(
			'tournament_id' => 1,
			'player1_id' => 1,
			'player2_id' => 2,
			'player1_score' => 1,
			'player2_score' => 3
		)));

		echo 'Delete result: ';
		self::unitTest($ResultDelete->call(array(
			'id' => 2
		)));
	}
}

Test::init();

?>
	</tbody>
</table>

</body>
</html>