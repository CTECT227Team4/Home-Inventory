<?php # admin.php
$page_title = "A-Z Home Inventory";
$page_heading = "Administration";
$nav_context = "inventory";
$min_type = 4;
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*
require_once "inc/header.inc.php";
?>

<div class="message"></div>

<section class="get_all_clients">

	<div class="users_table">
		<h2>All Users</h2>
		<hr class="border">
		<table id="all_users">
			<tr>
				<th>User ID</th>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email Address</th>
				<th>User Type</th>
				<th>Action</th>
			</tr>

			<?php
				$sql = "SELECT id, userName, firstName, lastName, email, usertypeID FROM user";
				$parameters = [];

				$users = getRecordset($con,$sql,$parameters);
				foreach ($users as $user) {
					echo "<tr>";
					foreach ($user as $user_info) {
						if ($user_info == null) {
							echo "<td>None</td>";
						} else {
							echo "<td>" . $user_info . "</td>";
						}
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