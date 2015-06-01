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
	<?php 
		//include "includes/mysqli_connect.inc.php";   //    connects to the MySQL Database
		//include "inc/header1.inc.php";      // adds Header #2 to the page
		// if ($_SERVER['REQUEST_METHOD'] == "POST") {

		// 	#  checks to see if the fields are filled out		
	 //   		if(!empty($_POST['firstName'] && $_POST['lastName'] && $_POST['email'] && $_POST['userName'] && $_POST['password'] )) {

		// 		# get the variable names from the login form
		// 		$username = $_POST['userName'];
		// 		$password = $_POST['password'];

		// 		# Now query the database to see if you get a match for username/password
		// 		$sql = "SELECT * FROM user WHERE userName ='$userName' AND password=SHA1('$password')";

		// 		# perform the query
		// 		$result = mysqli_query($dbc,$sql);


		// 		if (mysqli_num_rows($result) == 1) {
		// 			# checks that username and password match
		// 			# Now set session variables
		// 			$_SESSION['loggedin'] = 1;
		// 			$_SESSION['user'] = $userName;
		// 			echo "You are now logged in!";
		// 			#redirects to a new page that says "thanks for registering and directs them to the login page"
		// 			  header("Location: landing.php");
		// 			  exit;
		// 		}	else {
		// 				echo "<p>I'm sorry but your login info was not correct.</p>";
		// 				echo "<p><a href=\"login.php\">Try Again Please</a></p>";
		// 		}   // end if 
		// 	}  // end if !empty
		// }	#  INSERT THE FORM  ends processing of the form
 ?>
	<section class="content">
		<div class="login_wrapper">
			<h1>Welcome to A-Z Home Inventory</h1>
			<h2>New User?    
				<a class="register_link" href="register_user.php">Please Register</a>
			</h2>
			<h2>or Please sign-in:</h2>
			<form action="login.php" method="post" id="login">
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