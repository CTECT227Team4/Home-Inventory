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
			<form method="Post" action="process_add_property.php" id="add_property">
				<p class="one_wide">     
					<label for="name">Property Name:</label>
					<input id="name" type="text" name="name">    
				</p>
				<p class="one_wide" class="space">
					<label for="address">Property Address:</label>
					<input id="address" type="text" name="address">
				</p>
				<p class="one_wide" class="space">
					<label for="address2"></label>
					<input id="address2" type="text" name="address2">
				</p>
				<p class="two_wide">     <!--  makes two inputs on one line -->
					<label for="zip">Zipcode:</label>
					<input id="zip" type="text" name="zip">    
				</p>
				<p class="two_long_wide">      <!--  makes two inputs on one line -->
					<label for="county">Property County:</label>
					<input id="county" type="text" name="county">       
				</p>
				<p class="two_wide">     <!--  makes two inputs on one line -->
					<label for="city">City:</label>
					<input id="city" type="text" name="city">    
				</p>
				<p class="two_wide">      <!--  makes two inputs on one line -->
					<label for="state">State:</label>
					<input id="state" type="text" name="state">       
				</p>
				<p class="one_wide short">      <!--  makes two inputs on one line -->
					<label for="year_built">Year Built:</label>
					<input id="year_built" type="text" name="year_built">       
				</p>
				<p class="two_long_wide">      <!--  makes two inputs on one line -->
					<label for="year_purchased">Year Purchased:</label>
					<input id="year_purchased" type="text" name="year_purchased">       
				</p>
				<p class="two_long_wide">      <!--  makes two inputs on one line -->
					<label for="price">Purchase Price:</label>
					<input id="price" type="text" name="price">       
				</p>
				<p class="one_wide_text">     
					<label for="description">Description:</label>
					<input id="description" type="textarea" name="description">    
				</p>				
		</div>    <!-- end tab 1 -->

		<div id="tabs-2" class="taxes_tab tabs_nav">
				<p class="one_wide">     
					<label for="property_taxID">Property Tax ID No.:</label>
					<input id="property_taxID" type="text" name="property_taxID">    
				</p>
				<p class="one_wide">
					<label for="gis_url">Property Tax GIS URL:</label>
					<input id="gis_url" type="text" name="gis_url">
				</p>
 
		</div>     <!-- end tab 2 -->
		<div id="tabs-3" class="multimedia_tab tabs_nav">
				<p class="one_wide">     
					<label for="multimedia_name">Name:</label>
					<input id="multimedia_name" type="text" name="multimedia_name">    
				</p>
				<p class="one_wide">
					<label for="image_type">Type of Image:</label>
					<input id="image_type" type="text" name="image_type">
				</p>	
				<p class="one_wide_text">     
					<label for="multimedia_description">Description:</label>
					<input id="multimedia_description" type="textarea" name="multimedia_description">    
				</p>
		</div>    <!-- end tab 3 -->

		<div id="tabs-4" class="documents_tab tabs_nav">
				<p class="one_wide">     
					<label for="document_name">Name:</label>
					<input id="document_name" type="text" name="document_name">    
				</p>
				<p class="one_wide_text">     
					<label for="document_description">Description:</label>
					<input id="document_description" type="textarea" name="document_description">    
				</p>
	 
		</div>     <!-- end tab 4 -->

		<div id="tabs-5" class="notes_tab tabs_nav">
				<p class="one_wide_text">     
					<label for="general_notes">Notes:</label>
					<input id="general_notes" type="textarea" name="general_notes">    
				</p>	 
		</div>		<!-- end tab 5 -->

				<p>
					<input type="submit" value="OK" class="centered_button" id="add_property">
				</p>
			</form>

</body>
</html>