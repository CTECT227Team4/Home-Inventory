<?php
include_once("../azconfig.php");

$jsonmsg = "";
$imageslocation = "./images/";  // The relative location to the icon images for the tree control
$webfunction = 0;
$userid = 0;
$propertyid = 0;
$sectionid = 0;
$roomid = 0;
$itemid = 0;

// This should work if you use the URL:  http://localhost/az/main.php?F=1&userid=2
// with the copy of the database I had on Saturday.

if (isset($_GET['F'])) $webfunction = $_GET['F'];
if (isset($_GET['userid'])) $userid = $_GET['userid'];
if (isset($_GET['propertyid'])) $propertyid = $_GET['propertyid'];
//<<<<<<< HEAD
if (isset($_GET['sectionid'])) $sectionid = $_GET['sectionid'];
if (isset($_GET['roomid'])) $roomid = $_GET['roomid'];
if (isset($_GET['itemid'])) $itemid = $_GET['itemid'];
//=======
if (isset($_GET['roomid'])) $roomid = $_GET['roomid'];
//>>>>>>> origin/master

header('Content-Type: application/json');
// Moved $firstTime initialization to the top
$firstTime = true;
try {
	$con = @new PDO("$driver:host=$server;dbname=" . $db, $user, $pwd);
	if ($con) {
		switch ($webfunction) {
			case 1: // GetProperties
				// I'm renaming the columns in the query to return the same name and case that the jstree control uses
				//$sql = "SELECT CONCAT('P', p.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID LEFT OUTER JOIN category c ON c.ID = p.CategoryID WHERE up.userID = ?";
				// Added in the thumbnail, if it's been uploaded
				// Currently hardcoded to the first item in the list of attachments, if available.  
				$sql = "SELECT CONCAT('P', p.id) AS id, p.name AS text, IF (a.ID != 0, CONCAT('showfile.php?ID=', a.ID, CONCAT('&parentType=1&item=',a.item,'&thumb=1')), CONCAT ('$imageslocation', icon)) AS icon FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID LEFT OUTER JOIN category c ON c.ID = p.CategoryID LEFT OUTER JOIN (SELECT ID, item FROM attachment WHERE parentType = 1 AND mimetype LIKE 'image%' ORDER BY item LIMIT 1) a ON a.ID = p.id WHERE up.userID = ?";
		
				// To use this function just pass in any parameters in the order you need them in the SQL statement above
				$rs = getRecordset($con, $sql, $userid);  // In this case it's just $userid
				
				// The jstree control requires unique ID's for each node.  Not exactly sure how we want to handle this.
				// For now I put "U" for the user node, "P" for property, so we'll have "S"=section, "R"=room, "I"=item
				echo '[{"id":"U' . $userid . '","text": "The Addams Family Properties","children":"true","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":';
				echo "["; // The recordset is being returned as an array, so start the array
				
				foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime; // Don't echo a comma on the first line, only when added a new one
					else echo ",";
					print json_encode($row, JSON_UNESCAPED_SLASHES);
					// If we want to load the children (rooms) here, we could make a second call here
					// Maybe an option to pass in?  Or just load them with a separate call to GetRooms?
				}
				echo "]"; // End the array
				echo "}]"; // End the whole tree
				break;
			case 2: // GetRooms
				// locahost/az/main.php?F=2&propertyid=1
				$sql = "SELECT CONCAT('R', r.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM room r LEFT OUTER JOIN category c ON c.ID = r.CategoryID WHERE r.propertyID = ?";

				$rs = getRecordset($con, $sql, $propertyid);

				echo '[{"id":"P' . $propertyid . '","text": "Main House","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":';
				echo "["; // The recordset is being returned as an array, so start the array
				
				foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime; // Don't echo a comma on the first line, only when added a new one
					else echo ",";

					print json_encode($row, JSON_UNESCAPED_SLASHES);
				}
				echo "]"; // End the array
				echo "}]"; // End the whole tree
				break;

			case 3: // GetSections
				// locahost/az/main.php?F=3&propertyid=1 OR localhost/az/main.php?F=3&roomid=2

				//check whether to select sections in a room or a property
				if (isset($roomid)) {
					$sql = "SELECT CONCAT ('S', s.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM section s LEFT OUTER JOIN category c ON c.ID = s.CategoryID WHERE s.roomID = ?";
					//creates variable for correct node (R) to be echoed with result
					$parent = "\"id\":\"R" . $roomid;
				} else {
					$sql = "SELECT CONCAT('S', s.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM section s LEFT OUTER JOIN category c ON c.ID = s.CategoryID WHERE s.propertyID = ?";
					//creates variable for correct node (P) to be echoed with result
					$parent = "\"id\":\"P" . $propertyid;
				}

				//if $roomid is set, get records for $roomid, otherwise get records for $propertyid
				isset($roomid) ? $rs = getRecordset($con, $sql, $roomid) : $rs = getRecordset($con, $sql, $propertyid);

				echo '[{' . $parent . '",text": "Main House","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":';
				echo "["; // The recordset is being returned as an array, so start the array
				
				foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime; // Don't echo a comma on the first line, only when added a new one
					else echo ",";

					print json_encode($row, JSON_UNESCAPED_SLASHES);
				}
				echo "]"; // End the array
				echo "}]"; // End the whole tree
				break;
			case 4: // GetItems
				$sql = "SELECT CONCAT('P', p.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID LEFT OUTER JOIN category c ON c.ID = p.CategoryID WHERE up.userID = ?";
				$rs = getRecordset($con, $sql, $userid);
				
				echo '[{"id":"U' . $userid . '","text": "The Addams Family Properties","children":"true","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":';
				echo "["; // The recordset is being returned as an array, so start the array
				
				// Moved $firstTime initialization to the top
				//$firstTime = true;
				
				while ($row = $rs->fetch()) {
				//foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime; // Don't echo a comma on the first line, only when added a new one
					else echo ",";

					print json_encode($row, JSON_UNESCAPED_SLASHES);
					// If we want to load the children (rooms) here, we could make a second call here
					// Maybe an option to pass in?  Or just load them with a separate call to GetRooms?
				}
				echo "]"; // End the array
				echo "}]"; // End the whole tree
				break;
			case 5: // CheckLogin
				echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 6: // CheckAccessLevel
				echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 7: // WriteProperty

				if (isset($_POST["name"])) $name = $_POST["name"];
				if (isset($_POST["address"])) $address = $_POST["address"];
				if (isset($_POST["zip"])) $zip = $_POST["zip"];
				if (isset($_POST["description"])) $description = $_POST["description"];
				$categoryID = 1;
				$userid = 10;

				//add the property
				$sql = "INSERT INTO property (name, address, zip, description, categoryID) VALUES ('{$name}', '{$address}', $zip, '{$description}', '{$categoryID}')";
				$wProperty = writeRecordset($con, $sql, $name, $address, $zip, $description, $categoryID);

				// add userID and propertyID (created in previous function) to user_property
				$sql = "INSERT INTO user_property (userID, propertyID) VALUES ({$userid}, (SELECT ID FROM property WHERE name = '{$name}' AND address = '{$address}' LIMIT 1))";
				$wUser_Property = writeRecordset($con, $sql, $userid, $name, $address);
				
				/* Inserting like the above will get you into trouble.  What you want is to find the value of the auto increment field from 
				the first query and use that in the second.  Also a really good idea to wrap both in a transaction.*/
				
				/*
				$con->beginTransaction();
				// I think this will work to put 2 statements in one PDO execute, but I haven't tried it yet.  (Also, semicolon at the end of the first)
				// I'm not sure if it will get tripped up by reusing the $userid field?
				// So basically I have time to criticize, but not actually test what I'm talking about... ;)
				// Worst case, you can do it with 2 execute statements
				$sql = "INSERT INTO property (name, address, zip, description, categoryID) VALUES ('{$name}', '{$address}', $zip, '{$description}', '{$categoryID}');";
				$sql .= "INSERT INTO user_property (userID, propertyID) VALUES ({$userid}, LAST_INSERT_ID())";
				// LAST_INSERT_ID() is the key to making this work.  It's different in different DBs, but that's the MySQL way.
				// See https://dev.mysql.com/doc/refman/5.6/en/getting-unique-id.html for more info
				$something = writeRecordset($con, $sql, $userid, $name, $address);
				$con->commit(); // If no errors
				// else do $con->rollBack(); // Something went wrong
				*/

				$_SESSION["message"] = "Property created";
				// redirect_to("landing.php");
				// echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 8: // WriteRoom
				echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 9: // WriteSection
				echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 10: // WriteItem
				echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 11: // GetCategories
				echo '{"error":"1","text":"Rosemary hasn\'t finished coding this yet."}';
				break;
			case 12: // Get list of properties for drop down
				// Messing with putting the description in the list too.  And blank, if there's no description.
				//$sql = "SELECT ID, CONCAT (name, ' - ', description) FROM property p INNER JOIN user_property up ON p.ID = up.propertyID WHERE up.userID = ?";
				$sql = "SELECT ID, name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID WHERE up.userID = ?";
				$rs = getRecordset($con, $sql, $userid);
				echo "{";
				foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime;
					else echo ",";
					echo '"' . $row["ID"] . '":"' . $row["name"] . '"';
				}
				echo "}";
				break;
			case 13: // Get list of sections for drop down
				$sql = "SELECT s.ID AS ID, s.name AS name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN section s ON p.ID = s.propertyID WHERE p.ID = 1 AND up.userID = ?";
				//$rs = getRecordset($con, $sql, 1, $userid);
				//$rs = getRecordset($con, $sql, $propertyid, $userid);
				$rs = getRecordset($con, $sql, $userid);
				echo "{";
				foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime;
					else echo ",";
					echo '"' . $row["ID"] . '":"' . $row["name"] . '"';
				}
				echo "}";
				break;
			default: 
				echo '{"error":"1","text":"Unknown function."}';
		}
		$con = null;
	} else {
		echo '"error":"2","text":"Unknown error, bad database handle."';
	}
} catch (Exception $e) {
    echo '"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"';
}

function writeRecordset($con, $sql, ...$parameters) {
	try {
		$paramcount = 1;
		$stmt = $con->prepare($sql);
	
		// $parameters is passed in as an array, go through it and add them all
		foreach ($parameters as $parameter) { 
			$stmt->bindParam($paramcount++, $parameter);
		}
		
		$stmt->execute();
		print_r($stmt);
		return $stmt;
	} catch (Exception $e) { // Echo the message in JSON and exit
		echo '"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"';
		exit;
	}
} //end writeRecordset

function getRecordset($con, $sql, ...$parameters) {
	try {
		$paramcount = 1;
		$stmt = $con->prepare($sql);
		
		// $parameters is passed in as an array, go through it and add them all
		foreach ($parameters as $parameter) { 
			$stmt->bindParam($paramcount++, $parameter);
		}
		
		$stmt->setFetchMode (PDO::FETCH_ASSOC); // This should default the fetch to return name->value that can be output directly to JSON easier
		$stmt->execute();
		return $stmt;
	} catch (Exception $e) { // Echo the message in JSON and exit
		echo '"error":"' . $e->getCode() . '","text":"' . $e->getMessage() . '"';
		exit;
	}
}

function echo_r($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
?>