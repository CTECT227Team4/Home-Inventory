<?php
	//Connect to database
	require_once('../azconfig.php');
	$con = @new PDO("$driver:host=$server;dbname=" . $db, $user, $pwd);

	function redirect_to($new_location) {
        header("Location: " . $new_location);
        exit;
    }
	
	function sqlparms($string, $data) {
		$indexed = $data == array_values($data);
		foreach($data as $k=>$v) {
			if(is_string($v)) $v = "'$v'";
			if($indexed) $string = preg_replace('/\?/',$v,$string,1);
			else $string = str_replace(":$k",$v,$string);
		}
		return $string;
	}
	
	function jsonspew ($con, $sql, $parameters) {
		$firstTime = true;
		$rs = getRecordset($con, $sql, $parameters);
		foreach ($rs as $row) {
			if ($firstTime) $firstTime = !$firstTime;
			else echo ",";
			print json_encode($row, JSON_UNESCAPED_SLASHES);
		}
	}

	function echo_r($data) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

    function getRecordset($con, $sql, $parameters) {
    	try {
    		$paramcount = 1;
    		$stmt = $con->prepare($sql);

    		// $parameters is passed in as an array, go through it and add them all
    		foreach ($parameters as $parameter) { 
    			$stmt->bindParam($paramcount++, $parameter);
    		}

			$stmt->setFetchMode (PDO::FETCH_ASSOC); // This should default the fetch to return name->value that can be output directly to JSON easier
			//echo sqlparms($sql, array_values($parameters));
    		$stmt->execute();
    		return $stmt;
    	} catch (Exception $e) { // Echo the message in JSON and exit
    		echo '"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"';
    		exit;
    	}
    } //end getRecordset

    
    function writeRecordset($con, $sql, $parameters) {
    	try {
    		$paramcount = 1;
			//echo sqlparms($sql, array_values($parameters));
    		// $parameters is passed in as an array, go through it and add them all
			$stmt = $con->prepare($sql);
			foreach ($parameters as $parameter) {
    			$stmt->bindParam($paramcount++, $parameter);
    		}
    		$stmt->execute();
			//print_r($con->errorInfo());
    		return $stmt;
    	} catch (Exception $e) { // Echo the message in JSON and exit
    		echo '"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"';
    		exit;
    	}
    } //end writeRecordset

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

		$sql = "SELECT * ";
		$sql .= "FROM user ";
		$sql .= "WHERE userName = '{$userName}' ";
		$sql .= "LIMIT 1";

		$parameters = [$userName];
		$user_set = getRecordset($con, $sql, $parameters);
		if ($user = $user_set->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		} else {
			return null;
		}
	} //end find_user_by_userName

	function attempt_login($userName, $password) {
		//find user, then password
		$user = find_user_by_userName($userName);
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
		return isset($_SESSION['user_id']);
		//check
	} //logged_in

	function confirm_logged_in() {
		if(!logged_in()) {
	// 		redirect_to("login.php");
		}
	 }

abstract class AzObject { // Abstract base class to parse JSON and put it into an inherited object class
	public function __construct($json = "") {
        if ($json != "") $this->set($json);
    }

    public function set($json) {
		$data = json_decode($json, true);
        foreach ($data AS $key=>$value) {
            $this->{$key} = $value;
        }
    }
	
	public function delete($con) {
		$sql = "DELETE FROM " . get_class($this) . " WHERE ID = ?";
		try {
			writeRecordset($con, $sql, array($this->ID));
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
	
	public function getjson($con) {
		$vars = array_keys(get_object_vars($this)); // Get just the var names
		$sql = strtolower("SELECT `" . implode('`,`', $vars) . "` FROM " . get_class($this) . " WHERE ID = ?");
		jsonspew($con, $sql, array($this->ID));
	}
	
	public function write($con) {
		$vars = array_keys(get_object_vars($this)); // Get just the var names
		if ($this->ID) { // ID supplied, do an update
			$sql = 'UPDATE ' . get_class($this) . ' SET ';
			foreach ($vars AS $key) {
				$sql .= "`$key` = ?,";
			}
			$sql = rtrim($sql, ","); // Remove trailing comma
			$sql .= " WHERE ID=" . $this->ID;
			$vars = array_values(get_object_vars($this)); // Get just the var values
		} else { // No ID supplied, do an insert
			array_splice($vars, 0, 1); // Delete the first element (Will be 'ID')
			$sql = 'INSERT INTO ' . get_class($this) . ' (`' . implode('`,`', $vars) . '`) VALUES (' . str_repeat("?,", count($vars)) . ")";
			$sql = str_replace("?,)", "?)", $sql); // Remove trailing ',' from str_repeat above
			$vars = array_values(get_object_vars($this)); // Get just the var values
			array_splice($vars, 0, 1); // Delete the first element, just a blank ID field
		}

		try {
			writeRecordset($con, $sql, $vars);
		} catch (Exception $e) {
			echo "Failed: " . $e->getMessage();
		}
	}
}

class Property extends AzObject { // object to hold property record
// Just a placeholder.  Won't work yet, until it handles writing to the user_property table as well
/* All the vars from the form
	var $name
	var $address
	var $address2
	var $zip
	var $county
	var $city
	var $state
	var $year_built
	var $year_purchased
	var $price
	var $description
	var $property_taxID
	var $gis_url
	var $general_notes
*/
	// All the vars from the DB
	var $ID;
	var $name;
	var $address;
	var $zip;
	var $description;
	var $categoryID;
}

class Section extends AzObject { // object to hold section record
	var $ID;
	var $name;
	var $propertyID;
	var $roomID;
	var $description;
	var $notes;
	var $categoryID;  // In the database, not on the form, don't recall what it's for
}

class Room extends AzObject { // object to hold room record
	var $ID;
	var $propertyID;
	var $name;
	var $description;
	var $categoryID;
}

class Item extends AzObject { // object to hold item record
	var $ID;
	var $propertyID;
	var $roomID;
	var $sectionID;
	var $name;
	var $categoryID;
	var $description;
	var $manufacturer;
	var $brand;
	var $modelNumber;
	var $serialNumber;
	var $condition;
	var $beneficiary;
	var $purchaseDate;
	var $purchasePrice;
	var $purchasedFrom;
	var $paymentMethod;
	var $warrantyExpirationDate;
	var $warrantyType;
}	 
?>