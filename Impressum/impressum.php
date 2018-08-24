<?php session_start(); ?>
<!DOCTYPE html>
<html id="website" lang="de">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="footer, links, icons" />

    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../styles/infoPage.css">
    <link rel="stylesheet" href="../styles/menubar.css" />


	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="../scripts/login.js"></script>

    <title>Impressum</title>
</head>

<body>
	<script>
		var userid = "<?php echo $_SESSION['userid']; ?>";
	</script>
	<div id="container">
		<div class="topnav">
			<a href="../index.php" id="index">Startseite</a>
			<a href="../Login/login.php" id="loginLogout">Login</a>
		</div>
		<div class="main" id="body">
			<h1>Impressum</h1>
			<br />
			<h2>Für den Inhalt verantwortlich:</h2>
			<p>
				Dipl.-Ing. Horst Gaigg, Jutta Pelikan
				<br/>
				UID: ATU48683303
				<br/>
				Firmenbuchnummer: 185515t
				<br/>
				Firmbuchgericht: Landesgericht Wels
				<br/>
				Behörde gem. ECG: Bezirkshauptmannschaft Gmunden
				<br/>
				Fachgruppe: Unternehmensberatung und Informationstechnologie
				<br/>
				Berufsgruppe: Datenverarbeiter
				<br/>
				<a target="_blank" href="http://firmena-z.wko.at/ecgInfo.asp?MGID=93D05D0006DF0325587A5CD9003D34E2&amp;NOFRAME=J"
				onclick="javascript:urchinTracker ('/.external/http/firmena-z.wko.at/ecgInfo.asp?MGID=93D05D0006DF0325587A5CD9003D34E2&amp;NOFRAME=J'); "
				title="WKO Service" class="external-link-new-window">
				Informationen lt. §5 ECG und Offenlegungspflicht gemäß Mediengesetz §25</a>
			</p>
		</div>
		<div id="footer">
			<footer class="footer-distributed">
				<div class="footer-right">
					<p>KEM-Traunsteinregion &copy; 2018</p>
				</div>
				<div class="footer-left">
					<p class="footer-links">
						<a href="impressum.php" class="active">Impressum</a>
						<a href="../Kontakt/kontakt.php">Kontakt</a>
						<a href="../Datenschutz/datenschutz.php">Datenschutz</a>
					</p>
				</div>
			</footer>
		</div>
	</div>
</body>
</html>
