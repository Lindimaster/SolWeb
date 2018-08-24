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
$userid = $_REQUEST["userid"];

$sql = "SELECT loadprofile_id, loadprofile_name FROM LoadProfile WHERE user_id = $userid";
$result = $connection->query($sql);

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		echo "<option value='" . $row["loadprofile_id"] . "' >" . $row["loadprofile_name"] . "</option>";
	}
} else {
echo "<option value='none' >Keine Profile verfügbar</option>";
}
$connection->close();
?>
