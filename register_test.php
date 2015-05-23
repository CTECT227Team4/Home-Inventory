<?php require_once("/inc/session.php"); ?>
<?php require_once("/inc/functions.php") ?>
<?php require_once("../azconfig.php"); ?>
<?php require_once("/inc/validation_functions.php") ?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$username = $_POST["username"];
			$password = password_encrypt($_POST["password"]);
			$firstName = $_POST["firstName"];
			$lastName = $_POST["lastName"];
			$email = $_POST["email"];

			//to be used with validation functions
			 	$required_fields = array("username", "password", "firstName", "lastName", "email");
				validate_presences($required_fields);
				$fields_with_max_lengths = array("username" => 40, "password" => 50, "firstName" => 50, "lastName" => 50, "email" => 100);
				validate_max_lengths($fields_with_max_lengths);

			if (empty($errors)) {

				try {
					$sql = "INSERT INTO user (userName, password, firstName, lastName, email, usertypeID) VALUES ('{$username}', '{$password}', '{$firstName}', '{$lastName}', '{$email}', 1)";
					$stmt = $con->prepare($sql);
					$stmt->execute();
					$_SESSION["message"] = "User created.";
					redirect_to("register_test.php");
					echo "User <em>" . $username . "</em> created.";
				} catch(PDOException $e) {
				    echo $sql . "<br>" . $e->getMessage();
				    $_SESSION["message"] = "User creation failed.";
				    redirect_to("register_test.php");
				} //end try catch

			} else {
				$_SESSION["errors"] = $errors;
				redirect_to("register_test.php");
			}
	} //end if ($_SERVER['REQUEST_METHOD'] == "POST")

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>A-Z Inventory - Register</title>
 	<!-- <link href="css/style.css" rel="stylesheet"> -->
 </head>
 <body>
 	<header>
 		<h1>Registration Functions</h1>
 	</header> <!-- End Header -->

<div id="page">

<?php 
	echo message();
	$errors = errors();
	echo form_errors($errors); 
 ?>

<h2>Create User</h2>

	<form action="register_test.php" method="post" name="register">
		<label for="username">Username: </label>
		<input type="text" name="username" id="username" />
		<br />

		<label for="password">Password: </label>
		<input type="password" name="password" id="password" />

		<br />

		<label for="firstName">First Name: </label>
		<input type="text" name="firstName" id="firstName" />
		<br />

		<label for="lastName">Last Name: </label>
		<input type="text" name="lastName" id="lastName" />
		<br />

		<label for="email">Email: </label>
		<input type="text" name="email" id="email" />
		<br />

		<input type="submit" name="submit" value="Submit" />
	</form>

	<a href="register_test.php">Cancel</a>

</div>

</body>
</html>