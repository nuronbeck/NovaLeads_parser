<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>FETCHED DATA</title>
	<link rel="stylesheet" href="https://www.marathonbet.ru/cdn/3-0-763-87/styles/panbet_events.css">
	<link rel="stylesheet" href="https://www.marathonbet.ru/cdn/3-0-763-87/styles/panbet_pages.css">
	<link rel="stylesheet" href="https://www.marathonbet.ru/cdn/3-0-763-87/styles/panbet_vendors.css">

</head>
<body>
<?php 
	
	require("db_config.php");

	if (!isset($_GET['id_game']))
	{
		$allGame = mysqli_query($connection, "SELECT * FROM `game`");
		while ($gameData = mysqli_fetch_assoc($allGame))
		{	
			echo "<div style=\"text-align: center;\">";
			echo $gameData["team1"]." - ".$gameData["team2"];
			echo "<br>";
			echo "<a href=\"?id_game=".$gameData["ID_game"]."\">Открыть матч</a>";

			echo "</div>";
			echo "<hr>";
		}
	}
	else
	{
		$thisGameData = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `game` WHERE ID_game='{$_GET['id_game']}' "));

		echo html_entity_decode($thisGameData['html_data']);

	}
?>
</body>
</html>
