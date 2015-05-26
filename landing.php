<?php # landing.php ?>

<?php $page_title = "A-Z Home Inventory"; ?>
<?php $page_heading = "Home Inventory" ?>
<?php require_once "inc/header.inc.php"; ?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory</title> -->
<!-- 	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css"> -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->     <!-- jQuery CDN -->
	<!-- <script src="jquery/nav_mouse.js">	</script> -->           <!--  Navigation Mouseover Script -->

<!-- </head>
<body>
	<div class="page_wrapper"> -->

	<?php 
		//include "inc/header3.inc.php";      // adds Header #2 to the page
	 ?>

	<div class="content">
		<div class="property_wrapper">
			<div class="property_box">
				<img src="images/addams-home.jpg" sizes="5vw" alt="Family Home">
				<p>Addams Family Home</p>
				<p>0001 Cemetery Lane</p>
				<p>25 Rooms</p>
			</div>    <!-- end of property box -->
		</div>    <!-- end of property wrapper   -->
		<div class="property_wrapper">
			<div class="add_new_property">
				<p>Add New Property</p>
			</div>    <!-- end of add_new -->
		</div>    <!-- end of property wrapper   -->
	</div>   <!-- end of content -->
</body>
</html>