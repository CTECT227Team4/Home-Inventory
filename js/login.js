<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home Inventory Login</title>
	<link rel="shortcut icon" href="images/az-icon.ico">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- The line below is for jQuery CDN.  You can find the link at the google CNS jquery / Hosted Libraries.  -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="jquery-ui-1.11.4/jquery-ui.js"></script>
	<!-- the line below is for jQuery local -->
	<!-- <script src="lib/jquery-1.11.2.min.js"></script>   -->
	<link rel="stylesheet" href="jquery-ui-1.11.4/jquery-ui.css">
	<script>
			$(document).ready(function(){

			$('#submit').prop('disabled', true);

			$('#firstname').blur(function(){
				console.log("you moved out of firstname field");
			});

			$('#registration').submit(function(evt){

				$('input[type=text]').each(function(){
					console.log($(this).val());
				}); // end of each

				console.log("form submitted");
					var userName = $('#username').val();
					console.log(firstName)
					if(userName === ""){
						$('#userName').css('border', '2px solid red');
					} 	else {

					} // end of if

					var state = $('#state :selected').val();
					if (state === '-'){
						$('#state').css('color','red').append("This field is required");
					} // end if 

					evt.preventDefault();

			});  //end of submit
		});   //end of document ready



	</script>


</head>
<body>
	<div class="page_wrapper">
	<header>
		<img 	src="images/logo.png" alt="A-Z Home Inventory Logo" sizes="60vw"
					srcset="images/logo.png 1000w"
		>
	</header>
	<section class="content">
		<div class="login_wrapper">
			<h1>Welcome to A-Z Home Inventory</h1>
			<h2>New User?  
				<?php 
					echo "<a class=\"register_link\" href=\"register_user.php\">Please Register</a>";
				?>
			</h2>
			<h2>or Please sign-in:</h2>
			<form method="Post" action="process_login.php">
				<p>
					<label for"userName">Username:</label>
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
					<input type="submit" value="Submit">
				</p>


			</form>
		</div>    <!-- end of login_wrapper -->
	</section>	<!-- end of content -->
	</div>   <!-- end of page wrapper -->
</body>
</html>