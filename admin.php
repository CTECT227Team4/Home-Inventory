<?php # admin.php
$page_title = "A-Z Home Inventory";
$page_heading = "Administration";
$nav_context = "inventory";
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*
require_once "inc/header.inc.php";
?>

<div class="message"></div>

<section class="get_all_clients">

	<div>
	<br><br><br>
		<h2>All Users</h2>

		<table>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email Address</th>
				<th>User Type</th>
			</tr>
			<?php
				$sql = "SELECT id, userName, firstName, lastName, email, usertypeID FROM user";
				$parameters = [];

				$users = getRecordset($con,$sql,$parameters);
				foreach ($users as $user) {
					echo "<tr>";
					foreach ($user as $user_info) {
						echo "<td>" . $user_info . "</td>";
					}
					echo "<td><a href=\"edit_user.php?id={$user["id"]}\">Edit</a></td>";
					echo "</tr>";
				}
			?>
		</table>

	</div>
</section>

</body>
</html>