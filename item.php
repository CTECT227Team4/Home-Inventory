<?php # add_item.php
$itemid = 0;
if (isset($_GET['itemid'])) $itemid = (int) $_GET['itemid'];
$page_title = "Home Inventory - " . ($itemid ? "Edit" : "Add") . " Item"; //sets title
$page_heading = ($itemid ? "Edit" : "Add") . " Item"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content
?><script type="text/javascript" src="jquery/tipped.js"></script>    <!-- Tooltip plugin -->
	 <link rel="stylesheet" type="text/css" href="jquery/tipped.css"/> <!-- Tooltip plugin CSS-->
	   	<script>
			var userid = <?=$userid?>;
			var itemid = <?=$itemid?>;

			function packform() {
				return $('form#add_item').serializeJSON();
			}
		
			function getaroom(url, roomid) { // Get list of rooms for drop down
				$.getJSON(url, function(obj) {
					$("#roomid").empty(); // Clear the list each call
					$.each(obj.rooms, function(key, value) { // Go through JSON return and append all elements
						$("#roomid").append("<option value=" + value.ID + ">" + value.name + "</option>");
					});
					$("#roomid").val(roomid); // After the list is filled use the passed in roomid
				});
			}

			function getasection(url, sectionid) { // Get list of sections for drop down
				$.getJSON(url, function(obj) {
					$("#sectionid").empty(); // Clear the list each call
					$.each(obj.sections, function(key, value) { // Go through JSON return and append all elements
						$("#sectionid").append("<option value=" + value.ID + ">" + value.name + "</option>");
					});
					$("#sectionid").val(sectionid); // After the list is filled use the passed in roomid
				});
			}
			
			function populate(url) { // Fill in form values
				if (userid != 0 && sectionid != 0) {
					$.getJSON(url, function(obj) {
						var propertyid = 0; // Default to 0, cache for later
						$.each(obj.Item, function(key, value) {
							if (key == "propertyid") propertyid = value; // Cache the propertyid value for the following line
							if (key == "roomid") getaroom("main.php?F=14&propertyid=" + propertyid, value);
							if (key == "sectionid") getasection("main.php?F=13&propertyid=" + propertyid, value);
							else $("#" + key).val(value);
						});
					});
				}
			}

			function fillproperties () {
				$.getJSON("main.php?F=12", function(obj) { // Fill in properties
					$("#propertyid").empty(); // Clear the list each call
					$.each(obj.properties, function(key, value) {
						$("#propertyid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					});
					populate("main.php?F=19&itemid=" + itemid);
				});
			}

	   		$(document).ready(function() {
				$.getJSON("main.php?F=16&parenttype=4", function(obj) { // Fill in categegories, 4 is item
					$("#categoryid").empty(); // Clear the list each call
					$.each(obj.categories, function(key, value) {
						$("#categoryid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					});		
					fillproperties();
				});

				$("#propertyid").change(function () {
					if (this.value == -1) window.open("property.php","_self")
					else getaroom("main.php?F=14&propertyid=" + this.value, 0);
				});
				
				$(function() {
	 	    		$( "#tabs" ).tabs();
	 	  		});   // end jquery ui tabs plugin
				
	 	  		$(function() {
	 	    		$( "#resizable resizable2 resizable3 resizable" ).resizable({
	 	      			handles: "se"
	 	   			 }); 
	 	  		});  //  end resizable notes fields
	 	  		$('#name').focus();  // puts the cursor in the name field upon load.
	  		});  // ends ready
	   	</script>
<!-- END HEADER CONTENT -->

	<div class="content">

		<div id="tabs">
			<form method="Post" action="process_add_property.php" id="add_item">
			  	<ul>
				    <li><a href="#tabs-1">Item</a></li>
				    <li><a href="#tabs-2">Value</a></li>
				    <li><a href="#tabs-3">Multimedia</a></li>
				    <li><a href="#tabs-4">Documents</a></li>
				    <li><a href="#tabs-5">Warranty</a></li>
				    <li><a href="#tabs-6">Repair</a></li>		    
				    <li><a href="#tabs-7">Notes</a></li>

			  	</ul>
			  	<div id="tabs-1" class="item_tab tabs_nav">

		  			<p class="tab_one_wide">
						<label for="name">Item Name: <span class="simple-tooltip" title="This can be anything that is a meaningful name to you."><img src="images/info.png"></span></label> 
						<input id="name" type="text" name="name">    
					</p>
					<p class="tab_one_wide">
						<label for="propertyid">Property:  <span class="simple-tooltip" title="The property where the item is located."><img src="images/info.png"></span></label>
						<select name="propertyid" id="propertyid"></select>
					</p>
					<p class="tab_two_wide">
						<label for="sectionid">Section:  <span class="simple-tooltip" title="The section where the item is located."><img src="images/info.png"></span></label>
						<select name="sectionid" id="sectionid"></select>
					</p>
					<p class="tab_two_wide">
						<label for="roomid">Room:  <span class="simple-tooltip" title="The room where the item is located."><img src="images/info.png"></span></label>
						<select name="roomid" id="roomid"></select>
					</p>					
					<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="categoryid">Category: <span class="simple-tooltip" title="Select a category from the drop down menu that can be a helpful way to sort your items."><img src="images/info.png"></span></label></label>
						<select name="categoryid" id="categoryid"></select>
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
						<label for="modelnumber">Model #:</label>
						<input id="modelnumber" type="text" name="modelnumber">    
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="serialnumber">Serial #:</label>
						<input id="serialnumber" type="text" name="serialnumber">
					</p>
					<p class="tab_two_wide">     <!--  makes two inputs on one line -->
						<label for="condition">Condition:  </label>
						<select name="condition" id="condition">
							<option value="-">-Select a Condition-</option>
							<option value="1">New</option>
							<option value="2">Excellent</option>
							<option value="3">Good</option>
							<option value="4">Poor</option>
						</select>
					</p>
					<p class="tab_two_wide">      <!--  makes two inputs on one line -->
						<label for="beneficiary">Beneficiary:  <span class="simple-tooltip" title="A quick way to keep track of who you would like to leave this item to in your will"><img src="images/info.png"></span></label>
						<input id="beneficiary" type="text" name="beneficiary">       
					</p>
					<p class="tab_one_wide_text">     
						<label for="description1">Description:</label>
						<textarea id="description1" name="description1" ></textarea>
					</p>				
				</div>  <!-- end of tabs 1 -->

				<div id="tabs-2" class="value_tab tabs_nav">

						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="purchasedate">Purchase Date:</label>
							<input id="purchasedate" type="text" name="purchasedate">       
						</p>
						<p class="tab_two_wide">      <!--  makes two inputs on one line -->
							<label for="purchaseprice">Purchase Price:</label>
							<input id="purchaseprice" type="text" name="purchaseprice">       
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="purchasedfrom">Purchased From:  <span class="simple-tooltip" title="The store that you purchased the item from."><img src="images/info.png"></span></label>
							<input id="purchasedfrom" type="text" name="purchasedfrom">       
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="paymentmethod">Paid for With:  <span class="simple-tooltip" title="The method which you paid for the item, i.e., credit card, etc."><img src="images/info.png"></span></label>
							<input id="paymentmethod" type="text" name="paymentmethod">
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="estimated_value">Est. Replacement:  <span class="simple-tooltip" title="This is your best guess of what it would cost to replace this item."><img src="images/info.png"></span></label>
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
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</p>
						<p class="tab_one_wide_text">     
							<label for="description2">Description:</label>
							<textarea id="description2" name="description2" ></textarea>
  						</p>	

				</div>   <!-- end of tabs2 -->

				<div id="tabs-3" class="multimedia_tab tabs_nav">
					<h3>Current Photos Attached To This Item:</h3>
					<p> Add the multimedia grid </p>
					<p><button class="add_file"><a href="#">Add File</a></button></p>
					<p><button class="scan_file"><a href="#">Scan Photo</a></button></p>
					<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under <br>Construction </p>
				</div>   <!-- end of tabs3 -->

				<div id="tabs-4" class="documents_tab tabs_nav">
			 		<h3>Current Documents Attached To This Item:</h3>
					<p> Add the multimedia grid </p>
					<p><button class="add_file"><a href="#">Add File</a></button></p>
					<p><button class="scan_file"><a href="#">Scan Photo</a></button></p>
					<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under <br>Construction </p>
				</div>    <!-- end of tabs4 -->

				<div id="tabs-5" class="warranty_tab tabs_nav">
						<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="warranty_question">Warranty:</label>
							<select name="warranty_question" id="warranty_question">
								<option value="-">-Is a Warranty in Effect Now?-</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="warrantyexpirationdate">Expiration Date:</label>
							<input id="warrantyexpirationdate" type="text" name="warrantyexpirationdate">
						</p>
						<p class="tab_one_wide">      <!--  makes two inputs on one line -->
							<label for="warrantytype">Type of Warranty:  <span class="simple-tooltip" title="Examples -- lifetime, extended, etc."><img src="images/info.png"></span></label>
							<input id="warrantytype" type="text" name="warrantytype">
						</p>
						<p class="tab_one_wide">     <!--  makes two inputs on one line -->
						<label for="warranty_attached">Warranty Documents:</label>
							<select name="warranty_attached" id="warranty_attached">
								<option value="-">-Is a Copy of the Warranty Attached in Documents?-</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
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
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
						</p>
						<p class="tab_one_wide_text">      <!--  makes two inputs on one line -->
							<label for="repair_description3">Repair Description:</label>
							<textarea id="repair_description3" name="repair_description3"> </textarea>      
						</p>
				</div>	<!-- end of tabs6 --> 
				<div id="tabs-7" class="notes_tab tabs_nav">
					<p class="tab_one_wide_text">     
						<label for="general_notes">Notes:</label>
						<textarea id="general_notes" name="general_notes" ></textarea>
						 
					</p>	 
				</div>	  <!-- end of tabs7 -->	

					<p class="centered_button">
						<button type="button" onclick="alert(packform())">Save</button>
						<input type="submit" value="Submit"  id="add_item_submit">
					</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
</body>
</html>