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
	
	function jsonspew ($con, $sql, $parameters, $name = "") {
		// Optional parameter $name, if you want to name each row a datatype.  Used for datatables grid
		$firstTime = true;
		$rs = getRecordset($con, $sql, $parameters);
		foreach ($rs as $row) {
			if ($firstTime) $firstTime = !$firstTime;
			else echo ",";
			if ($name != "") echo '{"' . $name . '":';
			echo json_encode($row, JSON_UNESCAPED_SLASHES);
			if ($name != "") echo '}';
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
				$parameter = $parameter . '';
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
		$sql .= "FROM user ";
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

		$user_set = getRecordset($con, $sql, $userName);
		if ($user = $user_set->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		} else {
			return null;
		}
	} //end find_user_by_userName

	function find_user_by_token($token) {
		global $con;

		$sql = "SELECT * ";
		$sql .= "FROM user ";
		$sql .= "WHERE token = '{$token}' ";
		$sql .= "LIMIT 1";

		$parameters = [$token];

		$user_set = getRecordset($con, $sql, $parameters);
		if ($user = $user_set->fetch(PDO::FETCH_ASSOC)) {
			return $user;
		} else {
			return null;
		}
	} //end find_user_by_token

	function check_token_expired($token) {
		global $con;

		$sql = "SELECT * ";
		$sql .= "FROM user ";
		$sql .= "WHERE token = '{$token}' ";
		$sql .= "AND TIME(token_expire) > NOW()";

		$parameters = [$token];

		$user_set = getRecordset($con, $sql, $parameters);
		if ($user = $user_set->fetch(PDO::FETCH_ASSOC)) {
			return TRUE;
		} else {
			return null;
		}
	} //end check_token_expired

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

	function check_access($userID, $min_type) {
		/* $min_type levels:
			--- 1 = user
			--- 2 = tech support
			--- 3 = agent
				--- 4 = admin*/
		global $con;
		//Use userID to check user's type
		$sql = "SELECT usertypeID FROM user WHERE ID={$userID} LIMIT 1";
		$parameters = [$userID];
		$result = getRecordset($con, $sql, $parameters);
		$row = $result->fetch();
		$type = (int) $row["usertypeID"];
		//If the user's type is lower than the type required, echo an error message and kill the page
		if ($type < $min_type) {
			echo "<h1>You are not authorized to view this page.</h1>";
			echo "<h2><a href=\"index.php\">Back to A-Z Home Inventory</a></h2>";
			die();
		}
	}

abstract class AzObject { // Abstract base class to parse JSON and put it into an inherited object class
	public function __construct($json = "") {
        if ($json != "") $this->set($json);
    }

	public function types () { // Return an array of the data types, null on abstract class
		return null;
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
		echo '{"' . get_class($this) . '":';
		jsonspew($con, $sql, array($this->id));
		echo "}";
	}
	
	public function write($con) {
		$vars = array_keys(get_object_vars($this)); // Get just the var names
		if ($this->id > 0) { // ID supplied, do an update
			$sql = 'UPDATE ' . get_class($this) . ' SET ';
			foreach ($vars AS $key) {
				$sql .= "`$key` = ?,";
			}
			$sql = rtrim($sql, ","); // Remove trailing comma
			$sql .= " WHERE ID=" . $this->id;
			$vars = array_values(get_object_vars($this)); // Get just the var values
		} else { // No ID supplied, do an insert
			array_splice($vars, 0, 1); // Delete the first element (Will be 'ID')
			$sql = 'INSERT INTO ' . get_class($this) . ' (`' . implode('`,`', $vars) . '`) VALUES (' . str_repeat("?,", count($vars)) . ")";
			$sql = str_replace("?,)", "?)", $sql); // Remove trailing ',' from str_repeat above
			$this->brand = "";
			$vars = array_values(get_object_vars($this)); // Get just the var values
			array_splice($vars, 0, 1); // Delete the first element, just a blank ID field
		}

		try {
			$unsafe = true;
			$debug = false;
			//echo sqlparms($sql, $vars);
			//echo_r($vars);
			if ($unsafe) {
				$sql = sqlparms($sql, $vars); // Completely unsafe, PHP's type handling is so completely fucked up!
				$stmt = writeRecordset($con, $sql, array());
			} else {
				$stmt = writeRecordset($con, $sql, $vars);  // Correct way to handle it if PHP's typing can be figured out.
			}
			if ($debug) {
				echo "id: " . $this->id . "\n\n";
				echo_r($this);
				echo "\n\n";
				echo_r($stmt);
				echo_r($stmt->errorCode());
				echo_r($stmt->errorInfo());
				echo $stmt->errorInfo()[2];
			}
			
			if (intval($stmt->errorInfo()[1]) == 0) return ('{"errorobj":{"error":"0","text":"' . get_class($this) . ' saved successfully."}}');
			else return ('{"errorobj":{"error":"' . $stmt->errorInfo()[1] . '","text":"' . $stmt->errorInfo()[2] .'"}}');
		} catch (Exception $e) {
			return ('{"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"}');
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
	var $id;
	var $name;
	var $address;
	var $zip;
	var $description;
	var $categoryid;
}

class Section extends AzObject { // object to hold section record
	var $id = 0;
	var $name = "";
	var $propertyid = 0;
	var $roomid = 0;
	var $description = "";
	var $notes = "";
	var $categoryid = 0;
}

class Room extends AzObject { // object to hold room record
	var $id = 0;
	var $propertyid = 0;
	var $name = "";
	var $description = "";
	var $categoryid = 0;
	
	public function values () {
		return array((int) $ID,
		(int) $propertyid,
		(string) $name,
		(string) $description,
		(int) $categoryid);
	}
}

class Item extends AzObject { // object to hold item record
	var $id;
	var $propertyid = 0;
	var $roomid = 0;
	var $sectionid = 0;
	var $name = "";
	var $categoryid = 0;
	var $manufacturer = "";
	var $brand = "";
	var $modelnumber = "";
	var $serialnumber = "";
	var $condition = "";
	var $beneficiary = "";
	var $description1 = "";
	var $purchasedate = "";
	var $purchaseprice = "";
	var $purchasedfrom = "";
	var $paymentmethod = "";
	var $warrantyexpirationdate = "";
	var $warrantytype = "";
	var $warranty_attached = 0;
	var $repaired_by = "";
	var $repair_date = "";
	var $repair_cost = "";
	var $repair_attached = 0;
	var $repair_description3 = "";
	var $general_notes = "";
	var $estimated_value = "";
	var $appraised_value = "";
	var $appraisal_date = "";
	var $appraiser = "";
	var $appraisal_attached = 0;
	var $description2 = "";
	var $warranty_question = 0;
}	 
?>