<?php 

 session_start();

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			#  checks to see if the fields are filled out		
	   		if(!empty($_POST['userName'] && $_POST['password'] )) {

				include "includes/mysqli_connect.inc.php";

				# get the variable names from the login form
				$userName = $_POST['userName'];
				$password = $_POST['password'];

				print_r($_POST);
				print $password;



				# Now query the database to see if you get a match for username/password
				$sql = "SELECT * FROM user WHERE userName ='$userName' AND password=SHA1('" . $password . "')";

				# perform the query
				$result = mysqli_query($dbc,$sql);
				echo $sql;

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
		}  //end of if posted
	 ?>