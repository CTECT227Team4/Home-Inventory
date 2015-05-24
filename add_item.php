<?php # landing.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory - Add Item</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     <!-- jQuery CDN -->
	<script src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
	<script src="jquery/nav_mouse.js">	</script>           <!--  Navigation Mouseover Script -->
  	<script>
  		$(function() {
    		$( "#tabs" ).tabs();
  		});
  		$(function() {
    		$( "#resizable" ).resizable({
      			handles: "se"
   			 });
  		});
 		$(function() {
    		$( "#resizable2" ).resizable({
      			handles: "se"
   			 });
  		});
  		$(function() {
    		$( "#resizable3" ).resizable({
      			handles: "se"
   			 });
  		});
		$(function() {
			$( "#resizable4" ).resizable({
	  			handles: "se"
			 });
		});
  	</script>

</head>
<body>
	<div class="page_wrapper">

	<?php 
		include "inc/header3.inc.php";      // adds Header #2 to the page
	 ?>
	<div class="content">

		<div id="tabs">
			<form method="Post" action="process_add_property.php" id="add_item">
			  	<ul>
				    <li><a href="#tabs-1">Item</a></li>
				    <li><a href="#tabs-2">Value</a></li>
				    <li><a href="#tabs-3">Multimedia</a></li>
				    <li><a href="#tabs-4">Documents</a></li>
				    <li><a href="#tabs-5">Warrenty</a></li>
				    <li><a href="#tabs-6">Repair</a></li>		    
				    <li><a href="#tabs-7">Notes</a></li>

			  	</ul>
			  	<div id="tabs-1" class="item_tab tabs_nav">

		  			<p class="tab_one_wide">
						<label for="name">Item Name:</label>
						<input id="name" type="text" name="name">    
					</p>
					<p class="tab_one_wide">
						<label for="property_name">Property:</label>
						<select name="property_name" id="property_name">
							<option value="-">-Select a Property-</option>
							<option value="property1">This needs to propagate from database</option>
							<option value="add_new_property">Add New Property</option>
						</select>
					</p>
					<p class="tab_two_wide">
						<label for="section_name">Section:</label>
						<select name="section_name" id="section_name">
							<option value="-">-Select a Section-</option>
							<option value="section1">This needs to propagate from database</option>
							<option value="add_new_section">Add New Section</option>
						</select>
					</p>
					<p class="tab_two_wide">
						<label for="room_name">Room:</label>
						<select name="room_name" id="room_name">
							<option value="-">-Select a Room-</option>
							<option value="room1">This needs to propagate from database</option>
							<option value="add_new_room">Add New Room</option>
						</select>
					</p>					
					<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="category">Category:</label>
						<select name="category" id="category">
							<option value="-">-Select a Category-</option>
							<option value="Category1">Category 1</option>
							<option value="Category2">Category 2</option>
						</select>
					</p>
					<p class="tab_two_wide">     <!--  makes two inputs on one line -->
						<label for="manufacturer">Manufacturer:</label>
						<input id="manufacturer" type="text" name="manufacturer">    
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="brand">Brand:</label>
						<input id="brand" type="text" name="brand">       
					</p>
					<p class="tab_two_wide">     <!--  makes two inputs on one line -->
						<label for="modelNumber">Model #:</label>
						<input id="modelNumber" type="text" name="modelNumber">    
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="serialNumber">Serial #:</label>
						<input id="serialNumber" type="text" name="serialNumber">       
					</p>
					<p class="tab_two_wide">     <!--  makes two inputs on one line -->
						<label for="condition">Condition:</label>
						<select name="condition" id="condition">
							<option value="-">-Select a Condition-</option>
							<option value="New">New</option>
							<option value="Excellent">Excellent</option>
							<option value="Good">Good</option>
							<option value="Poor">Poor</option>
						</select>
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="beneficiary">Beneficiary:</label>
						<input id="beneficiary" type="text" name="beneficiary">       
					</p>
					<p class="tab_one_wide_text">     
						<label for="description1">Description:</label>
						<textarea id="resizable" name="description1" ></textarea>
					</p>				
				</div>  <!-- end of tabs 1 -->

				<div id="tabs-2" class="value_tab tabs_nav">

						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="purchase_date">Purchase Date:</label>
							<input id="purchase_date" type="text" name="purchase_date">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="purchase_price">Purchase Price:</label>
							<input id="purchase_price" type="text" name="purchase_price">       
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="purchased_from">Purchased From:</label>
							<input id="purchased_from" type="text" name="purchased_from">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="paid_with">Paid for With:</label>
							<input id="paid_with" type="text" name="paid_with">       
						</p>
						<p class="two_long_wide">      <!--  makes two inputs on one line -->
							<label for="estimated_value">Estimated Current Value:</label>
							<input id="estimated_value" type="text" name="estimated_value">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="appraised_value">Appraised Value:</label>
							<input id="appraised_value" type="text" name="appraised_value">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="appraisal_date">Appraisal Date:</label>
							<input id="appraisal_date" type="text" name="appraisal_date">       
						</p>
	 					<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="appraiser">Appraiser:</label>
							<input id="appraiser" type="text" name="appraiser">       
						</p>
						<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="appraisal_attached">Appraisal Documents:</label>
							<select name="appraisal_attached" id="appraisal_attached">
								<option value="-">-Is a Copy of the Appraisal Attached in Documents?-</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
						<p class="tab_one_wide_text">     
							<label for="description2">Description:</label>
							<textarea id="resizable2" name="description2" ></textarea>
  						</p>	

				</div>   <!-- end of tabs2 -->

				<div id="tabs-3" class="multimedia_tab tabs_nav">
						<p> Add the multimedia grid </p>
				</div>   <!-- end of tabs3 -->

				<div id="tabs-4" class="documents_tab tabs_nav">
			 			<p> Add the documents grid </p>
				</div>    <!-- end of tabs4 -->

				<div id="tabs-5" class="warrenty_tab tabs_nav">
						<p class="tab_two_wide">     <!--  makes two inputs on one line -->
						<label for="warrenty_question">Warrenty:</label>
							<select name="warrenty_question" id="warrenty_question">
								<option value="-">-Is a Warrenty in Effect Now?-</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
						<p class="tab_two_long_wide">      <!--  makes two inputs on one line -->
							<label for="warrenty_expiration">Expiration Date:</label>
							<input id="warrenty_expiration" type="text" name="warrenty_expiration">       
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="warrenty_type">Type of Warrenty:</label>
							<input id="warrenty_type" type="text" name="warrenty_type">       
						</p>
						<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="warrenty_attached">Warrenty Documents:</label>
							<select name="warrenty_attached" id="warrenty_attached">
								<option value="-">-Is a Copy of the Warrenty Attached in Documents?-</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
				</div>	  <!-- end of tabs5 -->

				<div id="tabs-6" class="repair_tab tabs_nav">

						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="repaired_by">Repaired By:</label>
							<input id="repaired_by" type="text" name="repaired_by">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="repair_date">Repair Date:</label>
							<input id="repair_date" type="text" name="repair_date">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="repair_cost">Repair Cost:</label>
							<input id="repair_cost" type="text" name="repair_cost">       
						</p>
						<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="repair_attached">Repair Documents:</label>
							<select name="repair_attached" id="repair_attached">
								<option value="-">-Is a Copy of the Repair Receipt Attached in Documents?-</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</p>
						<p class="tab_one_wide_text">      <!--  makes two inputs on one line -->
							<label for="repair_description3">Repair Description:</label>
							<textarea id="resizable3" name="repair_description3"> </textarea>      
						</p>
				</div>	<!-- end of tabs6 --> 
				<div id="tabs-7" class="notes_tab tabs_nav">
					<p class="tab_one_wide_text">     
						<label for="general_notes">Notes:</label>
						<textarea id="resizable4" name="general_notes" ></textarea>
						 
					</p>	 
				</div>	  <!-- end of tabs7 -->	

					<p class="centered_button">
						<input type="submit" value="Submit"  id="add_item_submit">
					</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
</body>
</html>