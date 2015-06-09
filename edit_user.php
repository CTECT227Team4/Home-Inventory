<?php # admin.php
$page_title = "A-Z Home Inventory";
$page_heading = "Edit User";
$nav_context = "inventory";
$min_type = 4;
// $nav_context sets the first nav item to be the grid/tree view toggler
// This value is *case sensitive*

require_once "inc/header.inc.php";

$userID = $_GET["id"];

/* ==== Check if REMOVE PROPERTY ==== */
if (isset($_GET["action"]) && $_GET["action"] == "remove") {
	$propertyID = $_GET["property"];

	$sql = "DELETE FROM user_property WHERE userID = {$userID} AND propertyID = {$propertyID} LIMIT 1";

	$parameters = [$userID, $propertyID];

	writeRecordSet($con, $sql, $parameters);
}

/* ==== Check if POST ==== */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$id = $_GET["id"];
	$type = $_POST["usertypeID"];
	if (isset($_POST["password"])) $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

	$sql = "UPDATE user SET usertypeID={$type}, password='{$password}' WHERE ID={$id}";
	$parameters = [$type, $password, $id];

	$update_user = writeRecordSet($con, $sql, $parameters);

	if (isset($_POST["properties"])) {
		$properties = $_POST["properties"];
		foreach ($properties as $property) {
			$sql = "INSERT INTO user_property (userID, propertyID) VALUES ({$id}, {$property})";

			$parameters = [$userID, $property];

			$update_user_property = writeRecordSet($con, $sql, $parameters);
		} //end foreach
	} //endif
} //endif
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
				<th>Insurance Agent</th>
			</tr>
			<?php
				/* ==== Get/output information about this user ==== */
				$sql = "SELECT user.id, user.userName, user.firstName, user.lastName, user.email, user.usertypeID, insurance.agent FROM user LEFT JOIN insurance ON user.id=insurance.userID WHERE user.id=$userID";
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
			<tr><th colspan="6"><h3>Properties</h3></th></tr>
			<tr>
				<th>Property ID</th>
				<th>Name</th>
				<th>Address</th>
				<th>Zip Code</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
			<?php
			/*==== Echo properties this user currently has with option to remove each one ===*/
			$sql = "SELECT propertyID, name, address, zip, description FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID WHERE up.userID = ?";

				$parameters = [$userID];

				$this_user_properties = getRecordset($con,$sql,$parameters);
				foreach ($this_user_properties as $property) {
					echo "<tr>";
					foreach ($property as $property_info) {
						echo "<td>" . $property_info . "</td>";
					}
					echo "<td><a href=\"edit_user.php?id={$userID}&property={$property["propertyID"]}&action=remove\">Remove</a>";
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
					<label for="properties">Add Properties:</label>
					<br>
					<?php
					/* ==== Echo all other properties as check boxes.  Check to add user to this property. ====*/
					$sql = "SELECT propertyID, name, address, zip FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID WHERE up.userID != ?";

					$all_properties = getRecordset($con,$sql,$parameters);
					foreach ($all_properties as $property) {
							echo "<input type=\"checkbox\" name=\"properties[]\" value=\"" . $property['propertyID'] . "\">" . $property["name"];
						echo "<br>";
					}

					 ?>
				</div>
				<br>
				<div class="radioButtons">
					<label for="agents">Update Agent:</label><br>
					<?php
					/* ==== Echo all other properties as check boxes.  Check to add user to this property. ====*/
					$sql = "SELECT ID, userName, firstName, lastName, email FROM user WHERE usertypeID = 3";

					$all_agents = getRecordset($con,$sql,$parameters);
					foreach ($all_agents as $agent) {
							echo "<input type=\"radio\" name=\"agents\" value=\"" . $agent['ID'] . "\">" . $agent["firstName"] . " " . $agent["lastName"];
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