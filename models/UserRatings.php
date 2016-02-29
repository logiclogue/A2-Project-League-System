<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


/**
 * Model when called will return all the user's ratings over time.
 *
 * @class UserRatings
 * @extends Model
 */
/**
 * @param user_id {Integer} Id of the user to query.
 *
 * @return ratings {Array} Array of all the ratings over time.
 *   @return [].rating {Integer} Rating at that moment in time.
 *   @return [].rating_change {Integer} Change of rating.
 *   @return [].date {String} Date and time when rating was the value.
 */
class UserRatings extends Model
{
	/**
	 * SQL query string that fetches all the user's ratings over time.
	 *
	 * @property query
	 * @type String
	 * @private
	 */
	private $query = <<<SQL
		SELECT
		ru.rating,
		ru.rating_change,
		r.date
		FROM result_user_maps ru
		INNER JOIN results r
		ON r.id = ru.result_id
		WHERE ru.user_id = :id
		ORDER BY r.date DESC
SQL;


	/**
	 * Method that executes @property query.
	 *
	 * @method general
	 * @private
	 */
	private function general() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['user_id']);

		if ($stmt->execute()) {
			$this->return_data['ratings'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->error_msg = "Failed to execute query";
			$this->success = false;
		}
	}

	/**
	 * Checks whether user is logged in then calls @method general.
	 *
	 * @method main
	 * @protected
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->general();
		}
		else {
			$this->error_msg = "You must be logged in";
			$this->success = false;
		}
	}
}

?>