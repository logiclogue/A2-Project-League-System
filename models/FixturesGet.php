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
		u1.id player1_id,
		u2.id player2_id,
		CONCAT(u1.first_name, ' ', u1.last_name) player1_name,
		CONCAT(u2.first_name, ' ', u2.last_name) player2_name,
		tu.tournament_id t_id_1,
		tu2.tournament_id t_id_2
		FROM users u1

		INNER JOIN users u2
		INNER JOIN tournament_user_maps tu
		ON tu.user_id = u1.id
		INNER JOIN tournament_user_maps tu2
		ON tu2.user_id = u2.id

		WHERE
		tu.tournament_id = tu2.tournament_id AND
		tu.is_player = TRUE AND
		tu2.is_player = TRUE AND
		u1.id <> u2.id AND
		CASE WHEN :tournament_id IS NULL THEN TRUE ELSE tu.tournament_id = :tournament_id END
		CASE WHEN :user_id IS NULL THEN u1.id > u2.id ELSE u1.id = :user_id END
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