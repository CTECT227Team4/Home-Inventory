<?php 

	session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>

	<?php 

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
		echo "Hello " . $_SESSION['user'];
		echo "<p><a href=\"logout.php\">Logout</a></p>";
	}	else {
			echo "<p><a href=\"register_user.php\">Register</a></p>";
			echo "<p><a href=\"login.php\">Login</a></p>";
	}

	 ?>







</body>
</html>