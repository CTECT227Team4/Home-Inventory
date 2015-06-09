<?php # login.php
include("inc/session.php");
include("inc/functions.php");

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
				echo "Username/password not found";
				redirect_to("login.php");
			} //endif

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

</head>
<body>
	<div class="page_wrapper">
	<?php 
		include "inc/header1.inc.php";      // adds Header #2 to the page
	 ?>

	<section class="content">
		<div class="login_wrapper">
			<h1>Welcome to A-Z Home Inventory</h1>
			<div id="login_header"><span class="red_text"><h2>New User? </span>   
				<?php 
					echo "<a id=\"register_link\" href=\"register_user.php\"><button class=\"register\">Please Register</button></a>";
				?>
			</div>
			<h2>or Please sign-in:</h2>
			<form action="index.php" method="post" id="login">
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
					<a href="request_pw_reset.php" class="forgotten">Forgotten your password?</a>
				</p>
				<p class="centered_button">
					<input type="submit" value="Submit" id="submit" name="submit">
				</p>
			</form>
		</div>    <!-- end of login_wrapper -->
	</section>	<!-- end of content -->
	</div>   <!-- end of page wrapper -->
	<script src="js/validate_login.js"></script>
</body>
</html>