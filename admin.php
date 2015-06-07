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
		<h2>All Users</h2>
			<?php
				$sql = "SELECT id, userName, firstName, lastName, email, usertypeID FROM user";
				$parameters = [];
				$users = getRecordset($con,$sql,$parameters);
				// $user_set = $users->fetchAll(PDO::FETCH_ASSOC);
				foreach ($users as $key => $value) {
					echo $key . ":" . $value . "<br>";
				}
			?>


			<table>
			First Name    Last Name    E-Mail     


			</table>

		</div>
	</section>



	<section class="get_all_users">
		<h2>All Users</h2>

	FirstName	LastName	E-Mail	Type of User



	Edit







</body>
</html>