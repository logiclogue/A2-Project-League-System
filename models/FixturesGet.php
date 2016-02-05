<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


/**
 * Model that returns fixture list for a tournament or user.
 *
 * @class FixturesGet
 * @extends Model
 */
/**
 *
 *
 */
class FixturesGet extends Model
{
	/**
	 *
	 *
	 *
	 */
	private $query = <<<SQL
		SELECT
		u.id,
		CONCAT(u.first_name, ' ', u.last_name) name,
		tu.is_player,
		tu.tournament_id
		FROM users u
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u.id
		WHERE
		tu.tournament_id = 1 AND
		tu.is_player = TRUE AND
		u.id <> :user_id
SQL;


	/**
	 *
	 *
	 *
	 */
	protected function main() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':user_id', $this->data['user_id']);

		if ($stmt->execute()) {
			
		}
	}
}

?>