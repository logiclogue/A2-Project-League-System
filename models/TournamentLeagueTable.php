<?php

require_once(dirname(__DIR__) . '/php/Model.php');
require_once(dirname(__DIR__) . '/php/Database.php');


class TournamentLeagueTable extends Model
{
	private $query = <<<SQL
		SELECT
		ru.user_id,
		CONCAT(u.first_name, ' ', u.last_name) name,
		COUNT(ru.user_id) played,
		SUM(ru.score = 3) wins,
		SUM(ru.score <> 3) loses,
		SUM(ru.score) points
		FROM result_user_maps ru
		INNER JOIN users u
		ON u.id = user_id
		INNER JOIN results r
		ON r.id = ru.result_id
		WHERE r.tournament_id = :id
		GROUP BY user_id
		ORDER BY points DESC
SQL;


	protected function main() {
		$stmt = Database::$conn->prepare($this->query);

		$stmt->bindParam(':id', $this->data['id']);

		if ($stmt->execute()) {
			$this->return_data['table'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			$this->success = false;
			$this->error_msg = "Failed to execute query";
		}
	}
}

$TournamentLeagueTable = new TournamentLeagueTable();

?>