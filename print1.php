<?php # print1.php
$page_title = "Home Inventory - Printable"; //sets title
$page_heading = "Print Inventory By Property"; //sets heading to appear on page

require_once("/inc/session.php");
require_once("../az/inc/functions.php");

if (!isset($_SESSION["userName"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["logged_in"])) redirect_to("login.php"); 
$userid = 0;
if (isset($_SESSION["user_id"])) $userid = (int) $_SESSION["user_id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $page_title; ?></title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" href="css/print.css">
	<link rel="stylesheet" type="text/css" href="./jquery/jquery.dataTables.css">
	<link rel="stylesheet" href="jquery/themes/default/style.min.css" />
	<link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic' rel='stylesheet' type='text/css'>
	<script src="jquery/jquery.2.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="jquery/jquery-ui.min.css">
	<script type="text/javascript" language="javascript" src="./jquery/jquery.dataTables.js"></script> <!-- Grid init -->
	<script src="./jquery/jstree.min.js"></script> <!-- Tree init -->
	<script src="jquery/jquery.serialize-object.min.js"></script> <!-- JSON helper init -->
	<script>
		$("document").ready(function(){
		  	onClick=" window.print();
	      	return false";
		});
	</script>
</head>
<body>
	<div class="page_wrapper">
		<header>
			<div class="side_logo">
				<img class="small_logo" src="images/logo.png" alt="A-Z Home Inventory Logo" >
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
				<div class="property_image">
					<img src="images/addams-home.jpg" alt="Addams Family House">
				</div>    <!-- end of property_image -->
			</div>  <!-- end of header_title -->
		</header> <!-- End Header -->

		<div class="content">

			<div class="print_headings">
				<p class="heading1">Addams Family Home</p>
				<p class="heading2">0001 Cemetery Lane, Hollywood, CA</p>
				<hr class="border">
			</div>    <!-- end of print_headings -->

			<div class="buttons no_print">

				<button class="report_buttons"><a href="#" onClick=" window.print(); return false">Print this page</a></button>
				<button class="report_buttons"><a href="reports.php">Close This Page</a></button>

			</div>
			<div class="print_data">
				<div class="print_categories">
					<table class="inventory_by_property">
						<tr class="room">
							<th>Room Name</th>
							<th>Room Description</th>
							<th>Est. Replacement Cost</th>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr class="section">
							<th>Section Name</th>
							<th>Room Description</th>
							<th>Est. Replacement Cost</th>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr class="room">
							<th>Room Name</th>
							<th>Room Description</th>
							<th>Est. Replacement Cost</th>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
						<tr>
							<td>Item Name</td>
							<td>Item Description</td>
							<td>$</td>
						</tr>
					</table>   <!-- end of property_by_inventory table -->

				</div>   <!-- end of print_categories -->

			</div>   <!--  end of print_data -->
			<div class="buttons no_print">
				<hr class="border">
				<button class="report_buttons"><a href="#" onClick=" window.print(); return false">Print this page</a></button>
				<button class="report_buttons"><a href="reports.php">Close This Page</a></button>
			</div>
		</div>   <!--  end of content -->
	</div>   <!-- end of wrapper -->

</body>
</html>