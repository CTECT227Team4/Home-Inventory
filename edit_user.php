<?php # admin.php
$page_title = "A-Z Home Inventory";
$page_heading = "Edit User";
$nav_context = "inventory";
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*

require_once "inc/header.inc.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$id = $_GET["id"];
	$type = $_POST["usertypeID"];
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

	$sql = "UPDATE user SET usertypeID={$type}, password='{$password}' WHERE ID={$id}";
	$parameters = [$type, $password, $id];

	echo $sql;

	$update_user = writeRecordSet($con, $sql, $parameters);
}
?>

<section class="get_all_clients">

	<div>
	<br><br><br>
		<h2>Edit User</h2>

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
				$id = $_GET["id"];
				$sql = "SELECT id, userName, firstName, lastName, email, usertypeID FROM user WHERE id=$id";
				$parameters = [$id];

				$users = getRecordset($con,$sql,$parameters);
				foreach ($users as $user) {
					echo "<tr>";
					foreach ($user as $user_info) {
						echo "<td>" . $user_info . "</td>";
					}
					echo "</tr>";
				}
			?>
		</table>

		<form action="edit_user.php?id=<?php echo $id; ?>" method="POST">
			<fieldset>
				<label for="usertypeID">User Type:</label><br>
				<input type="radio" name="usertypeID" value="1" checked>User<br>
				<input type="radio" name="usertypeID" value="2">Tech Support<br>
				<input type="radio" name="usertypeID" value="3">Agent<br>
				<input type="radio" name="usertypeID" value="4">Admin<br>

				<label for="password">New Password:</label><br>
				<input type="password" name="password"><br>

				<label for="verify_password">Verify New Password:</label><br>
				<input type="password" name="verify_password"><br>

				<input type="submit" name="submit" value="Update User">
			</fieldset>
		</form>

	</div>

	<a href="admin.php">Back to All Users</a>
</section>

</body>
</html>