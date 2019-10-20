<?php 
	$connection = mysqli_connect("remotemysql.com", "mnII3NKS1G", "KdP0Bey3AW", "mnII3NKS1G");

	if ($connection == false)
	{
		echo "<h2>CONNECTION FALSE!</h2>";
		exit();
	}
 ?>