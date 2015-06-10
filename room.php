<?php # add_room.php
$roomid = 0;
if (isset($_GET['roomid'])) $roomid = (int) $_GET['roomid'];
$page_title = "Home Inventory - " . ($roomid ? "Edit" : "Add") . " Room"; //sets title
$page_heading = ($roomid ? "Edit" : "Add") . " Room"; //sets heading to appear on page
require_once "inc/header.inc.php";
?><script>
function packform() {
	var json = $('form#add_room').serializeJSON();
	//alert (json);
	$.ajax ({type: "POST", dataType: "text", url: 'main.php?F=21', 
		data: 'json=' + json,
		error: function (jqXHR, status, errormsg) {
			alert ("Error\nStatus:" + status + "\nError Msg: " + errormsg);
		},
		success: function (data, status) {
			alert("Data: " + data + "\nStatus: " + status);
		}
	})
}

$(document).ready(function() {
	var userid = <?=$userid?>;
	var roomid = <?=$roomid?>;
	
	function populate(url) { // Fill in form values
		if (userid != 0 && roomid != 0) {
			$.getJSON(url, function(obj) {
				$.each(obj.Room, function(key, value) {
					$("#" + key).val(value);
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
			populate("main.php?F=18&roomid=" + roomid);
		});
	}
	
	$.getJSON("main.php?F=16&parenttype=2", function(obj) { // Fill in categegories, 2 is room
		$("#categoryid").empty(); // Clear the list each call
		$.each(obj.categories, function(key, value) {
			$("#categoryid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
		});		
		fillproperties();
	});

	$("#propertyid").change(function () {
		if (this.value == 99999) window.open("property.php","_self");
	});
	
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
			<input id="ID" type="hidden" name="ID" value="<?=$roomid?>">
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
						<label for="propertyid">Property:</label>
						<!-- We will want the value to be the propertyID -->
						<select name="propertyid" id="propertyid">
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
				<h3>Current Photos Attached To This Room:</h3>
				<p> Add the multimedia grid </p>
				<p><a href="upload.php?ID=<?=$roomid?>&parentType=2" target="_blank"><button type="button" class="add_file">Add File</button></a></p>
				<p><a href="#"><button class="add_file" type="button">Scan Photo</button></a></p>
				<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under Construction </p>
				</div>   <!-- end of tabs2 -->

				<div id="tabs-3" class="documents_tab tabs_nav">
				<h3>Current Documents Attached To This Room:</h3>
				<p> Add the multimedia grid </p>
				<p><a href="upload.php?ID=<?=$roomid?>&parentType=2" target="_blank"><button type="button" class="add_file">Add File</button></a></p>
				<p><a href="#"><button class="add_file" type="button">Scan Photo</button></a></p>
				<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under Construction </p>
				</div>    <!-- end of tabs3 -->

				<div id="tabs-4" class="notes_tab tabs_nav">
					<p class="tab_one_wide_text">     
						<label for="notes">Notes:</label>
						<textarea id="notes" name="notes" ></textarea>					 
					</p>	 
				</div>	  <!-- end of tabs4 -->	

					<p class="centered_button">
						<button type="button" onclick="packform()" id="add_property_submit">Save</button>
					</p>		
			</form>   <!--  end of form -->
		</div>	<!-- end of tabs -->	
	</div>   <!-- end of content -->
</body>
</html>