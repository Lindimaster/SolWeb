<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
	</head>

	<body>
		<?php
		$hostname = "mysql57b.ssl-net.net";
		$username = "h17u833";
		$password = "9P98CBpLuDmA1Adp";
		$dbname = "h17u833_solweb";

		$connection = new mysqli($hostname, $username, $password, $dbname);

		if($connection -> connect_error) {
			die("Could not connect: " . connect_error);
		}
		mysqli_set_charset($connection, "UTF8");
		$sql = "SELECT PhotovoltaicSystem.photovoltaicsystem_id, PhotovoltaicSystem.pvname, Location.longitude, Location.latitude, PhotovoltaicSystem.alignment FROM PhotovoltaicSystem LEFT OUTER JOIN Location ON PhotovoltaicSystem.location_id=Location.location_id;";
		$result = $connection->query($sql);
		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				echo "<option value=" . $row["photovoltaicsystem_id"].";".$row["latitude"].";".$row["longitude"] . ">" . $row["pvname"] . " - " . $row["alignment"] . "</option>";
			}
		} else {
		echo "<option value='none' >Keine Anlagen verfügbar</option>";
		}
		$connection->close();
		?>
	</body>
</html>
