<?php # add_section.php
$page_title = "Home Inventory - Add Section"; //sets title
$page_heading = "Add Section"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content

$userid = 0;
$sectionid = 0;
if (isset($_SESSION["user_id"])) $userid = (int) $_SESSION["user_id"];
if (isset($_GET['sectionid'])) $sectionid = (int) $_GET['sectionid'];

?><script type="text/javascript" src="jquery/tipped.js"></script>    <!-- Tooltip plugin -->
	 <link rel="stylesheet" type="text/css" href="jquery/tipped.css"/> 
	   	<script>
			function packform() {
				return $('form#add_section').serializeJSON();
			}
		
	   		$(document).ready(function() {
				<?php
				echo "var userid = $userid;";
				echo "var sectionid = $sectionid;"
				?>
				
				function getaroom(url) {
					$.getJSON(url, function(obj) {
						$("#roomid").empty();
						$("#roomid").append("<option value=0>-Select a Room-</option>");
						 $.each(obj.rooms, function(key, value) {
							$("#roomid").append("<option value=" + value.ID + ">" + value.name + "</option>");
						 });
					});
				}
				
				function populate(url) {
					if (userid != 0 && sectionid != 0) {
						$.getJSON(url, function(obj) {
							$.each(obj.section, function(key, value) {
								if (key == "roomid") getaroom("main.php?F=14&propertyid=" + this.value);
								$("#" + key).val(value);
							});
						});
					}
				}

				$.getJSON("main.php?F=12", function(obj) {
					 $.each(obj.properties, function(key, value) {
						$("#propertyid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					 });
					 populate("main.php?F=17&sectionid=" + sectionid);
				});
				
				$("#propertyid").change(function () {
					getaroom("main.php?F=14&propertyid=" + this.value);
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
							<option value="0">-Select a Room-</option>
						</select>
					</p>	
					<p class="tab_one_wide_text">     
						<label for="description">Description:</label>
						<textarea id="description" name="description" ></textarea>
					</p>				
				</div>  <!-- end of tabs 1 -->

				<div id="tabs-2" class="multimedia_tab tabs_nav">
					<h3>Current Photos Attached To This Section:</h3>
					<p> Add the multimedia grid </p>
					<p><button class="add_file"><a href="#">Add File</a></button></p>
					<p><button class="scan_file"><a href="#">Scan Photo</a></button></p>
					<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under <br>Construction </p>
				</div>   <!-- end of tabs2 -->

				<div id="tabs-3" class="documents_tab tabs_nav">
			 		<h3>Current Photos Attached To This Section:</h3>
					<p> Add the multimedia grid </p>
					<p><button class="add_file"><a href="#">Add File</a></button></p>
					<p><button class="scan_file"><a href="#">Scan Photo</a></button></p>
					<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under <br>Construction </p>
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