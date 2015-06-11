<?php # add_property.php ?>
<?php $page_title = "Home Inventory - Reports"; //sets title
$page_heading = "Reports"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content

?>
<script>
	var userid = <?=$userid?>;
	var itemid = <?=$itemid?>;

			function fillproperties () {
				$.getJSON("main.php?F=12", function(obj) { // Fill in properties
					$("#propertyid").empty(); // Clear the list each call
					$.each(obj.properties, function(key, value) {
						$("#propertyid").append("<option value=" + value.ID + ">" + value.name  + "</option>");
					});
					populate("main.php?F=19&itemid=" + itemid);
				});
			}

	$(document).ready(function(){
		$('#full_by_property_submit').click (
			var propertyChoice=$(#propertyid).val();
			$_SESSION["message"] = "New User was successfully created."; // inserts into the login heading
					redirect_to("login.php");


	});


</script>
<!-- END HEADER CONTENT -->
	<div class="report_content">
		<h3>Reports Available</h3>
			<p class="report_name">Full Inventory by Property</p>
			<form method="Post" action="reports.php" id="property_reports">
				<p class="report_form_dropdown">
					<label for="propertyid">Please Choose a Property:  <span class="simple-tooltip" title="The property whose inventory you would like to print."><img src="images/info.png"></span></label>
					<select name="propertyid" id="propertyid"></select>
				</p>	
				<p class="centered_button">
					<input type="submit" value="Generate Report" id="full_by_property_submit" name="submit">
				</p>
				<?php 

				if ($_SERVER['REQUEST_METHOD'] == "POST") {
					#checks to see if the fields are filled out		
			   		if($_POST['property_id'] !== 'Please Choose a Property:') {
			   				#then assigns the property id into the session heading and redirets to the print# page.
							$property_chosen = $_POST['property_id'];
							$_SESSION["message"] = $property_chosen;
								redirect_to("print1.php");
					}
				}
				?>


			</form>

				<p class="report_name">	
					<a href="print1.php">Inventory By Property</a>
				</p>
				<p class="report_name">
					<a href="print2.php">Inventory By Category</a>
				</p>
				<p class="report_name">
					<a href="print3.php">Inventory By Room</a>
				</p>
				<p class="tab_one_wide">
					<label for="propertyid">Property:  <span class="simple-tooltip" title="The property that as the rooms you would like to print."><img src="images/info.png"></span></label>
					<select name="propertyid" id="propertyid"></select>
				</p>	




			<li><a href="print4.php">Beneficiary Designations</a></li>

	</form>

		<h3>User Created Reports</h3>
		<ul>
			<li><span><img src="images/under-construction.png" alt="under construction icon"></span> Under Construction </li>
		</ul>
	</div>   <!-- end of report_content -->
</body>
</html>