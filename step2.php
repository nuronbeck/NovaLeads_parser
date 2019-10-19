<?php 

	// Функция для парсинга всех событии по матчу и сохранение в БД
	function gameAllContentLoad($team1, $team2, $gameLink)
	{
		require("db_config.php");

		$matchAllData = @file_get_contents($gameLink);
		$docMatchData = phpQuery::newDocument($matchAllData);

		// Скачиваем "Основные" ставки
		$mainBlock = $docMatchData->find(".category-container");
		// Скачиваем "Скрытые дополнительные" ставки
		$hiddenBlock = $docMatchData->find(".block-market-wrapper")->children();

		// "Все выборы" = "Основные" + "Скрытые дополнительные"
		$allBetsHtml = "".$mainBlock.$hiddenBlock;

		$sqlCommand = "INSERT INTO `game` (`team1`, `team2`, `url`, `html_data`) VALUES ('".$team1."', '".$team2."', '".$gameLink."', '".htmlentities($allBetsHtml, ENT_QUOTES)."')";
		mysqli_query($connection, $sqlCommand);
	}


	// Удаляет все строки в таблице, в качестве параметра указываем название таблицы
	function truncateTable($tableName)
	{
		require("db_config.php");
		mysqli_query($connection, "TRUNCATE `".$tableName."`");
	}
 ?>