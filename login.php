<?php # login.php
require_once("/inc/session.php");
require_once("/inc/functions.php");

if (logged_in()) redirect_to("landing.php");

$userName = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$userName = $_POST["userName"];
		$password = $_POST["password"];

			$found_user = attempt_login($userName, $password);

			if ($found_user) {
				// Success - set session variables
				$_SESSION["user_id"] = $found_user["ID"];
				$_SESSION["userName"] = $found_user["userName"];
				$_SESSION["firstName"] = $found_user["firstName"];
				$_SESSION["lastName"] = $found_user["lastName"];
				$_SESSION["logged_in"] = TRUE;
				redirect_to("landing.php");
			} else{
				//failure
				$_SESSION["message"] = "Username/password not found";
				redirect_to("login.php");
			}

} //end ($_SERVER['REQUEST_METHOD'] == "POST")
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory Login</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     <!-- jQuery CDN -->
	<script>
		$(document).ready(function(){
			$('#userName').focus();
		});  // end of ready function
	</script>   
</head>
<body>
	<div class="page_wrapper">
	<?php echo message(); ?>
	<section class="content">
		<div class="login_wrapper">
			<h1>Hi <!-- <?php echo $_SESSION["firstName"]; ?>  --> <h1>
			<h1>Welcome to A-Z Home Inventory</h1>
			<h2>Please sign-in:</h2>
			<form action="login.php" method="post" id="login">
				<p>
					<label for="userName">Username:</label>
					<input id="userName" type="text" name="userName">
					<label for="userName" class="error" id="userError">Please enter your Username.</label> 
				</p>
				<p>
					<label for="password">Password:</label>
					<input id="password" type="password" name="password">
					<label for="password" class="error" id="passwordError">Please enter your password.</label>   
				</p>
				<p class="forgot">
					<button class="forgotten"><a href="#">Forgotten your password or username?</a></button>
				</p>
				<p>
					<input type="submit" value="Submit" class="centered_button" id="submit" name="submit">
				</p>
			</form>
		</div>    <!-- end of login_wrapper -->
	</section>	<!-- end of content -->
	</div>   <!-- end of page wrapper -->
	<script src="js/validate_login.js"></script>
</body>
</html>