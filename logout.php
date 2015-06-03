<?php 
	require_once("inc/session.php");
	require_once("inc/functions.php");

	unset($_SESSION["loggedin"]);
	unset($_SESSION["user_id"]);
	unset($_SESSION["userName"]);
	unset($_SESSION["firstName"]);
	unset($_SESSION["lastName"]);

	redirect_to("index.php");
	 ?>