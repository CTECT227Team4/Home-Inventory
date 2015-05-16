<?php
include_once("../azconfig.php");

if (isset($_GET['F'])) $webfunction = $_GET['F'];
if (isset($_GET['id'])) $ID = $_GET['id'];

$userID= 2; 
$con = new PDO("mysql:host=localhost;dbname=" . $db, $user, $pwd);
if ($con) {
	$rs = $con->query("SELECT name, address, zip, p.description, icon FROM property p INNER JOIN user_property up ON p.ID = up.propertyID INNER JOIN user u ON u.ID = up.userID INNER JOIN category c ON c.ID = p.CategoryID WHERE up.userID = $userID;", PDO::FETCH_ASSOC);

	echo '<table border="1">';

	$headers = false;
	
	foreach ($rs as $row) {
		if (!$headers) {
			echo "{";
			$fields = @array_keys($row);
			foreach ($fields as $fieldname) echo "<td>$fieldname</td>";
			echo "</tr>";
			$headers = true;
		}

		foreach($row as $item) {
			echo "<td><a href=\"?db=$item\">$item</a></td>";
		}
		echo "</tr>";
	}
	echo "</table>";

	$con = null;
}
?>