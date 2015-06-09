<?php # register_user.php ?>
<?php require_once("inc/session.php"); ?>
<?php require_once("inc/functions.php") ?>
<?php require_once("../azconfig.php"); ?>

<?php
	if (logged_in()) redirect_to("landing.php");
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$username = $_POST["userName"];
			// create new password hash - PHP 5.5
			$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$firstName = $_POST["firstName"];
			$lastName = $_POST["lastName"];
			$email = $_POST["email"];

				try {
					$sql = "INSERT INTO user (userName, password, firstName, lastName, email, usertypeID) VALUES ('{$username}', '{$password}', '{$firstName}', '{$lastName}', '{$email}', 1)";
					$stmt = $con->prepare($sql);
					$stmt->execute();
					$_SESSION["message"] = "New User was successfully created."; // inserts into the login heading
					redirect_to("login.php");
					echo "User <em>" . $username . "</em> created.";
				} catch(PDOException $e) {
				    echo $sql . "<br>" . $e->getMessage();
				    $_SESSION["message"] = "User creation failed.";

				    redirect_to("register_user.php");
				} //end try catch


	} //end if ($_SERVER['REQUEST_METHOD'] == "POST")

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory Register A User</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     <!-- jQuery CDN -->
	<script src="js/validate_registration.js"></script>

</head>
<body>
	<?php 
		include "inc/header2.inc.php";      // adds Header #2 to the page
	 ?>

	<div class="page_wrapper">
		<div class="registration_wrapper">
			<h2>Please Enter Your Registration Information:</h2>

			<form action="register_user.php" method="post" name="register" id="registration">
				<p class="one_wide">     
					<label for="firstName">First Name:</label>
					<input id="firstName" type="text" name="firstName">    
					<label for="firstName" class="error" id="firstError">Please enter your first name.</label>
				</p>
				<p class="one_wide">      
					<label for="lastName">Last Name:</label>
					<input id="lastName" type="text" name="lastName"> 
					<label for="lastName" class="error" id="lastError">Please enter your last name.</label>      
				</p>
				<p class="one_wide">
					<label for="email">Email:</label>
					<input id="email" type="text" name="email">
					<label for="email" class="error" id="emailError">Please enter your email.</label>  
				</p>
				<p class="one_wide">
					<label for="userName">Username:</label>
					<input id="userName" type="text" name="userName">
					<label for="userName" class="error" id="userError">Please enter a Username.</label> 					
				</p>
				<p class="one_wide">          
					<label for="password">Password:  <span class="simple-tooltip" title="Please choose a password that is at least 8 characters and includes a special character."><img src="images/info.png"></span></label>
					<input id="password" type="password" name="password">
					<label for="password" class="error" id="passwordError">Please enter a Password.</label>
				</p>
				<p class="one_wide">             
					<label for="verifyPassword">Verify Password:  <span class="simple-tooltip" title="Please verify your password by typing it again."><img src="images/info.png"></span></label>
					<input id="verifyPassword" type="password" name="verifyPassword">
					<label for="verifyPassword" class="error" id="verifyError">Please verify your Password.</label>
					<label for="verifyPassword" class="error" id="verifyError2">Passwords do not match.</label>
				</p>
				<p>
					<input type="submit" value="Register" class="centered_button" id="register">
				</p>
			</form>
				<p class="forgot">
					<a href="login.php"><button class="forgotten">Oops, I'd like to return to the Login Page</button></a>     <!-- centers the text -->
				</p>
		</div>    <!--  end of registration wrapper -->
	</div>    <!-- end of page wrapper -->

</body>
</html>