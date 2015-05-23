<!DOCTYPE html>
<!--   This is the login page for A-Z Home Inventory.  It begins the user's session.   -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory Login</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     <!-- jQuery CDN -->


	<!-- <script>
		$(document).ready(function(){
			 	$('#submit').prop('disabled', true);

			$('#login').submit(function(evt){

					var user = $('#userName').val();
					console.log(firstName)
					if(firstName === ""){
						$('#firstname').css('border', '2px solid red');
					} 	else {
						$('#submit').prop('disabled', false);
					} // end of if

			});  //  end of submit function
		});  // end of ready function
	</script>    -->

	
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
			<form method="Post" action="process_login.php" id="login">
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
					<input type="submit" value="Submit" class="centered_button" id="submit">
				</p>


			</form>
		</div>    <!-- end of login_wrapper -->
	</section>	<!-- end of content -->
	</div>   <!-- end of page wrapper -->
</body>
</html>