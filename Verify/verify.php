<?php
  session_start();
  $pdo = new PDO('mysql:host=mysql57b.ssl-net.net;dbname=h17u833_solweb', 'h17u833', '9P98CBpLuDmA1Adp');
  $pdo->exec("set names utf8");
  if(isset($_GET["email"]) and !empty($_GET["email"]) and isset($_GET["hash"]) and !empty($_GET["hash"]))
  {
    $email = $_GET["email"];
    $hash = $_GET["hash"];

    $sql = $pdo->prepare("SELECT email, password, active FROM User WHERE email = :email AND active = 0");
    $result = $sql->execute(array("email" => $email));

    $rows = $sql->rowCount();

    if($rows > 0)
    {
      $sql = $pdo->prepare("UPDATE User SET active = 1 WHERE email = :email");
      $result = $sql->execute(array("email" => $email));

      echo "<div>Ihr Account ist nun verifiziert, Sie können sich jetzt einloggen.</div>";
    }
    else
    {
      echo "<div>Entweder der Link ist ungültig oder Sie haben Ihren Account schon verifiziert.</div>";
    }
  }
  else
  {
    echo "<div>Verifizierung fehlgeschlagen, bitte verwenden Sie den Link den wir Ihnen per mail geschickt haben.</div>";
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Account Verifizierung</title>

    <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="footer, links, icons" />

		<link rel="stylesheet" href="../styles/footer.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../styles/menubar.css" />
    <link rel="stylesheet" href="../styles/infoPage.css" />
  </head>
  <body>
    <div id="container">
      <div id="body">
        <div class="topnav">
    			<a href="../index.php">Startseite</a>
    			<a href="../Login/login.php" id="loginLogout">Login</a>
    		</div>
        <div>
        </div>
      </div>
      <div id=footer>
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
