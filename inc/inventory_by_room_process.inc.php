	<?php
		$property_selected=$_SESSION["message"];
		$q = "SELECT roomID, name, description, purchasePrice FROM item WHERE propertyID = $property_selected ORDER BY roomID ASC";
		$r = mysqli_query($dbc, $q);

		function inventory_by_room($r) {
			while ($row = mysqli_fetch_array($r)) {
				echo "<td>" . $row['name'] . "</td>";
				echo "<td>" . $row['description'] . "</td>";
				echo "<td> $ " . $row['purchasePrice'] . "</td>";
			}
		}
	?> 