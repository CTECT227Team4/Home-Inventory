<?php # add_room.php
$page_title = "Home Inventory - Add Room"; //sets title
$page_heading = "Add Room"; //sets heading to appear on page
require_once "inc/header.inc.php";

$roomid = 0;
if (isset($_GET['roomid'])) $sectionid = (int) $_GET['roomid'];

?><script>
function packform() {
	return $('form#add_room').serializeJSON();
}

$(document).ready(function() {
	$( "#tabs" ).tabs();
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
			<form method="Post" action="main.php?F=8" id="add_room">
			  	<ul>
				    <li><a href="#tabs-1">Room</a></li>
				    <li><a href="#tabs-2">Multimedia</a></li>
				    <li><a href="#tabs-3">Documents</a></li>
				    <li><a href="#tabs-4">Notes</a></li>

			  	</ul>
			  	<div id="tabs-1" class="room_tab tabs_nav">

		  			<p class="tab_one_wide">
						<label for="name">Room Name:</label>
						<input id="name" type="text" name="name">    
					</p>
					<p class="tab_one_wide">
						<label for="property_name">Property:</label>
						<!-- We will want the value to be the propertyID -->
						<select name="property_name" id="property_name">
							<option value="-">-Select a Property-</option>
							<option value="property1">This needs to propagate from database</option>
							<option value="add_new_property">Add New Property</option>
						</select>
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
						<button type="button" onclick="alert(packform())">Save</button>
						<input type="submit" value="Submit"  id="add_item_submit">
					</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
</body>
</html>