<?php # admin.php
$page_title = "A-Z Home Inventory";
$page_heading = "Edit User";
$nav_context = "inventory";
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*

require_once "inc/header.inc.php";

$userID = $_GET["id"];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$id = $_GET["id"];
	$type = $_POST["usertypeID"];
	$properties = $_POST["properties"];
	if (isset($_POST["password"])) $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

	$sql = "UPDATE user SET usertypeID={$type}, password='{$password}' WHERE ID={$id}";
	$parameters = [$type, $password, $id];

	$update_user = writeRecordSet($con, $sql, $parameters);

	foreach ($properties as $property) {
		$sql = "INSERT INTO user_property (userID, propertyID) VALUES ({$id}, {$property})";

		$parameters = [$userID, $property];

		$update_user_property = writeRecordSet($con, $sql, $parameters);
	echo $sql;
	}
}
?>

<section class="get_all_clients">

	<div>
	<br><br><br>
		<h2>Edit User <?php echo $userID; ?></h2>
	<div class="users_table">

		<table>
			<tr><th colspan="6"><h3>User Info</h3></th></tr>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email Address</th>
				<th>User Type</th>
			</tr>
			<?php
				$sql = "SELECT id, userName, firstName, lastName, email, usertypeID FROM user WHERE id=$userID";
				$parameters = [$userID];

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
	</div>

	<hr class="border">

	<div class="users_table">

		<table>
			<tr><th colspan="5"><h3>Properties</h3></th></tr>
			<tr>
				<th>Property ID</th>
				<th>Name</th>
				<th>Address</th>
				<th>Zip Code</th>
				<th>Description</th>
			</tr>
			<?php

			$sql = "SELECT propertyID, name, address, zip, description FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID WHERE up.userID = ?";

				$parameters = [$userID];

				$this_user_properties = getRecordset($con,$sql,$parameters);
				foreach ($this_user_properties as $property) {
					echo "<tr>";
					foreach ($property as $property_info) {
						echo "<td>" . $property_info . "</td>";
					}
					echo "</tr>";
				}


			 ?>
		</table>
		</div>

		<form action="edit_user.php?id=<?php echo $userID; ?>" method="POST">
			<!-- <fieldset> -->

				<label for="usertypeID">User Type:</label><br>
				<input type="radio" name="usertypeID" value="1" checked>User<br>
				<input type="radio" name="usertypeID" value="2">Tech Support<br>
				<input type="radio" name="usertypeID" value="3">Agent<br>
				<input type="radio" name="usertypeID" value="4">Admin<br>

				<label for="password">New Password:</label><br>
				<input type="password" name="password"><br>

				<label for="verify_password">Verify New Password:</label><br>
				<input type="password" name="verify_password"><br>

				<div class="checkboxes">
					<br>
					<?php 

					$sql = "SELECT propertyID, name, address, zip FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID WHERE up.userID != ?";

					$all_properties = getRecordset($con,$sql,$parameters);
					foreach ($all_properties as $property) {
						// foreach ($property as $property_info) {
							echo "<input type=\"checkbox\" name=\"properties[]\" value=\"" . $property['propertyID'] . "\">" . $property["name"];

							// echo $property_info;
						// }
						echo "<br>";
					}

					 ?>
					 </div>

				<input type="submit" name="submit" value="Update User">


			<!-- </fieldset> -->
		</form>

	</div>

	<a href="admin.php">Back to All Users</a>
</section>

</body>
</html>