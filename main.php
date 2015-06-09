<?php
include_once("../azconfig.php");
require_once ("inc/functions.php");
require_once ("inc/session.php");

$json = "";
$imageslocation = "./images/";  // The relative location to the icon images for the tree control
$webfunction = 0;
$userid = 0;
$propertyid = 0;
$sectionid = 0;
$roomid = 0;
$itemid = 0;
$zipcode = 0;
$parenttype = 0;
$parameters = [];

if (isset($_POST["json"])) $json = $_POST["json"];
// Casting all these to ints, so that invalid input can't be put in.
if (isset($_GET['F'])) $webfunction = (int) $_GET['F'];
if (isset($_SESSION["user_id"])) $userid = (int) $_SESSION["user_id"];
if (isset($_GET['propertyid'])) $propertyid = (int) $_GET['propertyid'];
if (isset($_GET['sectionid'])) $sectionid = (int) $_GET['sectionid'];
if (isset($_GET['roomid'])) $roomid = (int) $_GET['roomid'];
if (isset($_GET['itemid'])) $itemid = (int) $_GET['itemid'];
if (isset($_GET['parenttype'])) $parenttype = (int) $_GET['parenttype'];
if (isset($_GET['zipcode'])) $zipcode = (int) $_GET['zipcode'];

header('Content-Type: application/json');
// Moved $firstTime initialization to the top
$firstTime = true;

if ($userid < 1) {
	echo '"error":"3","text":"Not logged in."';
	exit;
}

try {
	if ($con) {
		switch ($webfunction) {
			case 1: // GetProperties for treeview
				// I'm renaming the columns in the query to return the same name and case that the jstree control uses
				//$sql = "SELECT CONCAT('P', p.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID LEFT OUTER JOIN category c ON c.ID = p.CategoryID WHERE up.userID = ?";
				// Added in the thumbnail, if it's been uploaded
				// Currently hardcoded to the first item in the list of attachments, if available.  

				// The jstree control requires unique ID's for each node.  Not exactly sure how we want to handle this.
				// For now I put "U" for the user node, "P" for property, so we'll have "S"=section, "R"=room, "I"=item
				echo '[{"id":"U' . $userid . '","text": "The Addams Family Properties","children":"true","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":['; // The recordset is being returned as an array, so start the array
				$sql = "SELECT CONCAT('P', p.id) AS id, p.name AS text, IF (a.ID != 0, CONCAT('showfile.php?ID=', a.ID, CONCAT('&parentType=1&item=',a.item,'&thumb=1')), CONCAT ('$imageslocation', icon)) AS icon FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID LEFT OUTER JOIN category c ON c.ID = p.CategoryID LEFT OUTER JOIN (SELECT ID, item FROM attachment WHERE parentType = 1 AND mimetype LIKE 'image%' ORDER BY item LIMIT 1) a ON a.ID = p.id WHERE up.userID = ?";
				jsonspew ($con, $sql, array($userid));
				echo "]}]"; // End the array, then end the whole tree
				break;
			case 2: // GetRooms for treeview
				// locahost/az/main.php?F=2&propertyid=1
				echo '[{"id":"P' . $propertyid . '","text": "Main House","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":['; // The recordset is being returned as an array, so start the array
				$sql = "SELECT CONCAT('R', r.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM room r LEFT OUTER JOIN category c ON c.ID = r.CategoryID WHERE r.propertyID = ?";
				jsonspew($con, $sql, array($propertyid));
				echo "]}]"; // End the array, then end the whole tree
				break;
			case 3: // GetSections
				// locahost/az/main.php?F=3&propertyid=1 OR localhost/az/main.php?F=3&roomid=2

				//check whether to select sections in a room or a property
				if (isset($roomid) && $roomid != 0) {
					$sql = "SELECT CONCAT ('S', s.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM section s LEFT OUTER JOIN category c ON c.ID = s.CategoryID WHERE s.roomID = ?";
					//creates variable for correct node (R) to be echoed with result
					$parent = "\"id\":\"R" . $roomid;
					$parameters = [$roomid];
				} else {
					$sql = "SELECT CONCAT('S', s.id) AS id, name AS text, CONCAT ('$imageslocation', icon) AS icon FROM section s LEFT OUTER JOIN category c ON c.ID = s.CategoryID WHERE s.propertyID = ?";
					//creates variable for correct node (P) to be echoed with result
					$parent = "\"id\":\"P" . $propertyid;
					$parameters = [$propertyid];
				}

				//if $roomid is set, get records for $roomid, otherwise get records for $propertyid
				// isset($roomid) ? $parameters = [$roomid] : $parameters = [$propertyid];

				$rs = getRecordset($con, $sql, $parameters);

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

				if (isset($_POST["name"])) $name = addslashes($_POST["name"]);
				if (isset($_POST["address"])) $address = addslashes($_POST["address"]);
				if (isset($_POST["zip"])) $zip = $_POST["zip"];
				if (isset($_POST["description"])) $description = addslashes($_POST["description"]);
				$categoryID = 1;
				$userid = $_SESSION["user_id"];

				try {
					$con->beginTransaction();

					$sql = "INSERT INTO property (name, address, zip, description, categoryID) VALUES ('{$name}', '{$address}', $zip, '{$description}', $categoryID)";

					$parameters = [$name, $address, $zip, $description, $categoryID];

					//adds new property to property table
					$stmt = writeRecordset($con, $sql, $parameters);

					//get id of new property
					$property = $con->lastInsertId();

					$sql = "INSERT INTO user_property (userID, propertyID) VALUES ({$userid}, {$property})";

					$parameters = [$userid, $property];
					//add property and userid to user_property
					$stmt = writeRecordset($con, $sql, $parameters);

					$con->commit(); //end transaction
				} catch (Exception $e) {
					$con->rollBack();
					echo "Failed: " . $e->getMessage();
				}

				redirect_to("landing.php");
				$_SESSION["message"] = "Property created";
				break;
			case 8: // WriteRoom
				// if (isset($_POST["propertyID"])) $propertyID = $_POST["propertyID"];
				$propertyID = 18;
				if (isset($_POST["name"])) $name = addslashes($_POST["name"]);
				if (isset($_POST["description1"])) $description = addslashes($_POST["description1"]);
				$categoryID = 2;

				$sql = "INSERT INTO room (propertyID, name, type, description, categoryID) VALUES ({$propertyID}, '{$name}', 'room', '{$description}', $categoryID)";
				$parameters = [$propertyID, $name, $description, $categoryID];

				try {
					writeRecordset($con, $sql, $parameters);
				} catch (Exception $e) {
					echo "Failed: " . $e->getMessage();
				}

				redirect_to("landing.php");
				break;
			case 9: // WriteSection
				// if (isset($_POST["propertyID"])) $propertyID = $_POST["propertyID"];
				$propertyID = 18;
				$roomID = 16;
				if (isset($_POST["name"])) $name = addslashes($_POST["name"]);
				if (isset($_POST["description1"])) $description = addslashes($_POST["description1"]);
				$categoryID = 3;

				$sql = "INSERT INTO section (propertyID, roomID, name, description, categoryID) VALUES ({$propertyID}, {$roomID}, '{$name}', '{$description}', $categoryID)";

				$parameters = [$propertyID, $roomID, $name, $description, $categoryID];

				try {
					writeRecordset($con, $sql, $parameters);
				} catch (Exception $e) {
					echo "Failed: " . $e->getMessage();
				}

				redirect_to("landing.php");
				break;
			case 10: // WriteItem
				$item = new Item($json);
				echo $item->write($con);
				break;
			case 11: // GetCategories
				// locahost/az/main.php?F=11&parentType=1
				$parentType = $_GET["parentType"];
				$sql = "SELECT CONCAT('C', c.id) AS id, description AS text, CONCAT ('$imageslocation', icon) AS icon FROM category c WHERE c.parentType = ?";

				$parameters = [$parentType];

				$rs = getRecordset($con, $sql, $parameters);

				echo '[{"id":"C' . $parentType . '","text": "Categories","icon": "./images/appraisal.png","state": {"opened" : "true"},"children":';
				echo "["; // The recordset is being returned as an array, so start the array
				
				foreach ($rs as $row) {
					if ($firstTime) $firstTime = !$firstTime; // Don't echo a comma on the first line, only when added a new one
					else echo ",";

					print json_encode($row, JSON_UNESCAPED_SLASHES);
				}
				echo "]"; // End the array
				echo "}]"; // End the whole tree
				break;
			case 12: // Get list of properties for drop down
				echo '{"properties":[{"ID":"0","name":"-Select a Property-"},';
				jsonspew ($con, "SELECT ID, name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID WHERE name <> '' AND name IS NOT NULL AND up.userID = ?", array($userid));
				echo ',{"ID":"99999","name":"-Add a Property-"}]}';
				break;
			case 13: // Get list of sections for drop down
				echo '{"sections":[{"ID":"0","name":"-Select a Section-"},';
				// No idea why this line doesn't work, no time to figure it out.
				//jsonspew ($con, "SELECT s.ID AS ID, s.name AS name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN section s ON p.ID = s.propertyID WHERE  up.userID = ? AND p.ID = ?", array($userid, $propertyid));
				jsonspew ($con, "SELECT s.ID AS ID, s.name AS name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN section s ON p.ID = s.propertyID WHERE  up.userID = ? AND p.ID = " . $propertyid, array($userid));
				echo ',{"ID":"99999","name":"-Add a Section-"}]}';
				break;
			case 14: //getRooms for dropdown
				echo '{"rooms":[{"ID":"0","name":"-Select a Room-"},';
				// No idea why this line doesn't work, no time to figure it out.
				//jsonspew ($con, "SELECT r.ID, r.name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN room r ON r.propertyID = p.ID WHERE up.userID = ? AND p.ID = ? ORDER BY r.ID ASC", array($userid, $propertyid));
				jsonspew ($con, "SELECT r.ID, r.name FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN room r ON r.propertyID = p.ID WHERE up.userID = ? AND p.ID = " . $propertyid, array($userid));
				echo ',{"ID":"99999","name":"-Add a Room-"}]}';
				break;
			case 15: // get City/State/County from zip code
				echo '{"zipcode":';
				jsonspew($con, "SELECT city, state, county FROM zip z WHERE z.zipcode = ? LIMIT 1", array($zipcode));
				echo "}";
				break;
			case 16: // Get categories for dropdown
				echo '{"categories":[{"ID":"0","name":"-Select a Category-"},';
				jsonspew ($con, "SELECT ID, description AS name FROM category WHERE parenttype = ? AND userid IN (1," . $userid . ")", array($parenttype));
				echo ',{"ID":"99999","name":"-Add a Category-"}]}';
				break;
			case 17: // GetEditSection
				$section = new Section();
				$section->ID = $sectionid;
				echo $section->getjson($con);
				break;
			case 18: // GetEditRoom
				$room = new Room();
				$room->ID = $roomid;
				echo $room->getjson($con);
				break;
			case 19: // GetEditItem
				$item = new Item();
				$item->ID = $itemid;
				echo $item->getjson($con);
				break;
			case 20: // GetEditProperty
				$property = new Property();
				$property->ID = $propertyid;
				echo $property->getjson($con);			
				break;
			case 21: // WriteRoom
				$room = new Room($json);
				echo $room->write($con);
				break;
			case 22: // WriteSection
				$section = new Section($json);
				echo $section->write($con);
				break;
			case 23: // WriteProperty
				$property = new Property($json);
				echo $property->write($con);
				break;
			case 24: // DataTables Properties
				echo '{"data":[';
				jsonspew($con, "SELECT ID, Name, Address, Zip, Description FROM property p INNER JOIN user_property up ON p.ID = up.propertyID AND up.userID = ?", array($userid));
				echo "]}";
				break;
			case 25: // DataTables Rooms
			/* SELECT r.ID, p.name, r.name, r.description, r.categoryID, r.notes FROM property p
				INNER JOIN user_property up ON p.ID = up.propertyID
				INNER JOIN room r ON r.propertyID = p.ID 
				-- LEFT JOIN category c ON c.ID = r.categoryID
				-- WHERE c.parentType = 2 AND up.userID = 24
				WHERE up.userid = 24*/
				echo '{"data":[';
				$sql = "SELECT r.ID, p.name AS Property, r.Name, r.Description, r.CategoryID, r.Notes FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN room r ON r.propertyID = p.ID WHERE up.userid = ?";
				jsonspew($con, $sql, array($userid));
				echo "]}";
				break;
				break;
			case 26: // DataTables Sections
				break;
			case 27: // DataTables Items
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
?>