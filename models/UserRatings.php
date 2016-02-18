<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');

session_start();


class UserRatings extends Model
{
	private function general() {
		$stmt = Database::$conn->prepare($query);

		$stmt->bindParam(':id', $_SESSION['user']['id']);

		if ($stmt->execute()) {
			
		}
	}

	/**
	 * Checks whether user is logged in then calls @method general.
	 *
	 * @method main
	 */
	protected function main() {
		if (isset($_SESSION['user'])) {
			$this->general();
		}
		else {
			$this->success = false;
		}
	}
}

?>