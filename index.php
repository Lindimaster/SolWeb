<?php
	session_start();
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="footer, links, icons" />

    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/menubar.css" />
    <link rel="stylesheet" href="styles/index.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="scripts/login.js"></script>
    <title>Startseite</title>
</head>

<body>
	<script>
		var userid = "<?php echo $_SESSION['userid']; ?>";
	</script>
	<div id="container">
		<div class="topnav">
			<a class="active" href="index.php" id="index">Startseite</a>
			<a href="Login/login.php" id="loginLogout">Einloggen</a>
		</div>
		<div id="body">
			<h1>Willkommen</h1>
			<div>
				<h2>Warum eine Photovoltaikanlagen Simulation?</h2>
				<p>
					Mit dem Photovoltaikanlagen-Simulationstool können Sie simulieren, wie sich eine Investition in eine PV-Anlage finanziell für Sie rechnen würde.
				</p>
				<h2>So funktioniert's:</h2>
				<p>
					Sie können sich ganz einfach bei uns registrieren und dann die Simulation starten. Für die Simulation wird von Ihnen bloß ein aussagekräftiges Lastprofil benötigt und dann können Sie ein PV-Anlage Ihrer Wahl auswählen und dann die Simulation starten. Wenn Ihnen, das nicht genau genug ist haben Sie auch die Möglichkeit noch viele andere Einstellungen zu treffen und zu vergleichen wie sich diese auf das Ergebnis auswirken.
				</p>
			</div>
		</div>
		<div id="footer">
			<footer class="footer-distributed">
				<div class="footer-right">
					<p>KEM-Traunsteinregion &copy; 2018</p>
				</div>
				<div class="footer-left">
					<p class="footer-links">
						<a href="Impressum/impressum.php">Impressum</a>
						<a href="Kontakt/kontakt.php">Kontakt</a>
						<a href="Datenschutz/datenschutz.php">Datenschutz</a>
					</p>
				</div>
			</footer>
		</div>
	</div>
</body>
</html>
