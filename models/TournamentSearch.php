<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Model that is used to search for a tournament by name.
 *
 * @class TournamentSearch
 * @extends Model
 */
/*&
 * @param name {String} Search for tournament with similar name.
 *
 * @return tournaments {Array} Array of all tournaments that match.
 *   @return [].id {Integer} Id of the tournament.
 *   @return [].name {String} Name of the tournament.
 */
class TournamentSearch extends Model
{
	/**
	 * SQL query string for searching for tournaments and returning their name and id.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT id, name
		FROM tournaments
		WHERE
		name LIKE :name
SQL;


	/**
	 * Main method.
	 * Used to execute @property query.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		// Redefine @param name, SQL syntax for searching with 'LIKE'.
		$this->data['name'] = '%' . $this->data['name'] . '%';

		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':name', $this->data['name']);

		if ($stmt->execute()) {
			$this->return_data['tournaments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
	}
}

?>