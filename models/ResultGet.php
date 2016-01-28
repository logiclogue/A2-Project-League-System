<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');


/**
 * Model for retrieving information on a particular result.
 *
 * @class ResultGet
 * @extends Model
 */
class ResultGet extends Model
{
	/**
	 * SQL query string for getting result information.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL

SQL;


	/**
	 * Main method.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':')
	}
}

$ResultGet = new ResultGet();

?>