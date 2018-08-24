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

    <title>Kontakt</title>
</head>

<body>
	<script>
		var userid = "<?php echo $_SESSION['userid']; ?>";
	</script>
	<div id="container">
		<div class="topnav">
			<a href="../index.php"id="index">Startseite</a>
			<a href="../Login/login.php" id="loginLogout">Login</a>
		</div>
		<div class="main" id="body">
			<h1>Kontakt</h1>
			<br>
			<h2>Technologiezentrum Salzkammergut GmbH</h2>
			<p>
				Krottenseestraße 45
				<br/>
				4810 Gmunden
				<br/>
				Telefon: +43 (7612) 9003
				<br/>
				Fax: +43 (7612) 9003-1030
				<br/>
				E-mail: zukunft(at)tzs.at
				<br/>
				Web: <a href="http://www.tzs.at">http://www.tzs.at</a> | <a href="www.kem-traunsteinregion.at">www.kem-traunsteinregion.at</a>
				<br/>
			</p>
		</div>
		<div id="footer">
			<footer class="footer-distributed">
				<div class="footer-right">
					<p>KEM-Traunsteinregion &copy; 2018</p>
				</div>
				<div class="footer-left">
					<p class="footer-links">
						<a href="../Impressum/impressum.php">Impressum</a>
						<a href="kontakt.php" class="active">Kontakt</a>
						<a href="../Datenschutz/datenschutz.php">Datenschutz</a>
					</p>
				</div>
			</footer>
		</div>
	</div>
</body>
</html>