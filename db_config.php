<?php 
	$connection = mysqli_connect("eu-cdbr-west-02.cleardb.net", "b02a5ef2a06370", "90106657", "heroku_e2596b9a4c8c9fd");

	if ($connection == false)
	{
		echo "<h2>CONNECTION FALSE!</h2>";
		exit();
	}
 ?>