<?php 

	session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Logout</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

	<?php 

		$_SESSION['loggedin'] = "";
		$_SESSION['user'] = "";

			echo "<p><a href=\"register_user.php\">Register</a></p>";
			echo "<p><a href=\"login.php\">Login</a></p>";

	 ?>

</body>
</html>