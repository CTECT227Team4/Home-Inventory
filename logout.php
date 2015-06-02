<?php 
	require_once("inc/session.php");
	require_once("inc/functions.php");

	//reset all session variables
	$_SESSION["loggedin"] = "";
	$_SESSION["user_id"] = "";
	$_SESSION["userName"] = "";
	$_SESSION["firstName"] = "";
	$_SESSION["lastName"] = "";

	redirect_to("index.php");
	 ?>