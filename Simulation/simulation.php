<!-- DB Credentials -->
<?php
	session_start();

	$hostname = "mysql57b.ssl-net.net";
	$username = "h17u833";
	$password = "9P98CBpLuDmA1Adp";
	$dbname = "h17u833_solweb";
?>

<!DOCTYPE html>
<html id="website" lang="de">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../styles/footer.css">
		<link rel="stylesheet" href="../styles/simulation.css">
		<link rel="stylesheet" href="../styles/menubar.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="../scripts/mapsScripts.js"></script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"></script>
		<script src="../scripts/inputForm.js"></script>
		<script src="../scripts/simulation.js"></script>

		<title>Simulation</title>
	</head>

	<body>
		<script>var userid = "<?php echo $_SESSION["userid"]; ?>"</script>
		<div id="container">
			<div class="topnav">
				<a href="../index.php" id="index">Startseite</a>
				<a href="../Login/login.php?logout=1" id="loginLogout">Logout</a>
				<a href="simulation.php" class="active">Simulation</a>
				<a href="../Profil/profil.php">Profil</a>
			</div>
			<div id="body">
				<h1>Simulation</h1>

				<!-- Left Panel for Input-->
				<div class="panel input">

					<!-- Area for Loadprofile -->
					<h2>Lastprofil</h2>

					<select id="slctProfile">
						<option value="none">lädt...</option>
					</select>

					<!-- Upload new Loadprofile -->
					<input type="button" onclick="uploadNewProfile();" value="Neues Lastprofil hochladen"/><br />
					<form id="frmUploadProfile" method="post" enctype="multipart/form-data" style="display: none">
						<label id="lblName" ></label>Name: <input type="text" name="profileName"/></label><br />
						<p>CSV Zeilenformat: "TT.MM.JJJJ hh:mm:ss;0,0"</p>
						<input id="fileProfile" type="file" name="fileProfile" accept=".csv" /><br />

						<input type="submit" name="btnSaveProfile" value="Speichern" />
					</form>

					<div id="divFileUploadError">

					<!-- Check for input errors, Upload Profile and save it in GLOBALS -->
					<?php
						if(isset($_POST["btnSaveProfile"])) {   //Check if Submit Button was clicked
							//Check if file is suited for Upload
							$uploadFile = basename($_FILES["fileProfile"]["name"]);
							$fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
							$GLOBALS['uploadOK'] = 1;

							if($_FILES["fileProfile"]["name"] == "") {   //Check if file was uploaded
								echo "Keine Datei gefunden.";
								$GLOBALS['uploadOK'] = 0;
							}
							else if($fileType != "csv") {   //Check if file is .csv
								echo "Es sind nur .csv Dateien erlaubt.";
								$GLOBALS['uploadOK'] = 0;
							}


							//Check other Inputs, Upload Profile
							if($GLOBALS['uploadOK'] == 1) {
								$GLOBALS["fileOK"] = true;

								$profile = file_get_contents($_FILES["fileProfile"]["tmp_name"]);

								$lines = explode("\r\n", $profile);

								//Decode Uploaded Profile
								$profileCSV = "";

								$regexDate = '/^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/';
								$regexTime = '/^([0-1]?[0-9]|[2][0-3]):([0-5][0-9])(:[0-5][0-9])?$/';
								for ($i=0; $i < count($lines) && $GLOBALS["fileOK"] == true; $i++) {

									$line = explode(";", $lines[$i]);

									//check if line can be skipped
									if(isset($line[0]) && isset($line[1]) && $line[0] != "" && $line[1] != 0){
										//check for right date format
										if(!preg_match($regexDate, explode(" ", $line[0])[0])){
											echo "Falsches Datumsformat (erlaubt: TT/MM/JJJJ,TT-MM-JJJJ, TT.MM.JJJJ) oder ungültiges Datum (30.02.2000).<br />";
											$GLOBALS["fileOK"] = false;
										}
										//check for right time format
										if(!preg_match($regexTime, explode(" ", $line[0])[1])){
											echo "Falsches Zeitformat (erlaubt: hh:mm:ss) oder ungültige Zeit (24:00, 25:90:60).<br />";
											$GLOBALS["fileOK"] = false;
										}

										//Append line
										if($GLOBALS["fileOK"] == true){
											$profileCSV = $profileCSV . $line[0] . ";" . $line[1] . "\r\n";
										}
									}
								}

								if($GLOBALS["fileOK"] == true){
									//Connect to Database
									$connection = new mysqli($hostname, $username, $password, $dbname);
									if($connection -> connect_error) {
										echo "Connection to Database failed: ". $connection->connect_error."<br />";
									}
									else {
										mysqli_set_charset($connection, "UTF8");
										//LoadProfile
										$userid = $_SESSION["userid"];

										//Check Name for ^[a-zA-Z0-9 -]+$
										if(preg_match("/^[a-zA-Z0-9 -äöü]+$/", $_POST["profileName"])){
											$name = $_POST["profileName"];
											$createLoadProfile = "INSERT INTO LoadProfile(user_id, loadprofile_name) VALUES(" . $userid . ", '" . $name . "')";

											if($connection->query($createLoadProfile) === TRUE){
												//Get latest Loadprofile
												$loadprofileID = 0;
												$getLoadprofileID = "SELECT loadprofile_id FROM LoadProfile WHERE user_id = $userid ORDER BY loadprofile_id DESC";
												$result = $connection->query($getLoadprofileID);

												if($result->num_rows > 0){
													$row = $result->fetch_assoc();
													$loadprofileID = $row["loadprofile_id"];

													//Upload Data
													$insertDataQuery = "";

													$queryValues = explode("\r\n", $profileCSV);
													for ($i=0; $i < count($queryValues)-1; $i++) {
														$tempRow = explode(";", $queryValues[$i]);

														//Format Date String
														$tempRow[0] = str_replace(".", "-", $tempRow[0]);
														$tempRow[0] = date("Y-m-d H:i:s", strtotime($tempRow[0]));

														//Format Value String
														$tempRow[1] = str_replace(",", ".", $tempRow[1]);

														$insertDataQuery = $insertDataQuery . "INSERT INTO ConsumptionData(loadprofile_id, date, consumptionvalue) VALUES(" . $loadprofileID . ", '" . $tempRow[0] . "', " . $tempRow[1] . ");";
													}

													if($connection->multi_query($insertDataQuery) === TRUE){
														echo "Profil gespeichert.<br />";
													}
													else {
														echo "Error: " . $connection->error . "<br />";
													}
												}
												else {
													echo "Error: Kein Profil vorhanden.<br />";
												}
											}
											else {
												echo "Error: " . $connection->error . "<br />";
											}
										}
										else {
											echo "Nur A-Z, a-z, 0-9, - und SPACE im Namen erlaubt.<br />";
										}
										$connection->close();
									}
								}
							}
						}
					?>
					</div>

					<!-- Area for PV System -->
					<h2>PV-Anlage</h2>

					<div id="mapSystems" style="height: 350px"></div>

					<label>Standort <select id="slctLocation" onchange="selectedLocationChanged();">
						<option value="none">lädt...</option>
					</select></label> <br />
					<label>Anlage <select id="slctSystem">
						<option value="none">lädt...</option>
					</select></label> <br />
					<label>Skalierung <input id="systemScaling" type="number" value="100" step="5" min="5" max="500" /> %</label><br />

					<!-- Area for advanced options -->
					<input id="btnShowAdvancedOptions" type="button" onclick="showAdvancedOptions();" value="Erweiterte Optionen ∨" />
					<div id="divAdvancedOptions" style="display:none;">

						<h3>Energiespeicher</h3>

						<table id="tblBattery" style="border: 1px solid black;">
							<tr>
								<th colspan="2"><label><input id="chkBattery" type="checkbox" onchange="showStorageSettings('battery');" /> Batterie</label></th>
							</tr>
							<tr class="battery">
								<td>Priorität</td>
								<td>
									<select id="slctBatteryPriority">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
								</td>
							</tr>
							<tr class="battery">
								<td>Größe</td>
								<td><input id="batSize" type="number" value="5" step="1" min="1" max="1000" /> kWh</td>
							</tr>
							<tr class="battery">
								<td>Nutzungsgrad</td>
								<td><input id="batEfficiency" type="number" value="90" step="1" min="80" max="100" /> %</td>
							</tr>
							<tr class="battery">
								<td>Maximaler Ladezustand</td>
								<td><input id="batMaxCharge" type="number" value="100" step="1" min="80" max="100" /> %</td>
							</tr>
							<tr class="battery">
								<td>Minimaler Ladezustand</td>
								<td><input id="batMinCharge" type="number" value="20" step="1" min="0" max="50" /> %</td>
							</tr>
							<tr class="battery">
								<td>Maximale Ladeleistung</td>
								<td><input id="batMaxChargingCurrent" type="number" value="66" step="1" min="0" max="200" /> % von Größe</td>
							</tr>
						</table>

						<table id="tblBoiler" style="border: 1px solid black;">
							<tr>
								<th colspan="2"><label><input id="chkBoiler" type="checkbox" onchange="showStorageSettings('boiler');" /> Boiler</label></th>
							</tr>
							<tr class="boiler">
								<td>Priorität</td>
								<td>
									<select id="slctBoilerPriority">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
								</td>
							</tr>
							<tr class="boiler">
								<td>Größe</td>
								<td><input id="boilerSize" type="number" value="300" step="100" min="100" max="5000" /> l</td>
							</tr>
							<tr class="boiler">
								<td>Maximale Temperatur</td>
								<td><input id="boilerMaxTemperature" type="number" value="65" step="1" min="50" max="70" /> °C</td>
							</tr>
							<tr class="boiler">
								<td>Temperaturverlust</td>
								<td><input id="boilerTemperatureLoss" type="number" value="1" step="0.1" min="0.1" max="5" /> °C/Tag</td>
							</tr>
							<tr class="boiler">
								<td colspan="2">Energieentnahme</td>
							</tr>
							<tr class="boiler">
								<td>Bewohner</td>
								<td><input id="boilerNumberResidents" type="number" value="2" step="1" min="0" max="100" /> Personen</td>
							</tr>
							<tr class="boiler">
								<td>Warmwasserverbrauch</td>
								<td><select id="boilerWaterConsumption">
									<option value="low">Niedrig</option>
									<option value="normal">Normal</option>
									<option value="high">Hoch</option>
								</select></td>
							</tr>
						</table>

						<table id="tblPuffer" style="border: 1px solid black;">
							<tr>
								<th colspan="2"><label><input id="chkpuffer" type="checkbox" onchange="showStorageSettings('puffer');" /> Puffer</label></th>
							</tr>
							<tr class="puffer">
								<td>Priorität</td>
								<td>
									<select id="slctPufferPriority">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
								</td>
							</tr>
							<tr class="puffer">
								<td>Größe</td>
								<td><input id="pufferSize" type="number" value="1000" step="100" min="500" max="50000" /> l</td>
							</tr>
							<tr class="puffer">
								<td>Maximale Temperatur</td>
								<td><input id="pufferMaxTemperature" type="number" value="90" step="1" min="50" max="95" /> °C</td>
							</tr>
							<tr class="puffer">
								<td>Temperaturverlust</td>
								<td><input id="pufferTemperatureLoss" type="number" value="1" step="0.1" min="0.1" max="5" /> °C/h</td>
							</tr>
							<tr class="puffer">
								<td>Beheizte Fläche</td>
								<td><input id="pufferHeatedSurface" type="number" value="150" step="1" min="50" max="5000" /> m^2</td>
							</tr>
							<tr class="puffer">
								<td>Heizwärmebedarf(HWB)</td>
								<td><input id="pufferHeizwaermebedarf" type="number" value="75" step="1" min="5" max="250" /> kWh/m^2a</td>
							</tr>
						</table>

						<table id="tblCar" style="border: 1px solid black;">
							<tr>
								<th colspan="2"><label><input id="chkCar" type="checkbox" onchange="showStorageSettings('car');" /> Elektroauto</label></th>
							</tr>
							<tr class="car">
								<td>Priorität</td>
								<td>
									<select id="slctBatteryPriority">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
								</td>
							</tr>
							<tr class="car">
								<td>Größe</td>
								<td><input id="carSize" type="number" value="40" step="1" min="10" max="100" /> kWh</td>
							</tr>
							<tr class="car">
								<td>Maximaler Ladezustand</td>
								<td><input id="carMaxCharge" type="number" value="100" step="1" min="80" max="100" /> %</td>
							</tr>
							<tr class="car">
								<td>Maximale Ladeleistung</td>
								<td><input id="carMaxChargingCurrent" type="number" value="100" step="1" min="0" max="200" /> % von Größe</td>
							</tr>
							<tr class="car">
								<td>Lastprofil</td>
								<td><input id="carLoadProfile" type="file"/></td>
							</tr>
							<tr class="car">
								<td>Anwesenheitszeiten</td>
								<td><input id="carAttendanceTimes" type="file"/></td>
							</tr>
						</table>

						<label>Stromkosten <input id="inpEnergyCost" type="number" value="20" min="0" max="40" step="1" /> ct/kWh</label><br />
						<label>Degradation <input id="inpDegredation" type="number" value="0.8" min="0.5" max="2" step="0.1"/> %</label><br />
					</div>

					<br />
					<input type="button" value="Simulieren" onclick="startSimulation();"/> <br />
				</div>

				<!-- Right Panel for Results-->
				<div class="panel result"></div>
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
