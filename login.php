<?php # login.php ?>
<?php 

	session_start();
 ?>
<!DOCTYPE html>
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
		include "includes/mysqli_connect.inc.php";   //    connects to the MySQL Database
		include "includes/header1.inc.php";      // adds Header #2 to the page
	 ?>
	<?php 
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			#  checks to see if the fields are filled out		
	   		if(!empty($_POST['firstName'] && $_POST['lastName'] && $_POST['email'] && $_POST['userName'] && $_POST['password'] )) {

				# get the variable names from the login form
				$username = $_POST['userName'];
				$password = $_POST['password'];

				# Now query the database to see if you get a match for username/password
				$sql = "SELECT * FROM user WHERE userName ='$userName' AND password=SHA1('$password')";

				# perform the query
				$result = mysqli_query($dbc,$sql);


				if (mysqli_num_rows($result) == 1) {
					# checks that username and password match
					# Now set session variables
					$_SESSION['loggedin'] = 1;
					$_SESSION['user'] = $userName;
					echo "You are now logged in!";
					#redirects to a new page that says "thanks for registering and directs them to the login page"
					  header("Location: landing.php");
					  exit;
				}	else {
						echo "<p>I'm sorry but your login info was not correct.</p>";
						echo "<p><a href=\"login.php\">Try Again Please</a></p>";
				}   // end if 
			}  // end if !empty
		}	#  INSERT THE FORM  ends processing of the form
 ?>
	<section class="content">
		<div class="login_wrapper">
			<h1>Welcome to A-Z Home Inventory</h1>
			<h2>New User?    
				<?php 
					echo "<a class=\"register_link\" href=\"register_user.php\">Please Register</a>";
				?>
			</h2>
			<h2>or Please sign-in:</h2>
			<form method="Post" action="login.php" id="login">
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