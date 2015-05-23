<?php # process_user.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Process User</title>
</head>
<body>

	<?php 
		include "inc/mysqli_connect.inc.php";   //    connects to the MySQL Database

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			#  checks to see if the fields are filled out		
	   		if(!empty($_POST['firstName'] && $_POST['lastName'] && $_POST['email'] && $_POST['userName'] && $_POST['password'] )) {

				#   get the variable names from the login form
				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$email = $_POST['email'];
				$userName = $_POST['userName'];
				$password = $_POST['password'];

				#   Inserts the new user into the database table   		
				$sql = "INSERT INTO user (firstName, lastName, email, userName, password, usertypeID) VALUES ('$firstName', '$lastName', '$email', '$userName', SHA1('$password'),1)";

				#   use for debugging
				#   echo $sql;

				$results = mysqli_query($dbc,$sql);
				
				echo $sql;

				#   check that the query only affected one row
				if(mysqli_affected_rows($dbc) == 1) {

					# close the db connection
					mysqli_close($dbc);

					#redirects to a new page that says "thanks for registering and directs them to the login page"
				  	header("Location: thanks_login.php");
				  	exit;
				}  	else {
					echo "<div class=\"results\"><p>Oops .... Something didn't go right.  Please try again.</p></div>";
				}   #ends did it post check	
			}	else {  
					echo "<div class=\"results\"><p>You skipped an information field.  Please try again.</p></div>";
			}   #ends 'if fields are filled out

			#generates the empty form
		}	#  INSERT THE FORM  ends processing of the form	
	 ?>
</body>
</html>