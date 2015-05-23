<?php # landing.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory - Add Item</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     <!-- jQuery CDN -->
	<script src="jquery-ui-1.11.4/jquery-ui.js"></script>
	<link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.css">
	<script src="jquery/nav_mouse.js">	</script>           <!--  Navigation Mouseover Script -->
  	<script>
  		$(function() {
    		$( "#tabs" ).tabs();
  		});
  	</script>

</head>
<body>
	<div class="page_wrapper">

	<?php 
		include "includes/mysqli_connect.inc.php";   //    connects to the MySQL Database
		include "includes/header3.inc.php";      // adds Header #2 to the page
	 ?>
	<div class="content">

	<div id="tabs">
	  	<ul>
		    <li><a href="#tabs-1">Property</a></li>
		    <li><a href="#tabs-2">Taxes</a></li>
		    <li><a href="#tabs-3">Multimedia</a></li>
		    <li><a href="#tabs-4">Documents</a></li>
		    <li><a href="#tabs-5">Notes</a></li>

	  	</ul>
	  	<div id="tabs-1" class="property_tab tabs_nav">





		</div>

		<div id="tabs-2" class="taxes_tab tabs_nav">
	 
		</div>
		<div id="tabs-3" class="multimedia_tab tabs_nav">

		</div>

		<div id="tabs-4" class="documents_tab tabs_nav">
	 
		</div>

		<div id="tabs-5" class="notes_tab tabs_nav">
	 
		</div>		



</body>
</html>