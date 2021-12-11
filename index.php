<?

	$mysqli = new mysqli(...);

	include ('./player.php');
	include ('./tournament.php');

	$mysqli->query('DROP TABLE player');
	$mysqli->query('DROP TABLE tournament');
	$mysqli->query('DROP TABLE assign');

	Player::createTable($mysqli);
	Tournament::createTable($mysqli);

	$tornamentA = new Tournament ($mysqli, 1, "Tournament A");
	$tornamentB = new Tournament ($mysqli, 2, "Tournament B");
	$tornamentC = new Tournament ($mysqli, 3, "Tournament C");

	$player1 = new Player ($mysqli, 1, "Player 1");
	$player2 = new Player ($mysqli, 2, "Player 2");
	$player3 = new Player ($mysqli, 3, "Player 3");
	$player4 = new Player ($mysqli, 4, "Player 4");
	$player5 = new Player ($mysqli, 5, "Player 5");

	$tornamentA->addPlayer($mysqli, $player1);
	$tornamentA->addPlayer($mysqli, $player2);

	$tornamentB->addPlayer($mysqli, $player1);
	$tornamentB->addPlayer($mysqli, $player2);
	$tornamentB->addPlayer($mysqli, $player3);

	$tornamentC->addPlayer($mysqli, $player3);
	$tornamentC->addPlayer($mysqli, $player4);	
	$tornamentC->addPlayer($mysqli, $player5);

	$out = '';
	$out .= $tornamentA->getPlayers($mysqli);
	$out .= $tornamentB->getPlayers($mysqli);
	$out .= $tornamentC->getPlayers($mysqli);

	echo $out;
?>