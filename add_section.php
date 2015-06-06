<?php # add_section.php
$page_title = "Home Inventory - Add Section"; //sets title
$page_heading = "Add Section"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content
?><script type="text/javascript" src="jquery/tipped.js"></script>    <!-- Tooltip plugin -->
	 <link rel="stylesheet" type="text/css" href="jquery/tipped.css"/> 
	   	<script>
			function packform() {
				return $('form#add_section').serializeJSON();
			}
		
	   		$(document).ready(function() {
				$.getJSON("main.php?F=12&userid=24",function(obj) {
					 $.each(obj.properties, function(key, value) {
						$("#propertyid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					 });
				});
				
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
			<form id="add_section"><input type="hidden" id="id" name="id">
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
							<option value="-">-Select a Room-</option>
							<option value="room1">This needs to propagate from database</option>
							<option value="add_new_room">Add New Room</option>
						</select>
					</p>	
					<p class="tab_one_wide_text">     
						<label for="description">Description:</label>
						<textarea id="resizable" name="description" ></textarea>
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
						<textarea id="resizable2" name="notes" ></textarea>					 
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