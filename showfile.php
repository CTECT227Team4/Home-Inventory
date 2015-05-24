<?php
include_once("../azconfig.php");

$id = filter_input(INPUT_GET, "ID", FILTER_SANITIZE_NUMBER_INT);
$parentType = filter_input(INPUT_GET, "parentType", FILTER_SANITIZE_NUMBER_INT);
$item = filter_input(INPUT_GET, "item", FILTER_SANITIZE_NUMBER_INT);
$thumb = filter_input(INPUT_GET, "thumb", FILTER_VALIDATE_BOOLEAN);

if ($id > 0 && $parentType > 0 && $item > 0) {
    try {
        $dbh = new PDO("$driver:host=$server;dbname=$db", $user, $pwd); // connect to the database
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the PDO error mode to exception
		$sql = "SELECT " . ($thumb ? "thumbnail" : "attachment") . " AS pic, mimeType FROM attachment WHERE ID=? AND parentType=? AND item=?";
        $stmt = $dbh->prepare($sql);
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2, $parentType, PDO::PARAM_INT);
		$stmt->bindParam(3, $item, PDO::PARAM_INT);
        $stmt->execute(); 
        $stmt->setFetchMode(PDO::FETCH_ASSOC); // set the fetch mode to associative array
        $row = $stmt->fetch();

        if(sizeof($row) == 2) { // check we have a single image and type
            header("Content-type: " . $row['mimeType']); // set the headers
            echo $row['pic']; // output the image
        } else {
            throw new Exception("Mismatch between mime type and picture fields.");
		}
	} catch(PDOException $e) {
        echo $e->getMessage();
	} catch(Exception $e) {
        echo $e->getMessage();
	}
} else {
	echo 'Need more information about file.';
}
?>