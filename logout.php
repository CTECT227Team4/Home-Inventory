<?php 
	session_start();
	$_SESSION['loggedin'] = "";
	$_SESSION['user'] = "";
	header("Location: login.php");
	 ?>