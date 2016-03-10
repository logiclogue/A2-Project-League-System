<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');


/**
 * Model that is used to search for a user.
 *
 * @class UserSearch
 * @extends Model
 */
/*&
 * @param name {String} Search for user with similar name.
 *
 * @return users {Array} Array of all users that match.
 *    @return [].id {Integer} Id of the user.
 *    @return [].name {String} Full name of the user.
 */
class UserSearch extends Model
{
	/**
	 * SQL query string for searching for users and returning their name and id.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT id, CONCAT(first_name, ' ', last_name) name
		FROM users
		WHERE
		CONCAT(first_name, ' ', last_name) LIKE :name
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
			$this->return_data['users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
	}
}

?>
