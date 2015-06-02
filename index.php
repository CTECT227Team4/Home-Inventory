<?php # login.php
require_once("/inc/session.php");
require_once("/inc/functions.php");
 
$userName = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$userName = $_POST["userName"];
		$password = $_POST["password"];

		//$required_fields = array("username", "password");
		//validate_presences($required_fields);

		//if (empty($errors)) {

			$found_user = attempt_login($userName, $password);

			if ($found_user) {
				// Success - set session variables
				$_SESSION["user_id"] = $found_user["ID"];
				$_SESSION["userName"] = $found_user["userName"];
				$_SESSION["firstName"] = $found_user["firstName"];
				$_SESSION["lastName"] = $found_user["lastName"];
				$_SESSION["logged_in"] = "logged in";
				redirect_to("landing.php");
			} else{
				//failure
				$_SESSION["message"] = "Username/password not found";
				echo "Username/password not found";
				redirect_to("login.php");
			}
		//} else {
		//	$_SESSION["errors"] = $errors;
		//	redirect_to("login.php");

} //end ($_SERVER['REQUEST_METHOD'] == "POST")
?>
<!DOCTYPE html>
<!--   This is the login page for A-Z Home Inventory.  It begins the user's session.   -->
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
			<h2 id="login_header">New User?    
				<?php 
					echo "<a id=\"register_link\" href=\"register_user.php\">Please Register</a>";
				?>
			</h2>
			<h2>or Please sign-in:</h2>
			<form action="index.php" method="post" id="login">
				<p>
					<label for="userName">Username:</label>
					<input id="userName" type="text" name="userName">
				</p>
				<p>
					<label for="password">Password:</label>
					<input id="password" type="password" name="password">
				</p>
				<p class="forgot">
					<a href="#">Forgotten your password or username?</a>
				</p>
				<p>
					<input type="submit" value="Submit" class="centered_button" id="submit" name="submit">
				</p>
			</form>
		</div>    <!-- end of login_wrapper -->
	</section>	<!-- end of content -->
	</div>   <!-- end of page wrapper -->
</body>
</html>