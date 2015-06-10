<?php require_once("inc/session.php");
require_once("../az/inc/functions.php");

if (!isset($_SESSION["userName"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["logged_in"])) redirect_to("login.php"); 
$userid = 0;
if (isset($_SESSION["user_id"])) $userid = (int) $_SESSION["user_id"];
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="./jquery/jquery.dataTables.css">
	<link rel="stylesheet" href="jquery/themes/default/style.min.css" />
	<link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic' rel='stylesheet' type='text/css'>
	<script src="jquery/jquery.2.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="jquery/jquery-ui.min.css">
	<!--  <script src="jquery/nav_mouse.js"></script> Navigation Mouseover Script -->
	<script type="text/javascript" language="javascript" src="jquery/jquery.dataTables.js"></script> <!-- Grid init -->
	<script src="jquery/jstree.min.js"></script> <!-- Tree init -->
	<script src="jquery/jquery.serialize-object.min.js"></script> <!-- JSON helper init -->
</head>
<body>
	<div class="page_wrapper">
		<header>
			<div class="side_logo">
				<a href="landing.php">
					<img class="small_logo" src="images/logo.png" alt="A-Z Home Inventory Logo" sizes="25vw" srcset="images/logo.png 1000w">
				</a>
			</div>
			<div class="header_title">
				<h1 id="header_session_name">
					<?php //this displays the user's name in the header, checks if the last name ends in "s", and displays the correct punctuation
						echo $_SESSION["firstName"] . " " . $_SESSION["lastName"];
						if (substr($_SESSION["lastName"], -1) == "s") {
							echo "' Properties";
							} else {
								echo "'s Properties";
								} //endif ?>
				</h1>
				<h2 id="header_session_subtitle"><?php echo $page_heading; ?></h2>
			</div>  <!-- end of header_title -->
			<?php require_once ("/inc/nav.inc.php"); ?>
		</header> <!-- End Header -->
		<?php if (isset($min_type)) {
			check_access($userid, $min_type);
		} ?>