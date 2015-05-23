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
		//I think this part will need rewritten
		if ($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	} //end find_user_by_id

	function find_user_by_username($username) {
		global $con;

		$safe_username = mysqli_real_escape_string($con, $username);

		$sql = "SELECT * ";
		$sql .= "FROM user ";
		$sql .= "WHERE userName = '{$safe_username}' ";
		$sql .= "LIMIT 1";

		$user_set = getRecordset($con, $sql, $safe_username);
		//I think this part will need rewritten
		if ($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	} //end find_user_by_username

	function password_encrypt($password) {
		$hash_format = "$2y$10$"; //Tells PHP to use Blowfish with a "cost" of 10
		$salt_length = 22; //Blowfish salts should be 22 characters or more

		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	} //end password_encrypt

	function generate_salt($length) {
		// Not 100% unique, not 100% random, but good enough for salt
		//MD5 returns 32 characters
		$unique_random_string = md5(uniqid(mt_rand(), true));

		//Valid characters for a salt are [a-zA-Z0-9./]
		$base64_string = base64_encode($unique_random_string);

		//But not '+' which is valid in base64 encoding
		$modified_base64_string = str_replace('+', '.', $base64_string);

		//Truncate string to the correct length
		$salt = substr($modified_base64_string, 0, $length);

		return $salt;
	} //end generate_salt

	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
		$hash = crypt($password, $existing_hash);
		if ($hash === $existing_hash) {
			return true;
		} else {
			return false;
		}
	} //end password_check

	function attempt_login($username, $password) {
		//find user, then password
		$user = find_user_by_username($username);

		if ($user) {
			//found admin, check password
			if (password_check($password, $user["password"])) {
				//password matches
				return $user;
			} else {
				//password doesn't match
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