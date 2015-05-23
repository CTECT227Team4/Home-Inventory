<?php
	//Connect to database
	require_once('../azconfig.php');
	$con = @new PDO("mysql:host=localhost;dbname=" . $db, $user, $pwd);

	function redirect_to($new_location) {
        header("Location: " . $new_location);
        exit;
    }

    function mysql_prep($string) {
    	global $con;
    	$escaped_string = mysqli_real_escape_string($con, $string);
    	return $escaped_string;
    }

    function getRecordset($con, $sql, ...$parameters) {
    	try {
    		$paramcount = 1;
    		$stmt = $con->prepare($sql);
    	
    		// $parameters is passed in as an array, go through it and add them all
    		foreach ($parameters as $parameter) { 
    			$stmt->bindParam($paramcount++, $parameter);
    		}
    		
    		$stmt->execute();
    		return $stmt;
    	} catch (Exception $e) { // Echo the message in JSON and exit
    		echo '"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"';
    		exit;
    	}
    } //end getRecordset

	function form_errors($errors) {
	    $output = "";
	    if (!empty($errors)) {
	        $output = "<div class=\"error\">";
	        $output .= "Please fix the following errors:";
	        $output .= "<ul>";
	        foreach ($errors as $key => $error) {
	            $output .= "<li>";
	            $output .= htmlentities($error);
	            $output .= "</li>";
	        }
	        $output .= "</ul>";
	        $output .= "</div>";
	    }
	    return $output;
	}

	function find_all_users() {
		global $con;

		$sql = "SELECT * ";
		$sql .= "FROM admins ";
		$sql .= "ORDER BY userName ASC";

		$user_set = getRecordset($con, $sql);
		return $user_set;
	} //end find_all_users

	function find_user_by_id($user_id) {
		global $con;

		$safe_user_id = mysqli_real_escape_string($con, $user_id);

		$sql = "SELECT * ";
		$sql .= "FROM user ";
		$sql .= "WHERE id = {$safe_user_id} ";
		$sql .= "LIMIT 1";

		$user_set = getRecordset($con, $sql, $safe_user_id);
		
		if ($user = $user_set->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		} else {
			return null;
		}

	} //end find_user_by_id

	function find_user_by_userName($userName) {
		global $con;

		//$safe_userName = mysqli_real_escape_string($con, $userName);

		$sql = "SELECT * ";
		$sql .= "FROM user ";
		// $sql .= "WHERE userName = '{$safe_userName}' ";
		$sql .= "WHERE userName = '{$userName}' ";
		$sql .= "LIMIT 1";

		// $user_set = getRecordset($con, $sql, $safe_userName);
		$user_set = getRecordset($con, $sql, $userName);
		//I think this part will need rewritten
		if ($user = $user_set->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		} else {
			return null;
		}
	} //end find_user_by_userName

	function attempt_login($userName, $password) {
		//find user, then password
		$user = find_user_by_userName($userName);
		echo "This is working";
		print_r($user);
		if ($user) {
			//found admin, check password
			if (password_verify($password, $user["password"])) {
				//password matches
				return $user;
			} else {
				//password doesn't match
				echo "bad password<br>";
				return false;
			}
		} else {
			//not found
			return false;
		}
	} //end attempt_login

	function logged_in() {
		return isset($_SESSION['admin_id']);
		//check
	} //logged_in

	function confirm_logged_in() {
		if(!logged_in()) {
	// 		redirect_to("login.php");
		}
	 } 
?>