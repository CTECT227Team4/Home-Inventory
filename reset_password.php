<?php # reset_password.php
include("inc/session.php");
include("inc/functions.php");

$userName = "";

if ($_SERVER['REQUEST_METHOD'] == "GET") {

		$token = $_GET["reset"];

		$found_token = find_user_by_token($token);
		// print_r($found_token);
		$unexpired_token = check_token_expired($token);

		if ($found_token && $unexpired_token) {
			$_SESSION["user_id"] = $found_token["ID"];
			$_SESSION["userName"] = $found_token["userName"];
		} else {
			//failure
			redirect_to("login.php");
		} //endif

} //endif

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
		$user_id = $_SESSION["user_id"];
		$userName = $_SESSION["userName"];

		if ($userName == $_POST["userName"]) {

			$sql = "UPDATE user SET ";
			$sql .= "password='{$password}', ";
			$sql .="token = NULL, ";
			$sql .= "token_expire = NOW()";
			$sql .= "WHERE ID = {$user_id}";

			$parameters = [$password, $user_id];
			$changed = writeRecordSet($con, $sql, $parameters);

			unset($_SESSION["user_id"]);
			unset($_SESSION["userName"]);

			$_SESSION["message"] = "Password Reset Successful";
			redirect_to("login.php");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory Login</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     <!-- jQuery CDN -->
	<script>
		$(document).ready(function(){
			 	$('#userName').focus();   // puts the cursor in the UserName field on load
		});  // end of ready function
	</script>
</head>
<body>
	<div class="page_wrapper">
	<?php 
		include "inc/header1.inc.php";      // adds Header #2 to the page
	 ?>

	<section class="content">
		<div class="login_wrapper">
			<h1>Welcome to A-Z Home Inventory</h1>
			<h2>Password Reset:</h2>
			<form action="reset_password.php" method="post">
				<p>
					<label for="userName">Current Username:</label>
					<input id="userName" type="text" name="userName">
				</p>
				<p>
					<label for="password">New Password:</label>
					<input id="password" type="password" name="password">
				</p>
				<p>
					<label for="verify_password">Verify Password:</label>
					<input id="verify_password" type="password" name="verify_password">
				</p>
				<p>
					<input type="submit" value="Submit" class="centered_button" id="submit" name="submit">
				</p>
			</form>
		</div>
	</section>	<!-- end of content -->
	</div>   <!-- end of page wrapper -->
</body>
</html>