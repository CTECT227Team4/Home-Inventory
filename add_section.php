<?php # add_section.php
$page_title = "Home Inventory - Add Section"; //sets title
$page_heading = "Add Section"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content
?><script type="text/javascript" src="jquery/tipped.js"></script>    <!-- Tooltip plugin -->
	 <link rel="stylesheet" type="text/css" href="jquery/tipped.css"/> 
	   	<script>
	   		$(document).ready(function() {
	 	  		$(function() {
	 	    		$( "#tabs" ).tabs();
	 	  		});
	 	  		$(function() {
	 	    		$( "#resizable resizable2 resizable3 resizable" ).resizable({
	 	      			handles: "se"
	 	   			 });
	 	  		});
	  		});
	   	</script>
<!-- END HEADER CONTENT -->

	<div class="content">

		<div id="tabs">
			<form method="Post" action="main.php?F=9" id="add_room">
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
						<label for="property_name">Property:</label>
						<select name="property_name" id="property_name">
							<option value="-">-Select a Property-</option>
							<option value="property1">This needs to propagate from database</option>
							<option value="add_new_property">Add New Property</option>
						</select>
					</p>
					<p class="tab_one_wide">
						<label for="room_name">Room:</label>
						<select name="room_name" id="room_name">
							<option value="-">-Select a Room-</option>
							<option value="room1">This needs to propagate from database</option>
							<option value="add_new_room">Add New Room</option>
						</select>
					</p>	
					<p class="tab_one_wide_text">     
						<label for="description1">Description:</label>
						<textarea id="resizable" name="description1" ></textarea>
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
						<label for="general_notes">Notes:</label>
						<textarea id="resizable2" name="general_notes" ></textarea>					 
					</p>	 
				</div>	  <!-- end of tabs4 -->	

					<p class="centered_button">
						<input type="submit" value="Submit"  id="add_item_submit">
					</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
</body>
</html>