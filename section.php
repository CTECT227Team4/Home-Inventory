<?php # add_section.php
$sectionid = 0;
if (isset($_GET['sectionid'])) $sectionid = (int) $_GET['sectionid'];

$page_title = "Home Inventory - " . ($sectionid ? "Edit" : "Add") . " Section"; //sets title
$page_heading = ($sectionid ? "Edit" : "Add") . " Section"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content
?><script type="text/javascript" src="jquery/tipped.js"></script>    <!-- Tooltip plugin -->
	 <link rel="stylesheet" type="text/css" href="jquery/tipped.css"/> 
	   	<script>
			function packform() {
				return $('form#add_section').serializeJSON();
			}
		
	   		$(document).ready(function() {
				var userid = <?=$userid?>;
				var sectionid = <?=$sectionid?>;
				
				function getaroom(url, roomid) { // Get list of rooms for drop down
					$.getJSON(url, function(obj) {
						$("#roomid").empty(); // Clear the list each call
						$.each(obj.rooms, function(key, value) { // Go through JSON return and append all elements
							$("#roomid").append("<option value=" + value.ID + ">" + value.name + "</option>");
						});
						$("#roomid").val(roomid); // After the list is filled use the passed in roomid
					});
				}
				
				function populate(url) { // Fill in form values
					if (userid != 0 && sectionid != 0) {
						$.getJSON(url, function(obj) {
							var propertyid = 0; // Default to 0, cache for later
							$.each(obj.Section, function(key, value) {
								if (key == "propertyid") propertyid = value; // Cache the propertyid value for the following line
								if (key == "roomid") getaroom("main.php?F=14&propertyid=" + propertyid, value);
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
						populate("main.php?F=17&sectionid=" + sectionid);
					});
				}
				
				$.getJSON("main.php?F=16&parenttype=3", function(obj) { // Fill in categegories, 3 is section
					$("#categoryid").empty(); // Clear the list each call
					$.each(obj.categories, function(key, value) {
						$("#categoryid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					});		
					fillproperties();
				});
				
				$("#propertyid").change(function () {
					if (this.value == -1) window.open("property.php","_self");
					else getaroom("main.php?F=14&propertyid=" + this.value, 0);
				});

	 	  		$(function() {
	 	    		$( "#tabs" ).tabs();
	 	  		});

	 	  		$(function() {
	 	    		$( "#description notes" ).resizable({
	 	      			handles: "se"
	 	   			 });
	 	  		});
	  		});
	   	</script>
<!-- END HEADER CONTENT -->

	<div class="content">

		<div id="tabs">
			<form id="add_section"><input type="hidden" id="id" name="id" value="<?=$sectionid?>">
			  	<ul>
				    <li><a href="#tabs-1">Section</a></li>
				    <li><a href="#tabs-2">Multimedia</a></li>
				    <li><a href="#tabs-3">Documents</a></li>
				    <li><a href="#tabs-4">Notes</a></li>

			  	</ul>
			  	<div id="tabs-1" class="section_tab tabs_nav">

		  			<p class="tab_one_wide">
						<label for="name">Section Name:</label>
						<input id="name" type="text" name="name">    
					</p>
					<p class="tab_one_wide">
						<label for="propertyid">Property:</label>
						<select name="propertyid" id="propertyid">
							<option value="">-Select a Property-</option>
						</select>
					</p>
					<p class="tab_one_wide">
						<label for="roomid">Room:</label>
						<select name="roomid" id="roomid">
							<option value="0">-Select a Room-</option>
						</select>
					</p>	
					<p class="tab_one_wide">
						<label for="categoryid">Category:</label>
						<select name="categoryid" id="categoryid"></select>
					</p>
					<p class="tab_one_wide_text">     
						<label for="description">Description:</label>
						<textarea id="description" name="description" ></textarea>
					</p>				
				</div>  <!-- end of tabs 1 -->

				<div id="tabs-2" class="multimedia_tab tabs_nav">
						<p> Add the multimedia grid </p>
				</div>   <!-- end of tabs2 -->

				<div id="tabs-3" class="documents_tab tabs_nav">
			 			<p> Add the documents grid </p>
				</div>    <!-- end of tabs3 -->

				<div id="tabs-4" class="notes_tab tabs_nav">
					<p class="tab_one_wide_text">     
						<label for="notes">Notes:</label>
						<textarea id="notes" name="notes" ></textarea>					 
					</p>	 
				</div>	  <!-- end of tabs4 -->	

					<p class="centered_button">
						<button type="button" onclick="alert(packform())" id="add_property_submit">Save</button>
					</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
</body>
</html>