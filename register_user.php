<?php # register_user.php ?>
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

			<form method="Post" action="process_user.php" id="registration">
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