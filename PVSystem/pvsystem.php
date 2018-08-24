<?php
  session_start();

  $pdo = new PDO('mysql:host=mysql57b.ssl-net.net;dbname=h17u833_solweb', 'h17u833', '9P98CBpLuDmA1Adp');
	$pdo->exec("set names utf8");
?>
<!DOCTYPE html#>
<html>
  <head>
    <meta charset="utf-8" />
  	<meta http-equiv="content-type" content="text/html" />
  	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  	<meta name="viewport" content="width=device-width, initial-scale=1" />
  	<meta name="keywords" content="footer, links, icons" />

  	<link rel="stylesheet" href="../styles/footer.css" />
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" />
  	<link rel="stylesheet" href="../styles/infoPage.css" />
  	<link rel="stylesheet" href="../styles/menubar.css"/>

    <title>PV-Anlage hinzufügen</title>
  </head>
  <body>
    <div id="container">
      <div class="topnav">
        <a href="../index.php">Startseite</a>
        <a href="../Simulation/simulation.php">Simulation</a>
        <a href="profil.php">Profil</a>
        <a href="../Login/login.php?logout=1" id="loginLogout">Logout</a>
      </div>
      <div id="body">
        <form id="frmAddLocation" class="upload" action="profil.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
  				<h2 class="upload">Neue PV-Anlage:</h2>
          <table>
            <tr>
              <td>Postleitzahl: </td>
              <td><input type="text" placeholder="Postleitzahl" name="NewLocationPLZ" required /></td>
            </tr>
            <tr>
              <td>Ortsname: </td>
              <td><input type="text" placeholder="Ort" name="NewLocationCity" required /></td>
            </tr>
            <tr>
              <td>Straßenname: </td>
              <td><input type="text" placeholder="Straße" name="NewLocationStreet" required /></td>
            </tr>
            <tr>
              <td>Hausnummer: </td>
              <td><input type="text" placeholder="Hausnummer" name="NewLocationHouse" required /></td>
            </tr>
            <tr>
              <td>Name der PV-Anlage: </td>
              <td><input type="text" placeholder="Name" name="NewPVName" required /></td>
            </tr>
            <tr>
              <td>Größe in kWp: </td>
              <td><input type="text" placeholder="Größe" name="NewPVSize" required /></td>
            </tr>
            <tr>
              <td>Ausrichtung der Anlage: </td>
              <td><input type="text" placeholder="Ausrichtung" name="NewPVAlignment" required /></td>
            </tr>
            <tr>
              <td>Neigung zur horizontalen: </td>
              <td><input type="text" placeholder="Neigung" name="NewPVInclination" required /></td>
            </tr>
            <tr>
              <td>Link zur Anlage im SolarWeb: </td>
              <td><input type="text" placeholder="Link SolarWeb" name="NewPVLink" /></td>
            </tr>
            <tr>
              <td>Beschreibung der Anlage: </td>
              <td><input type="text" placeholder="Beschreibung" name="NewPVDescription"/></td>
            </tr>
            <tr>
              <td><input id="btnAddLocation" class="button" type="submit" name="AddLocation" value="Standort hinzufügen"/></td>
            </tr>
          </table>
  			</form>
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
  </body>
</html>
