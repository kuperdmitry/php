<?php

class Tournament
{
	private $id;
	private $title;
	private $dateOfBegin;

	public function __construct($mysqli, $id, $title, $dateOfBegin = null)
	{
		$this->id = $id;
		$this->title = $title;
		$this->players = array();
		if ($dateOfBegin != null)
		{
			$this->dateOfBegin = dateTime::createFromFormat('Y.m.d', $dateOfBegin);
		} else {
			$this->dateOfBegin = (new DateTime('NOW'))->modify('1 day');
		}	
	
		$dateForMySQL = $this->dateOfBegin->format('Y-m-d');
		$sql = 'INSERT INTO tournament ('
		     . 'id, '
		     . 'name, '
		     . 'start_date '
		     . ') VALUES (' . $id . ', "'.$title.'", "'.$dateForMySQL.'")';
		$mysqli->query($sql);
	}

	public static function createTable($mysqli)
	{
		$sql = 'CREATE TABLE IF NOT EXISTS tournament ('
		     . 'id INT UNSIGNED NOT NULL, '
		     . 'name VARCHAR(12) NOT NULL, '
		     . 'start_date date, '
		     . 'PRIMARY KEY (id)'
		     . ')';

		$mysqli->query($sql);

		$sql = 'CREATE TABLE IF NOT EXISTS assign ('
		     . 'tournament_id INT UNSIGNED NOT NULL, '
		     . 'player_id INT UNSIGNED NOT NULL, '
		     . 'FOREIGN KEY (tournament_id) REFERENCES tournament(id), '
		     . 'FOREIGN KEY (player_id) REFERENCES player(id) '
		     . ')';

		$mysqli->query($sql);
	}

	public function addPlayer($mysqli, $player)
	{
		$tournament_id = $this->id;
		$player_id = $player->getId();

		$sql = 'INSERT INTO assign ('
		     . 'tournament_id, '
		     . 'player_id '
		     . ') VALUES (' . $tournament_id . ', ' . $player_id. ')';

		$mysqli->query($sql);
		return $this;
	}

	public function submitChanges($mysqli)
	{
		$id = $this->id;
		$title = $this->title;
		$dateForMySQL = $this->dateOfBegin->format('Y-m-d');

		$sql = 'UPDATE tournament SET '
		     . 'name="$title", '
		     . 'start_date="'.$dateForMySQL.'" '
		     . 'WHERE id=$id';

		$mysqli->query($sql);
	}

	public function getPlayers($mysqli)
	{
		$out = '';

		$sql = "SELECT tournament.name as title, player.name "
		     . "FROM tournament INNER JOIN "
		     . "(player INNER JOIN assign ON player.id = assign.player_id) "
		     . " ON tournament.id = assign.tournament_id AND tournament.id=" . $this->id;

		$result = $mysqli->query($sql);

		while ($row = $result->fetch_assoc())
		{
			$out .= $row['title'] . " ";
			$out .= $row['name'] . " ";

			$out .= '<br>';
		}
		$result->close();

		return $out;
	}
}
?>