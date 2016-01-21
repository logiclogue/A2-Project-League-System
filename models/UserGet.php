<?php

require_once(dirname(__DIR__) . '/php/Database.php');
require_once(dirname(__DIR__) . '/php/Model.php');

session_start();


/**
 * Model for querying a user based on the id.
 *
 * @class UserGet
 * @extends Model
 */
/**
 * @param id {Integer} Id of the user to be fetched.
 *
 * @return id {Integer} Id of the user.
 * @return first_name {String} First name of the user.
 * @return last_name {String} Last name of the user.
 */
class UserGet extends Model
{
	/**
	 * SQL query string for fetching the user's data.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT first_name, last_name, id
		FROM users
		WHERE id = :id
SQL;

	/**
	 * Database object for executing query.
	 *
	 * @property stmt
	 * @type Object
	 * @private
	 */
	private $stmt;


	/**
	 * Method that verifies whether the requested user is the one returned.
	 *
	 * @method verifyResult
	 * @private
	 * @return {Boolean} Whether the result matches request.
	 */
	private function verifyResult() {
		if ($this->return_data['id'] == $this->data['id']) {
			return true;
		}
		else {
			$this->error_msg = "User doesn't exist";
			$this->success = false;

			return false;
		}
	}

	/**
	 * Method that executes the query.
	 *
	 * @method executeQuery
	 * @private
	 * @return {Boolean} Whether executed query successfully.
	 */
	private function executeQuery() {
		if ($this->stmt->execute()) {
			$this->return_data = $this->stmt->fetchAll(PDO::FETCH_ASSOC)[0];

			return true;
		}
		else {
			$this->error_msg = "Failed to execute query";
			$this->success = false;

			return false;
		}
	}

	/**
	 * Main method.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':id', $this->data['id']);

		if ($this->executeQuery()) {
			$this->verifyResult();
		}
	}
}

$UserGet = new UserGet();

?>