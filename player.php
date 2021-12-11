<?php

class Player
{
	private $id;
	private $name;
	private $city;
	
	public function __construct($mysqli, $id, $name)
	{
		$this->id = $id;
		$this->name = $name;
		$this->city = '';

		$sql = 'INSERT INTO player ('
		     . 'id, '
		     . 'name, '
		     . 'city '
		     . ') VALUES ('.$id.', "'.$name.'", "'.$city.'")';
		$mysqli->query($sql);
	}

	public static function createTable($mysqli)
	{
		$sql = 'CREATE TABLE IF NOT EXISTS player ('
		     . 'id INT UNSIGNED NOT NULL, '
		     . 'name VARCHAR(20), '
		     . 'city VARCHAR(20), '
		     . 'PRIMARY KEY (id)'
		     . ')';
		$mysqli->query($sql);
	}

	public function getId()
	{
		return $this->id;
	}

	public function setCity($city)
	{
		$this->city = $city;
		return $this;
	}

	public function __toString()
	{
		$out = $this->name;
		if (!empty($this->city)) {
			$out .= ' (' . $this->city . ')';
		}
		return $out;
	}

	public function submitChanges($mysqli)
	{
		$id = $this->id;
		$name = $this->name;
		$city = $this->city;

		$sql = 'UPDATE player SET '
		     . 'name="$name", '
		     . 'city="$city" '
		     . 'WHERE id=$id';

		$mysqli->query($sql);
	}
}
?>