<?php # admin.php
$page_title = "A-Z Home Inventory";
$page_heading = "Administration";
$nav_context = "inventory";
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*
require_once "inc/header.inc.php";
?>

Get All Clients

<section class="get_all_clients">

	<div class="products">
		<h2>Insurance Clients of <?php Session Information ?> Who Use A-Z Home Inventory Program</h2>
			<?php  
				$q = "SELECT * FROM users WHERE 'agent' = 'session name of the agent' ORDER BY lastName ASC";
				$r = mysqli_query($dbc, $q);
			?>


			<table>
			First Name    Last Name    E-Mail     


			</table>

		</div>
	</section>
</body>
</html>