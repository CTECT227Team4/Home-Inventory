<?php # request_pw_reset.php
include("inc/session.php");
include("inc/functions.php");

// if (logged_in()) redirect_to("logout.php");

$userName = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

		$userName = $_POST["userName"];
		$email = $_POST["email"];

			$found_user = find_user_by_userName($userName);

			if ($found_user && $found_user["email"] == $email) {
				$userID = $found_user["ID"];
				$token = password_hash($userID, PASSWORD_DEFAULT);

				$message = "http://az.rosemaryperkins.com/reset_password.php?reset=" . $token;
				$message = wordwrap($message, 70, "\r\n");

				mail($email, "A-Z Home Inventory Reset", $message);

				//two hours
				$exp_date = time()+7200;

				$sql = "UPDATE user SET token='{$token}',token_expire={$exp_date} WHERE ID={$userID}";
				$parameters = [$token, $exp_date, $userID];

				writeRecordSet($con, $sql, $parameters);

				// redirect_to("login.php");
			} else{
				//failure
				$_SESSION["message"] = "Username/email not found";
				// redirect_to("login.php");
			} //endif

} //end ($_SERVER['REQUEST_METHOD'] == "POST")
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
			<h2>Request Password Reset:</h2>
			<form action="request_pw_reset.php" method="post">
				<p>
					<label for="userName">Username:</label>
					<input id="userName" type="text" name="userName">
				</p>
				<p>
					<label for="email">Email:</label>
					<input id="email" type="email" name="email">
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