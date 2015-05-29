<?php # register_user.php ?>
<?php require_once("/inc/session.php"); ?>
<?php require_once("/inc/functions.php") ?>
<?php require_once("../azconfig.php"); ?>
<?php //require_once("/inc/validation_functions.php") ?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$username = $_POST["userName"];
			// create new password hash - PHP 5.5
			$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$firstName = $_POST["firstName"];
			$lastName = $_POST["lastName"];
			$email = $_POST["email"];

			//to be used with PHP validation functions if desired - see inc/validation_functions.php
			 	//$required_fields = array("username", "password", "firstName", "lastName", "email");
				//validate_presences($required_fields);
				//$fields_with_max_lengths = array("username" => 40, "password" => 50, "firstName" => 50, "lastName" => 50, "email" => 100);
				//validate_max_lengths($fields_with_max_lengths);
			//will need to check if username/email already exists


			//if (empty($errors)) {

				try {
					$sql = "INSERT INTO user (userName, password, firstName, lastName, email, usertypeID) VALUES ('{$username}', '{$password}', '{$firstName}', '{$lastName}', '{$email}', 1)";
					$stmt = $con->prepare($sql);
					$stmt->execute();
					$_SESSION["message"] = "User created.";
					redirect_to("login.php");
					echo "User <em>" . $username . "</em> created.";
				} catch(PDOException $e) {
				    echo $sql . "<br>" . $e->getMessage();
				    $_SESSION["message"] = "User creation failed.";
				    redirect_to("register_user.php");
				} //end try catch

			//} else {
			//	$_SESSION["errors"] = $errors;
			//	redirect_to("register_user.php");
			//}
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

</head>
<body>
	<?php 
		include "inc/header2.inc.php";      // adds Header #2 to the page
	 ?>

	<div class="page_wrapper">


		<div class="registration_wrapper">
			<h2>Please Enter Your Registration Information:</h2>

			<form action="register_user.php" method="post" name="register" id="registration">
				<p class="two_wide">     <!--  makes two inputs on one line -->
					<label for="firstName">First Name:</label>
					<input id="firstName" type="text" name="firstName">    
				</p>
				<p class="two_wide">      <!--  makes two inputs on one line -->
					<label for="lastName">Last Name:</label>
					<input id="lastName" type="text" name="lastName">       
				</p>
				<p class="one_wide" class="space">
					<label for="email">Email:</label>
					<input id="email" type="text" name="email">
				</p>
				<p class="one_wide" class="space">
					<label for="userName">Username:</label>
					<input id="userName" type="text" name="userName">
				</p>
				<p class="two_wide">          <!--  makes two inputs on one line -->
					<label for="password">Password:</label>
					<input id="password" type="password" name="password">
				</p>
				<p class="two_long_wide">             <!--  makes two inputs on one line, one with a long label -->
					<label for="password">Verify Password:</label>
					<input id="verify_password" type="password" name="password">
				</p>
				<p>
					<input type="submit" value="Register" class="centered_button" id="register">
				</p>
			</form>
				<p class="forgot">
					<a href="login.php">Oops, I'd like to return to the Login Page</a>       <!-- centers the text -->
				</p>
		</div>    <!--  end of registration wrapper -->
	</div>    <!-- end of page wrapper -->

</body>
</html>