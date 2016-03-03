<!DOCTYPE html>
<html>
<head>
<title>Unit tests</title>
</head>
<body>

<table>
	<thead>
		<th>Test</th>
		<th>Description</th>
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
	private static function unitTest($modelName, $description, $data) {
		$model = new $modelName(true);
		
		echo '<tr>';
		echo '<td>' . $modelName . '</td>';
		echo '<td>' . $description . '</td>';
		echo '<td>' . nl2br(json_encode($data, JSON_PRETTY_PRINT)) . '</td>';
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

		self::unitTest(
			'Register',
			'Register user',
			array(
				'email' => 'me@email.com',
				'password' => 'password',
				'first_name' => 'Jordan',
				'last_name' => 'Lord'
			)
		);

		self::unitTest(
			'Register',
			'Register user',
			array(
				'email' => 'new@email.com',
				'password' => 'pass123',
				'first_name' => 'New',
				'last_name' => 'User'
			)
		);

		self::unitTest(
			'Register',
			'Register user',
			array(
				'email' => 'another@user.com',
				'password' => 'password',
				'first_name' => 'Another',
				'last_name' => 'User'
			)
		);

		self::unitTest(
			'Login',
			'Login',
			array(
				'email' => 'me@email.com',
				'password' => 'password'
			)
		);

		self::unitTest(
			'TournamentCreate',
			'Create tournament',
			array(
				'name' => 'Premier League',
				'description' => 'A league'
			)
		);

		self::unitTest(
			'TournamentUpdate',
			'Update tournament info',
			array(
				'id' => 1,
				'name' => 'Premier League',
				'description' => 'Top tier of Primrose Squash Leagues'
			)
		);

		self::unitTest(
			'TournamentGet',
			'Tournament data',
			array(
				'id' => 1
			)
		);

		self::unitTest(
			'TournamentPlayerAttach',
			'Add player in tournament',
			array(
				'user_id' => 1,
				'tournament_id' => 1
			)
		);

		self::unitTest(
			'TournamentManagerRemove',
			'Remove league manager',
			array(
				'user_id' => 1,
				'tournament_id' => 1
			)
		);

		self::unitTest(
			'TournamentManagerAttach',
			'Add league manager',
			array(
				'user_id' => 1,
				'tournament_id' => 1
			)
		);

		self::unitTest(
			'TournamentManagerAttach',
			'Add league_manager',
			array(
				'user_id' => 2,
				'tournament_id' => 1
			)
		);

		self::unitTest(
			'TournamentPlayerAttach',
			'Add player in tournament',
			array(
				'user_id' => 2,
				'tournament_id' => 1
			)
		);

		self::unitTest(
			'TournamentPlayerAttach',
			'Add player in tournament',
			array(
				'user_id' => 3,
				'tournament_id' => 1
			)
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
			)
		);

		self::unitTest(
			'ResultGet',
			'Get result',
			array(
				'tournament_id' => 1
			)
		);

		self::unitTest(
			'UserGet',
			'Get user',
			array(
				'id' => 1
			)
		);

		self::unitTest(
			'UserSearch',
			'Search for user',
			array(
				'name' => 'a'
			)
		);

		self::unitTest(
			'TournamentSearch',
			'Search for tournament',
			array(
				'name' => 'a'
			)
		);

		self::unitTest(
			'FixturesGet',
			'Get fixtures',
			array(
				'user_id' => 1
			)
		);

		self::unitTest(
			'TournamentLeagueTable',
			'League table',
			array(
				'id' => 1
			)
		);

		self::unitTest(
			'UserRatings',
			'User ratings',
			array()
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
			)
		);

		self::unitTest(
			'ResultDelete',
			'Delete result',
			array(
				'id' => 2
			)
		);
	}
}

Test::init();

?>
	</tbody>
</table>

</body>
</html>