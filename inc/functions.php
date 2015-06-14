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
		$json = "";
		foreach ($rs as $row) {
			if ($firstTime) $firstTime = !$firstTime;
			else $json .= ",";
			$json .= json_encode($row, JSON_UNESCAPED_SLASHES);
		}
		return $json;
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
		$stmt = $con->prepare($sql); 

    	try {
    		$paramcount = 1;			
			foreach ($parameters as $parameter) { // $parameters is passed in as an array, go through it and add them all
				$parameter = $parameter . '';
				$stmt->bindParam($paramcount++, $parameter);
    		}
    		$stmt->execute();
    	} catch (Exception $e) { // Echo the message in JSON and exit
			$stmt->errorInfo()[1] = $e->getCode();
			$stmt->errorInfo()[2] = $e->getMessage();
    	}
		return $stmt;
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

function scope_wtf($that) { // Holy convoluted syntax, Batman!  This is here just to be out of scope of a class, to get just the public vars
	return get_object_vars($that);
}

abstract class AzObject { // Abstract base class to parse JSON and put it into an inherited object class
	private $types; // Private so it's only changed once in the constructor
	private $autovars;  // Generated during sql() method
	private $autotypes; // Generated during sql() method (Why this weirdness?  PHP passes arrays in function parameters oddly.  I couldn't find a way to pass 2 arrays, so this is the work around, for now.)
	
	public function __construct($json = "") {
		$this->typecheck();  // Call this once (and only once) to generate the default types (before JSON is parsed, messing up the defaults)
        if ($json != "") $this->set($json);
    }

	public function get_object_vars() { // Syntax gyration to get only public scope vars
		return scope_wtf($this);
	}

	public function getTypes() { // Public method to get the default types
		return $this->types;
	}
	
	private function typecheck () { // Get the types, private so it's not called more than once in the constructor
		$types = array();
		$vars = array_values($this->get_object_vars());
		/* Maybe set the vars to default PDO consts instead of trying to detect them?
		PDO::PARAM_BOOL (integer) // Represents a boolean data type. 
		PDO::PARAM_NULL (integer) // Represents the SQL NULL data type. 
		PDO::PARAM_INT (integer) // Represents the SQL INTEGER data type. 
		PDO::PARAM_STR (integer) // Represents the SQL CHAR, VARCHAR, or other string data type. 
		PDO::PARAM_LOB // BLOB
		// Floats are apparently problematic and need to not be specified?!?
		*/
		foreach ($vars AS $var) {
			if (is_int($var)) $types[] = PDO::PARAM_INT;  // var is an int, assign PDO int
			else $types[] = PDO::PARAM_STR; // Default to string
		}
		$this->types = $types;
	}
	
    public function set($json) {
		$data = json_decode($json, true);
        foreach ($data AS $key=>$value) {
            $this->{$key} = $value;
        }
    }
	
	public function getjson($con) {
		$vars = array_keys(scope_wtf($this)); // Get just the var names
		$sql = strtolower("SELECT `" . implode('`,`', $vars) . "` FROM " . get_class($this) . " WHERE ID = ?");
		echo '{"' . get_class($this) . '":';
		echo jsonspew($con, $sql, array($this->id));
		echo "}";
	}
	
	function write($con) {
		$debug = false;
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $con->prepare($this->sql());

		if ($debug) {
			echo_r($this->autovars);
			echo_r($this->autotypes);
		}
		
		if (count($this->autovars) != count($this->autotypes)) { // Check that parameters and types match up
			return ('{"errorobj":{"error":"911","text":"' . get_class($this) . '->: parameters count must match types count, check class definition vs table definition."}}');
		}

    	try {
    		$paramcount = 1;	
			$parameters = $this->autovars; // Get just the var names
			foreach ($parameters as $parameter) { // $parameters is passed in as an array, go through it and add them all
				$stmt->bindParam($paramcount, $parameter, $this->autotypes[$paramcount - 1]); // Bind with type
//				$stmt->bindParam($paramcount, $parameter); // Bind without type
				if ($debug) {
					if ($this->autotypes[$paramcount - 1] == PDO::PARAM_INT) echo "(INT) " . $paramcount . ":" .  $parameter . ":" . $this->autotypes[$paramcount - 1] . "<br>\n";
					if ($this->autotypes[$paramcount - 1] == PDO::PARAM_STR) echo "(STR) " . $paramcount . ":" .  $parameter . ":" . $this->autotypes[$paramcount - 1] . "<br>\n";
				} 
				$paramcount++;
    		}
			
			if ($debug) {
				echo_r(explode( " Key:", $stmt->debugDumpParams()));
				echo sqlparms($this->sql(), $parameters);
			}
			
    		$stmt->execute();
			return ('{"errorobj":{"error":"0","text":"' . get_class($this) . ' saved successfully."}}');
		} catch (Exception $e) {
			return ('{"errorobj":{"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"}}');
		}
	}
	
	public function sql() {
		$vars = array_keys($this->get_object_vars()); // Get just the var names
		array_splice($vars, 0, 1); // Delete the first var name element (Will be 'ID')
		
		if ($this->id > 0) { // ID supplied, do an update
			$sql = 'UPDATE ' . get_class($this) . ' SET ';
			foreach ($vars AS $key) {
				$sql .= "`$key` = ?,";  // The ` are in here to escape out the column names, in case there's a MySQL reserved word in the column name
			}
			$sql = rtrim($sql, ","); // Remove trailing comma
			$sql .= " WHERE ID=" . $this->id;
			$vars = array_values($this->get_object_vars()); // Get just the var values
			$types = $this->types; // Get the default var types
		} else { // No ID supplied, do an insert
			$sql = 'INSERT INTO ' . get_class($this) . ' (`' . implode('`,`', $vars) . '`) VALUES (' . str_repeat("?,", count($vars)) . ")";
			$sql = str_replace("?,)", "?)", $sql); // Remove trailing ',' from str_repeat above
		}
		$vars = array_values($this->get_object_vars()); // Get just the var values
		array_splice($vars, 0, 1); // Delete the first value element, just ID field (either blank for insert, or specified in the where on update)
		$types = $this->types;
		array_splice($types, 0, 1); // Delete the first type element, the type of the ID field
	
		$this->autovars = $vars; // Stashing these in private vars to avoid array passing weirdness in PHP
		$this->autotypes = $types;
		
		return $sql;
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
	var $id = 0;
	var $name = "";
	var $address = "";
	var $zip = 0;
	var $description = "";
	var $categoryid = 0;
}

class Section extends AzObject { // object to hold section record
	var $id = 0;
	var $propertyid = 0;
	var $roomid = 0;
	var $name = "";
	var $description = "";
	var $categoryid = 0;
	var $notes = "";
}

class Room extends AzObject { // object to hold room record
	var $id = 0;
	var $propertyid = 0;
	var $name = "";
	var $description = "";
	var $categoryid = 0;
	var $notes = "";
}

class Item extends AzObject { // object to hold item record
	var $id = 0;
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