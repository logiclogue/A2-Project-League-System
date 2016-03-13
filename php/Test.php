<!DOCTYPE html>
<html>
<head>
<title>Unit tests</title>

<link rel="stylesheet" href="../build/all.css">
</head>
<body>


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
	 * Method that should be called when starting a test.
	 *
	 * @method testStart
	 * @param testName {String}
	 * @private
	 * @static
	 */
	private static function testStart($testName) {
		$startHTML = <<<HTML
		<h1>$testName</h1>

		<table class="test">
			<thead>
				<th>Test</th>
				<th>Description</th>
				<th>Input data</th>
				<th>Expected result</th>
				<th>Result</th>
				<th>Pass</th>
			</thead>
			<tbody>
HTML;

		echo $startHTML;
	}

	/**
	 * Method that should be called when finished a test.
	 *
	 * @method testEnd
	 */
	private static function testEnd() {
		$endHTML = <<<HTML
			</tbody>
		</table>
HTML;

		echo $endHTML;
	}

	/**
	 * When making a single test, call this method.
	 * Puts row in table.
	 *
	 * @method unitTest
	 * @private
	 * @static
	 */
	private static function unitTest($modelName, $description, $data, $expected) {
		$model = new $modelName(true);
		$result = json_encode($model->call($data));
		$isPass = json_encode($result == $expected);

		echo '<tr class="' . $isPass . '">';
		echo '<td>' . $modelName . '</td>';
		echo '<td>' . $description . '</td>';
		echo '<td>' . json_encode($data) . '</td>';
		echo '<td>' . $expected . '</td>';
		echo '<td>' . $result . '</td>';
		echo '<td>' . $isPass . '</td>';
		echo '</tr>';
	}

	/**
	 * Method that loads the test.
	 *
	 * @method loadTest
	 * @private
	 * @static
	 */
	private static function loadTest($file_name) {
		require_once(dirname(__DIR__) . '/tests/' . $file_name . '.php');
	}


	/**
	 *
	 *
	 *
	 */
	public static function init() {
		self::requireAll();
		
		Database::reset();

		self::loadTest('RegisterLogin');
		self::loadTest('Leagues');
		//self::loadTest('Main.php');

		// Resets the database
		Database::reset();
	}
}

Test::init();

?>


</body>
</html>