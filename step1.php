<?php 
	require("phpQuery.php");
	require("step2.php");

	// Пока матчи для парсинга есть перебор матчей работает
	$triggerOn = true;

	// PageNumber - это асинхронных запрос на сайте marathonbet.ru для вывода матчей в новом блоке по скроллингу
	// Пока матчи для парсинга есть перебор матчей работает по итератору $pageNumber
	// Пример GET запроса матчей для добавления на сайте после скроллинга
	// https://www.marathonbet.ru/su/popular/Football?page=[тут конкатенируем $pageNumber]&pageAction=getPage&_=1571422775084
	$pageNumber = 0;

	// Очищяем таблицу `game`
	truncateTable('game');

	while ($triggerOn)
	{
		$getDataLink = "https://www.marathonbet.ru/su/popular/Football?page=".$pageNumber."&pageAction=getPage&_=1571422775084";

		$loadData = @file_get_contents($getDataLink);

		// Если сервер на GET запрос ответил успешно с данными
		if (strpos($http_response_header[0], "200"))
		{ 
			$decodedData = json_decode($loadData);
			$html = "".$decodedData[0]->content;
			//echo $html;


			$doc = phpQuery::newDocument($html);
			// Перебираем все матчи по css классу .member-area-content-table
			$data = $doc->find(".member-area-content-table");

			// Каждый матч парсим внутренности по отдельности
			// Классы матчей отличаются. Они делятся на две структуры. Поэтому дальше пошло разветление по if и else 
			foreach ($data as $elem)
			{	
				$p = pq($elem);

				if ($p->find(".today-name:eq(0)")->text() != "")
				{
					echo $p->find(".today-name:eq(0) .member-link")->text();
					echo " — ";
					echo $p->find(".today-name:eq(1) .member-link")->text();
					echo "<br>";
					echo "<a href=\"https://www.marathonbet.ru".$p->find(".today-name:eq(1) .command div .member-link")->attr("href")."\">Открыть матч в MarathonBet.ru</a>";

					$team1_name = (string)$p->find(".today-name:eq(0) .member-link")->text();
					$team2_name = (string)$p->find(".today-name:eq(1) .member-link")->text();
					$gameUrlPage = (string)"https://www.marathonbet.ru".$p->find(".today-name:eq(1) .command div .member-link")->attr("href");

					// Сохраняем данные матча в БД. HTML cодержимое данного матча парсится в третьем этапе (step3.php)
					gameAllContentLoad($team1_name, $team2_name, $gameUrlPage);
					
				}
				else
				{
					echo $p->find("tr:eq(0) .name .member-link")->text();
					echo " — ";
					echo $p->find("tr:eq(1) .name .member-link")->text();
					echo "<br>";
					echo "<a href=\"https://www.marathonbet.ru".$p->find("tr:eq(1) .name .command div .member-link")->attr("href")."\">Открыть матч в MarathonBet.ru</a>";

					$team1_name = (string)$p->find("tr:eq(0) .name .member-link")->text();
					$team2_name = (string)$p->find("tr:eq(1) .name .member-link")->text();
					$gameUrlPage = (string)"https://www.marathonbet.ru".$p->find("tr:eq(1) .name .command div .member-link")->attr("href");

					// Сохраняем данные матча в БД. HTML cодержимое данного матча парсится в третьем этапе (step3.php)
					gameAllContentLoad($team1_name, $team2_name, $gameUrlPage);
					
				}
				echo "<hr>";
				
			}


			// Вывод всех доступных категории футбольных матчей если понадобится
			/*
			$doc = phpQuery::newDocument($html);
			$data = $doc->find(".category-label-link");

			foreach ($data as $elem)
			{
				$p = pq($elem);
				echo $p->find("h2")->text();
				echo "<hr>";
			}
			*/
		}
		else
		{ 
			$triggerOn = false;
			//echo "ПАРСИНГ ЗАВЕРШЁН УСПЕШНО!";
		}

		// Переходим на след страницу GET запроса
		$pageNumber += 1;

		// Не много расслабляем сервер :))
		//sleep(3);
	}

 ?>