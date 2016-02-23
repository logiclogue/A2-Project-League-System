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
 * @return leagues_playing {Array}
 *   @return leagues_playing[].id {Integer} Id of league playing in.
 *   @return leagues_playing[].name {String} Name of league playing in.
 * @return  leagues_managing {Array}
 *   @return leagues_managing[].id {Integer} Id of league managing.
 *   @return leagues_managing[].name {String} Name of league managing.
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
		WHERE
		id = :id
SQL;

	/**
	 * SQL query string for getting tournaments that the user is managing.
	 *
	 * @property query_managing
	 * @type String
	 * @private
	 */
	private $query_managing = <<<SQL
		SELECT t.id, t.name
		FROM tournaments t
		INNER JOIN tournament_user_maps tu
		ON tu.tournament_id = t.id
		WHERE
		tu.user_id = :id AND
		tu.is_league_manager = TRUE
SQL;

	/**
	 * SQL query string for getting tournaments that the user is playing in.
	 *
	 * @property query_playing
	 * @type String
	 * @private
	 */
	private $query_playing = <<<SQL
		SELECT t.id, t.name
		FROM tournaments t
		INNER JOIN tournament_user_maps tu
		ON tu.tournament_id = t.id
		WHERE
		tu.user_id = :id AND
		tu.is_player = TRUE
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
	 * Get tournament playing in.
	 *
	 * @method getPlaying
	 * @private
	 */
	private function getPlaying() {
		$stmt = Database::$conn->prepare($this->query_playing);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data['leagues_playing'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Method for getting tournaments managing
	 *
	 * @method getManaging
	 * @private
	 */
	private function getManaging() {
		$stmt = Database::$conn->prepare($this->query_managing);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data['leagues_managing'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

	/**
	 * Method for getting user data.
	 *
	 * @method getUserData
	 * @private
	 * @return {Boolean} Whether user exists
	 */
	private function getUserData() {
		$this->stmt = Database::$conn->prepare($this->query);

		$this->stmt->bindParam(':id', $this->data['id']);

		if ($this->executeQuery()) {
			return $this->verifyResult();
		}
		else {
			return false;
		}
	}

	/**
	 * Main method.
	 * If the user exists, it gets tournament data.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if ($this->getUserData()) {
			$this->getPlaying();
			$this->getManaging();
		}
	}
}

?>