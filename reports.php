<?php # add_property.php ?>
<?php $page_title = "Home Inventory - Reports"; //sets title
$page_heading = "Reports"; //sets heading to appear on page
require_once "inc/header.inc.php"; //starts session, includes general functions, populates header content
?>

<!-- END HEADER CONTENT -->
	<div class="report_content">
		<h3>Reports Available</h3>
		<ul>
			<li><a href="print1.php">Inventory By Property</a></li>
				<p>
					
				</p>
			<li><a href="print2.php">Inventory By Category</a></li>		
			<li><a href="print3.php">Inventory By Room</a></li>	
			<li><a href="print4.php">Beneficiary Designations</a></li>
		</ul>

		<h3>User Created Reports</h3>
		<ul>
			<li><span><img src="images/under-construction.png" alt="under construction icon"></span> Under Construction </li>
		</ul>
	</div>   <!-- end of report_content -->
</body>
</html>