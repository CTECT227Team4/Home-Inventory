<?php # add_property.php 
$propertyid = 0;
if (isset($_GET['propertyid'])) $propertyid = (int) $_GET['propertyid'];
$page_title = "Home Inventory - " . ($propertyid ? "Edit" : "Add") . " Property"; //sets title
$page_heading = ($propertyid ? "Edit" : "Add") . " Property"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content
?>
	   	<script>
			var userid = <?=$userid?>;
			var propertyid = <?=$propertyid?>;
				
			function packform() {
				$("#json").val("");
				
				var json = "{";
				json += '"id":"' + $("#id").val() + '",';
				json += '"name":"' + $("#name").val() + '",';
				json += '"address":"' + $("#address").val() + '",';
				json += '"zip":"' + $("#zip").val() + '",';
				json += '"description":"' + $("#description").val() + '",';
				json += '"categoryid":"' + $("#categoryid").val() + '"';
				json += "}";
				//var json = $('form#add_property').serializeJSON();
				//json = json.replace('"json":"",',''); // Stupid hack to pass JSON in, I'm stashing it into the hidden "json" input and then removing it from the serialize JSON so it all works
				
				
				$("#json").val(json);
				if ($("#id").val() > 0) { // Property ID defined, use AJAX call
				//alert (json);
					$.ajax ({type: "POST", dataType: "text", url: 'main.php?F=23', 
						data: 'json=' + json,
						error: function (jqXHR, status, errormsg) {
							alert ("Error\nStatus:" + status + "\nError Msg: " + errormsg);
						},
						success: function (data, status) {
							obj = JSON.parse(data);
							if (obj.errorobj.error == 0) alert(obj.errorobj.text);
							else alert(obj.errorobj.error + ' - ' + obj.errorobj.text);
						}
					})
				} else $("#add_property").submit(); // Otherwise, submit the form
			}
			
			function getazip(zipcode) {
				if (zipcode > 0) {
					$.getJSON("main.php?F=15&zipcode=" + zipcode, function(obj) { // Fill in zip code
						$("#county").val(obj.zipcode.county);
						$("#city").val(obj.zipcode.city);
						$("#state").val(obj.zipcode.state);
					});
				}
			}

			function populate(url) { // Fill in form values
				if (userid != 0 && propertyid != 0) {
					$.getJSON(url, function(obj) {
						$.each(obj.Property, function(key, value) {
							if (key == "zip") getazip(value);
							$("#" + key).val(value);
						});
					});
				}
			}
			
			function uploadpics() {
				var newWindow = window.open('upload.php?ID=' + propertyid + '&parentType=1', 'name', 'height=500,width=600')			
			}
			
			function getpics () {
				$.ajax({
					type: "GET",
					url: "main.php?F=29&propertyid=" + propertyid,
					dataType: 'html',
					success: function(data){
						$("#photos").html(data);
					}
				}).fail(function() {
					alert("Error getting pics.");
				});
			}
			
	   		$(document).ready(function() {
				$("#zip").blur(function() {
					getazip(this.value);
				});
				
				getpics();
				
	 	  		$.getJSON("main.php?F=16&parenttype=1", function(obj) { // Fill in categegories, 1 is property
					$("#categoryid").empty(); // Clear the list each call
					$.each(obj.categories, function(key, value) {
						$("#categoryid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					});		
					populate("main.php?F=20&propertyid=" + propertyid);
				});
				
				$(function() {
	 	    		$( "#tabs" ).tabs();
	 	  		});   // end jquery ui tabs plugin
				
	 	  		$(function() {
	 	    		$( "#resizable resizable2 resizable3 resizable" ).resizable({
	 	      			handles: "se"
	 	   			 });
	 	  		});  //  end resizable notes fields
	  		});
	   	</script>
<!-- END HEADER CONTENT -->
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
			<form method="Post" action="main.php?F=7" id="add_property">
			<input type="hidden" id="id" name="id" value="<?=$propertyid?>">
			<input type="hidden" id="json" name="json" value="">
				<p class="tab_one_wide">
					<label for="name">Property Name:  <span class="simple-tooltip" title="This can be anything that is a meaningful name to you."><img src="images/info.png"></span></label>
					<input id="name" type="text" name="name">
				</p>
				<p class="tab_one_wide" class="space">
					<label for="address">Property Address:</label>
					<input id="address" type="text" name="address">
				</p>
				<p class="tab_one_wide" class="space">
					<label for="address2">Additional Address:</label>
					<input id="address2" type="text" name="address2">
				</p>
				<p class="tab_two_wide">     <!--  makes two inputs on one line -->
					<label for="zip">Zip Code:  <span class="simple-tooltip" title="The City and State will propagate from the zipcode."><img src="images/info.png"></span></label>
					<input id="zip" type="text" name="zip">    
				</p>
				<p class="tab_two_long_wide">      <!--  makes two inputs on one line -->
					<label for="county">Property County:  <span class="simple-tooltip" title="This can be helpful when gathering property tax information."><img src="images/info.png"></span></label>
					<input id="county" type="text" name="county">       
				</p>
				<p class="tab_two_wide">     <!--  makes two inputs on one line -->
					<label for="city">City:</label>
					<input id="city" type="text" name="city">    
				</p>
				<p class="tab_two_wide">      <!--  makes two inputs on one line -->
					<label for="state">State:</label>
					<input id="state" type="text" name="state">       
				</p>
				<p class="tab_one_wide">
					<label for="categoryid">Category:</label>
					<select name="categoryid" id="categoryid"></select>
				</p>
				<p class="tab_one_wide short">      <!--  makes two inputs on one line -->
					<label for="year_built">Year Built:</label>
					<input id="year_built" type="text" name="year_built">       
				</p>
				<p class="tab_two_wide">      <!--  makes two inputs on one line -->
					<label for="year_purchased">Year Purchased:</label>
					<input id="year_purchased" type="text" name="year_purchased">       
				</p>
				<p class="tab_two_long_wide">      <!--  makes two inputs on one line -->
					<label for="price">Purchase Price:</label>
					<input id="price" type="text" name="price">       
				</p>
				<p class="tab_one_wide_text">     
					<label for="description">Description:</label>
					<textarea id="description" class="wide_textarea" name="description" rows="5" cols="80"></textarea>   
				</p>				
		</div>    <!-- end tab 1 -->

		<div id="tabs-2" class="taxes_tab tabs_nav">
				<p class="tab_one_xwide">     
					<label for="property_taxID">Property Tax ID No.:  <span class="simple-tooltip" title="???"><img src="images/info.png"></span></label>
					<input id="property_taxID" type="text" name="property_taxID">    
				</p>
				<p class="tab_one_xwide">
					<label for="gis_url">Prop. Tax GIS URL:  <span class="simple-tooltip" title="???"><img src="images/info.png"></span></label>
					<input id="gis_url" type="text" name="gis_url">
				</p>
		</div>     <!-- end tab 2 -->

		<div id="tabs-3" class="multimedia_tab tabs_nav">
				<h3>Current Photos Attached To This Property:</h3>
				<p><div id="photos"></div></p>
				<p><a href="upload.php?ID=<?=$propertyid?>&parentType=1" target="_blank"><button type="button" class="add_file">Add File</button></a></p>
				<p><button class="scan_file"><a href="#">Scan Photo</a></button></p>
				<p><button class="scan_file" type="button"><a href="#">Scan Photo</a></button></p>
				<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under Construction </p>
		</div>    <!-- end tab 3 -->

		<div id="tabs-4" class="documents_tab tabs_nav">
				<h3>Current Documents Attached To This Property:</h3>
				<p> Add the multimedia grid </p>
				<p><button type="button" class="add_file" onclick="uploadpics">Add File</button></p>
				<p><button class="scan_file"><a href="#">Scan Photo</a></button></p>
				<p><button class="scan_file" type="button"><a href="#">Scan Photo</a></button></p>
				<p class="scan_under_construction"><img src="images/under-construction.png" alt="under construction icon"> Under Construction </p> 
		</div>     <!-- end tab 4 -->

		<div id="tabs-5" class="notes_tab tabs_nav">
				<p class="tab_one_wide_text">     
					<label for="general_notes">Notes:</label>
					<textarea id="resizable_general_notes" class="wide_textarea" name="general_notes" rows="10" cols="80"></textarea>    
				</p>	 
		</div>		<!-- end tab 5 -->
		
				<p class="centered_button">
					<button type="button" onclick="packform()" id="add_property_submit">Save</button>
				</p>
		</form>    <!-- end of form -->		
	</div>   <!-- end of tabs -->
</body>
</html>