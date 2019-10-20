<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Не закрывайте страницу! Идет парсинг данных</title>
	<style>
		.container{width: 70%; margin: 0 auto;}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
	<h2 style="text-align: center;">Не закрывайте страницу! Идет парсинг данных</h2>
	<div class="container"></div>




 <script>
	$(document).ready(function()
	{
		<?php
			if (isset($_GET["page_number"]))
			{
				 echo "ajaxRequest(".$_GET["page_number"].");";
			}
		?>

		function ajaxRequest($num_page)
		{
			$.get(
				"step1.php",
				{ page_number: "<?php echo $_GET['page_number'];?>"},
				function(response)
				{
					if(response == "ПАРСИНГ ЗАВЕРШЁН УСПЕШНО!")
					{
						//alert("Парсинг завершен успешно!\nСейчас Вы будете перенаправлены на главную страницу.\nЗагруженные данные можете посмотреть по нажатию на кнопку 'Этап №3'");
						window.location.href = window.location.href.substring(0, window.location.href.lastIndexOf('/')) + "/";
					}
				}
			);
		}

		setTimeout(function()
		{
		
	  		window.location.href = "<?php 
				if (!isset($_GET['page_number']))
				{
					echo $_SERVER['PHP_SELF']."?page_number=0";
				}
				else
				{
					$pageNumber = (int)$_GET['page_number'] + 1;
					echo $_SERVER['PHP_SELF']."?page_number=".$pageNumber;
				}
	  		?>";
		}, 10000);

	});
 </script>
</body>
</html>
