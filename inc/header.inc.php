<?php require_once("/inc/session.php");
require_once("../az/inc/functions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="jquery/jquery.2.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="jquery/jquery-ui.min.css">
	<script src="jquery/nav_mouse.js"></script>           <!--  Navigation Mouseover Script -->
</head>
<body>
	<div class="page_wrapper">
		<header>
			<div class="side_logo">
				<img class="small_logo" src="images/logo.png" alt="A-Z Home Inventory Logo" sizes="30vw" srcset="images/logo.png 1000w">
			</div>
			<h1><?php echo $_SESSION["firstName"] . " " . $_SESSION["lastName"] . "'s Properties"; ?></h1>
			<h2><?php echo $page_heading ?></h2>
			<?php require_once ("/inc/nav.inc.php"); ?>
		</header> <!-- End Header -->