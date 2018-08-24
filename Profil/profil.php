<?php
	session_start();

	if(!isset($_SESSION['userid']))
	{
		header("Location:../index.php");
	}

	$pdo = new PDO('mysql:host=mysql57b.ssl-net.net;dbname=h17u833_solweb', 'h17u833', '9P98CBpLuDmA1Adp');
	$pdo->exec("set names utf8");
?>
<!DOCTYPE html>
<html id="website" lang="de">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="content-type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="keywords" content="footer, links, icons" />

	<link rel="stylesheet" href="../styles/footer.css" />
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="../styles/profil.css" />
	<link rel="stylesheet" href="../styles/menubar.css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="../scripts/profil.js" charset="utf-8"></script>

	<title>Mein Profil</title>
</head>

<body>
	<script>
		var userid = "<?php echo $_SESSION['userid']; ?>";
	</script>
	<div id="container">
		<div class="topnav">
        <a href="../index.php">Startseite</a>
        <a href="../Simulation/simulation.php">Simulation</a>
		<a href="profil.php" class="active" >Profil</a>
		<a href="../Login/login.php?logout=1" id="loginLogout">Logout</a>
	</div>
	<div id="body">
		<h1>Mein Profil</h1>

		<div class="upload">			
			<div class="upload" action="profil.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
				<h3 class="upload">Meine Anlagen:</h3>
				<p class="upload">
					<table class="upload" id="pvSystemTable">
						<tr id="pvsTableHeader">
							<td>Name</td>
							<td>Größe (kWp)</td>
							<td>Ausrichtung</td>
							<td>Winkel</td>
							<td>Beschreibung</td>
							<td>Standort</td>
							<td>SolarWeb</td>
							<td><a href="../PVSystem/pvsystem.php"><img src="../Images/AddIcon.png"/><a></td>
						</tr>
					</table>
				</p>
			</div>
			<form id="frmUpload" class="upload" action="profil.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
				<h3 class="upload">Ertragsdaten:</h3>
				<div class="upload">
					<p class="upload">Datei zum Hochladen auswählen:</p>
					<input class="button" type="file" name="fileToUpload"/>
					<input class="button" style="margin: 5px 0px;" type="submit" value="Hochladen" name="Submit" />
				</div>
			</form>
		</div>
		<div class="php">
			<?php
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if(isset ($_POST["Submit"]))
				{
					if(isset($_FILES["fileToUpload"]))
					{
						if($_FILES["fileToUpload"]["error"] > 0)
						{
							echo "<p>Fehler Code: " . $_FILES["fileToUpload"]["error"] . "</p>";
						}
						else
						{
							doUpload($pdo);
						}
					}
				}
				else if(isset($_POST["AddLocation"]))
				{
					$validCity = checkCity($_POST["NewLocationPLZ"], $_POST["NewLocationCity"], $pdo);
					if($validCity)
					{
						$coordinates = geoCode($_POST["NewLocationPLZ"], $_POST["NewLocationCity"], $_POST["NewLocationStreet"], $_POST["NewLocationHouse"]);
						if($coordinates)
						{
							insertLocation($pdo, $_POST["NewLocationPLZ"], $_POST["NewLocationStreet"], $_POST["NewLocationHouse"], $coordinates[0], $coordinates[1]);
						}
					}
					else
					{
						echo "<p>Postleitzahl und Ort stimmen nicht überein.</p>";
					}
				}
				else if(isset($_POST["AddPV"]))
				{
					try
					{
						$sql = $pdo->prepare("INSERT INTO PhotovoltaicSystem (photovoltaicsystem_id, location_id, size, alignment, inclination, linksolarweb, description, pvname, userid) VALUES (null, :locationid, :size, :alignment, :inclination, :link, :description, :pvname, :userid);");
						$result = $sql->execute(array("locationid" => $_POST["NewPVLocationNr"], "size" => $_POST["NewPVSize"], "alignment" => $_POST["NewPVAlignment"], "inclination" => $_POST["NewPVInclination"], "link" => $_POST["NewPVLink"], "description" => $_POST["NewPVDescription"], "pvname" => $_POST["NewPVName"], "userid" => $_SESSION["userid"]));
					}
					catch(PDOException $e)
					{
						echo "<p>Fehler: " . $e->getMessage() . "</p>";
					}
					if($result)
					{
						echo "<p>Anlage erfolgreich hinzugefügt!</p>";
					}
				}
			}
			function geoCode($postalcode, $city, $street, $housenumber)
			{
				$address = $postalcode . " " . $city . " " . $street . " " . $housenumber;
				$address = urlencode($address);

				$url = "https://maps.google.com/maps/api/geocode/json?address={$address}";

				$response_json = file_get_contents($url);

				$resp = json_decode($response_json, true);

				if($resp["status"] == "OK")
				{
					$latitude = isset($resp["results"][0]["geometry"]["location"]["lat"]) ? $resp["results"][0]["geometry"]["location"]["lat"] : "";
					$longitude = isset($resp["results"][0]["geometry"]["location"]["lng"]) ? $resp["results"][0]["geometry"]["location"]["lng"] : "";

					if($latitude and $longitude)
					{
						$data_arr = array();

						array_push($data_arr, $latitude, $longitude);

						return $data_arr;
					}
					else
					{
						return false;
					}
				}
				else
				{
					echo "<strong>Fehler: {$resp['status']}</strong>";
					return false;
				}
			}
			function insertLocation($pdo, $postalcode, $street, $housenumber, $latitude, $longitude)
			{
				try
				{
					$sql = $pdo->prepare("SELECT location_id FROM Location WHERE user_id = :userid AND postalcode = :postalcode AND street = :street AND housenumber = :housenumber");
					$sql->execute(array("userid" => $_SESSION["userid"], "postalcode" => $postalcode, "street" => $street, "housenumber" => $housenumber));
					if(count($sql->fetchAll(PDO::FETCH_ASSOC)) > 0)
					{
						echo"<p>Standort bereits vorhanden!</p>";
					}
					else
					{
						$sql = $pdo->prepare("INSERT INTO Location (location_id, postalcode, user_id, street, housenumber, longitude, latitude) VALUES (NULL, :postalcode, :user_id, :street, :housenumber, :longitude, :latitude);");
						$sql->execute(array("postalcode" => $postalcode, "user_id" => $_SESSION["userid"], "street" => $street, "housenumber" => $housenumber, "longitude" => $longitude, "latitude" => $latitude));

						echo "<p>Standort erfolgreich hinzugefügt.</p>";
					}
				}
				catch(PDOException $e)
				{
					echo "<p>Verbindungsfehler: " . $e->getMessage() . "</p>";
				}
			}
			function checkCity($postalcode, $city, $pdo)
			{
				try
				{
					$sql = $pdo->prepare("SELECT cityname FROM City WHERE postalcode = :plz");
					$result = $sql->execute(array("plz" => $postalcode));

					$cityname = $sql->fetch(PDO::FETCH_ASSOC)["cityname"];
				}
				catch(PDOException $e)
				{
					echo "<p>Verbindung fehlgeschlagen: " . $e->getMessage() . "</p>";
				}
				if(is_null($cityname))
				{
					try
					{
						$sql = $pdo->prepare("INSERT INTO City (postalcode, cityname) VALUES(:postalcode, :city);");
						$result = $sql->execute(array("postalcode" => $postalcode, "city" => $city));

						return true;
					}
					catch(PDOException $e)
					{
						echo "<p>Beim Erstellen eines neuen Ortes ist ein Verbindungsfehler aufgetreten: " . $e->getMessage() . "</p>";

						return false;
					}
				}
				else if($cityname === $city)
				{
					return true;
				}
				return false;
			}
			function doUpload($pdo)
			{
				$date = NULL;
				$yieldValue = NULL;
				$photovoltaicSystemID = NULL;

				$temparr = explode("_", $_FILES["fileToUpload"]["name"]);
				$pvname = '';
				for($i = 0;$i < count($temparr);$i ++)
				{
					if((($i + 1) < count($temparr) !== FALSE))
					{
						if(($i +2) < count($temparr) !== FALSE)
						{
							$pvname .= $temparr[$i] . ' ';
						}
						else
						{
							$pvname .= $temparr[$i];
						}
					}
				}
				$alignment = $_POST["alignment"];

				$sql = $pdo->prepare("SELECT photovoltaicsystem_id FROM PhotovoltaicSystem WHERE pvname = :pvname AND alignment = :alignment limit 1");
				$result = $sql->execute(array('pvname' => $pvname, 'alignment' => $alignment));
				if(!$result)
				{
					echo "<p>Ein Fehler ist aufgetreten!</p>";
				}
				$data = $sql->fetch(PDO::FETCH_ASSOC);
				$photovoltaicSystemID = $data["photovoltaicsystem_id"];
				$columnYieldData = NULL;

				$sql ="";
				if(isset($_POST["Submit"]))
				{
					$row = 1;
					if(($handler = fopen($_FILES["fileToUpload"]["tmp_name"], "r")) !== FALSE)
					{
						while (($data = fgetcsv($handler, 1000, ";")) !== FALSE) {
							$num = count($data);

							if($row === 1)
							{
								if($num === 2)
								{
									$columnYieldData = 1;
								}
								else if($num > 2)
								{
									$column2 = explode("-", $data[1]);
									$column3 = explode("-", $data[2]);

									if($column2[count($column2) - 1] === $alignment)
									{
										$columnYieldData = 1;
									}
									else if($column3[count($column3) - 1] === $alignment)
									{
										$columnYieldData = 2;
									}
									else
									{
										echo "<p>An error occured!</p>";
									}
								}
								else
								{
									echo "<p>There went something wrong!</p>";
								}
								$data = fgetcsv($handler, 1000, ";");
							}
							if($row > 2)
							{
								$date = $data[0];
								$yieldValue = $data[$columnYieldData];
								if($yieldValue != 'n/a' && $yieldValue != 0)
								{
									//Format the yieldvalue into a float so the db can store it correctly.
									$yieldValue = "" . $yieldValue . "";
									$yieldValue = floatval(str_replace(",",".",$yieldValue));

									//Format the date into a datetime so the db can store it correctly.
									$date = str_replace(".","-",$date);
									$date = date("Y-m-d H:i:s", strtotime($date));
									$sql .= $pdo->quote("INSERT INTO YieldData(date, yieldvalue, photovoltaicsystem_id) VALUES ( " . $date . ", " . $yieldValue . ", " . $photovoltaicSystemID . ");");
								}
							}
							$row++;
						}
						fclose($handler);
						doDBInsert($pdo, $sql);
					}
				}
			}
			function doDBInsert($pdo, $sql)
			{
				$message = "";
				try
				{
					$pdo->exec($sql);
					$message = "Daten erfolgreich hochgeladen!";
				}
				catch(PDOException $e)
				{
					$message = $sql . "<br>" . $e->getMessage();
				}
				$pdo = null;

				echo "<p>" . $message . "</p>";
			}
			?>
		</div>
	</div>
	<div id="footer">
		<footer class="footer-distributed">
        <div class="footer-right">
            <p>KEM-Traunsteinregion &copy; 2018</p>
        </div>
        <div class="footer-left">
            <p class="footer-links">
                <a href="../Impressum/impressum.php">Impressum</a>
                <a href="../Kontakt/kontakt.php">Kontakt</a>
                <a href="../Datenschutz/datenschutz.php">Datenschutz</a>
            </p>
        </div>
    </footer>
	</div>
	</div>
</body>
</html>
