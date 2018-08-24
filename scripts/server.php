<?php
	session_start();

	if(isset($_GET["userid"]))
	{
		try
		{
			$pdo = new PDO('mysql:host=mysql57b.ssl-net.net;dbname=h17u833_solweb', 'h17u833', '9P98CBpLuDmA1Adp');
			$pdo->exec("set names utf8");
			//header("Content-type:application/json; charset=UTF-8");

			$sql = $pdo->prepare("SELECT PhotovoltaicSystem.size, PhotovoltaicSystem.alignment, PhotovoltaicSystem.inclination, PhotovoltaicSystem.description, PhotovoltaicSystem.linksolarweb, PhotovoltaicSystem.pvname, Location.postalcode, Location.cityname, Location.street, Location.housenumber FROM PhotovoltaicSystem INNER JOIN Location ON  (PhotovoltaicSystem.location_id = Location.location_id AND PhotovoltaicSystem.userid = :user_id);");
			$result = $sql->execute(array("user_id" => $_GET["userid"]));

			$data = array();

			while($row = $sql->fetch(PDO::FETCH_ASSOC))
			{
				array_push($data, $row);
			}

			echo json_encode($data);
			$pdo = null;
		}
		catch(PDOException $e)
		{
			echo "Verbindung fehlgeschlagen: " . $e->getMessage();
			$pdo = null;
		}
	}
	else
	{
		echo "Es ist ein Fehler aufgetreten!";
	}
?>
