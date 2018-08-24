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
$sql = "SELECT Location.location_id, Location.street, Location.housenumber, Location.postalcode, Location.cityname, Location.latitude, Location.longitude, PhotovoltaicSystem.photovoltaicsystem_id, PhotovoltaicSystem.pvname, PhotovoltaicSystem.size, PhotovoltaicSystem.alignment, PhotovoltaicSystem.inclination, PhotovoltaicSystem.description FROM Location JOIN PhotovoltaicSystem ON Location.location_id=PhotovoltaicSystem.location_id ORDER BY Location.location_id;";
$result = $connection->query($sql);
if($result->num_rows > 0){
	$locations = array();
	while($row = $result->fetch_assoc()){
		$locations[] = $row;
	}
}
print json_encode($locations);
$connection->close();
?>
