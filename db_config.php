<?php 
	$connection = mysqli_connect("127.0.0.1", "root", "", "marathonBet_dump");

	if ($connection == false)
	{
		echo "<h2>CONNECTION FALSE!</h2>";
		exit();
	}
 ?>