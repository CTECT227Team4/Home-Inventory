<?php 
# Connect to database
		$host = "localhost";
		$username = "root";
		$password = "";
		$db = "az";
		$dbc = mysqli_connect($host,$username,$password,$db) OR die("<p>Could not connect to database</p>");

		mysqli_set_charset($dbc,'utf8');
 ?>