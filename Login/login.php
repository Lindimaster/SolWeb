<?php
	session_start();
	$pdo = new PDO('mysql:host=mysql57b.ssl-net.net;dbname=h17u833_solweb', 'h17u833', '9P98CBpLuDmA1Adp');
	$pdo->exec("set names utf8");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="footer, links, icons" />

		<link rel="stylesheet" href="../styles/footer.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../styles/menubar.css" />
		<link rel="stylesheet" href="../styles/login.css" />


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	<body>
	<div id="container">
		<div class="topnav">
			<a href="../index.php">Startseite</a>
			<a href="login.php" class="active" id="loginLogout">Login</a>
		</div>
		<div id="body">
			<?php
				if(!isset($_POST["SignUp"]) and !isset($_POST["SubmitSignUp"]))
				{
			?>
			<div class="login" id="panelLogin">
				<h1>Login</h1>
				<form action="login.php" method="post" class="login">
					<table class="login">
						<tr class="login">
							<td class="login">E-Mail:</td>
							<td class="login"><input type="email" size="40" maxlength="250" name="email"></td>
						</tr>
						<tr>
							<td class="login">Passwort:</td>
							<td class="login"><input type="password" size="40"  maxlength="250" name="password"></td>
						</tr>
					</table>
					<input type="submit" value="Login" name="Login" class="button">
					<input type="submit" value="Registrieren" name="SignUp" class="button">
				</form>
				<div class="login">
					<div class="login">
						<?php
						if(isset($_POST["Login"]) and !isset($_POST["SignUp"]))
						{
							$email = $_POST['email'];
							$password = $_POST['password'];
							$statement = $pdo->prepare("SELECT * FROM User WHERE email = :email");
							$result = $statement->execute(array('email' => $email));
							$user = $statement->fetch();
							if ($user !== false and password_verify($password, $user["password"]))
							{
								$_SESSION["userid"] = $user['user_id'];
								header("Location:../index.php");
							}
							else
							{
								echo "<p>Geben Sie gültige Zugangsdaten ein!</p>";
							}
						}
						if(isset($_GET["logout"]))
						{
							session_unset();
							if(session_destroy())
							{
								echo "<p>Sie wurden erfolgreich abgemeldet!</p>";
							}
							else
							{
								echo "<p>Ein Fehler ist aufgetreten!</p>";
							}
						}
						?>
					</div>
				</div>
			</div>
			<?php
				}
				if(isset($_POST["SignUp"]) or isset($_POST["SubmitSignUp"]))
				{
			?>
			<div class="login" id="panelRegister">
				<h1 class="login">Registrieren</h1>
				<form action="login.php" method="post" class="login">
					<table class="login">
						<tr class="Login">
							<td class="Login">Vorname:</td>
							<td class="Login"><input type="text" size="40" maxlength="250"name="firstname" required></td>
						</tr>
						<tr class="Login">
							<td class="Login">Nachname:</td>
							<td class="Login"><input type="text" size="40" maxlength="250"name="lastname" required></td>
						</tr>
						<tr class="login">
							<td class="login">E-Mail:</td>
							<td class="login"><input type="email" size="40" maxlength="250" name="email" required></td>
						</tr>
						<tr class="login">
							<td class="login">Passwort:</td>
							<td class="login"><input type="password" size="40"  maxlength="250" name="password" required></td>
						</tr>
						<tr class="login">
							<td class="login">Passwort wiederholen:</td>
							<td class="login"><input type="password" size="40" maxlength="250" name="password2" required></td>
						</tr>
					</table>
					<input type="submit" value="Abschicken" name="SubmitSignUp" class="button">
				</form>
			</div>
			<?php
				}
			?>
			<div class="login">
				<?php
					if(isset($_POST['SubmitSignUp']))
					{
						$error = false;
						$email = $_POST['email'];
						$password = $_POST['password'];
						$password2 = $_POST['password2'];
						$firstname = $_POST["firstname"];
						$lastname = $_POST["lastname"];

						if($password !== $password2)
						{
							echo "<p>Die Passwörter müssen übereinstimmen!</p>";
							$error = true;
						}

						if(!$error)
						{
							$statement = $pdo->prepare("SELECT * FROM User WHERE email = :email");
							$result = $statement->execute(array('email' => $email));
							$user = $statement->fetch();

							if($user !== false)
							{
								echo "<p>Diese E-Mail-Adresse wurde bereits verwendet</p>";
								$error = true;
							}
						}
						if(!$error)
						{
							$password_hash = password_hash($password, PASSWORD_DEFAULT);

							$statement = $pdo->prepare("INSERT INTO User (user_id, email, password, firstname, lastname, active) VALUES (NULL, :email, :password, :firstname, :lastname, 0)");
							$result = $statement->execute(array('email' => $email, 'password' => $password_hash, "firstname" => $firstname, "lastname" => $lastname));

							$statement = $pdo->prepare("SELECT user_id FROM User WHERE email = :email");
							$user = $statement->execute(array("email" => $email));

							if($result)
							{
								/*$subject = "Registrierung | Verifizierung";
								$message = "Danke, dass Sie sich bei uns registriert haben!
								Ihr Account wurder erstellt und Sie können sich mit folgenden Zugangsdaten anmelden:

								---------------------------------------
								e-mail: " . $email . "
								Passwort: " . $password . "

								Um Ihren Account zu aktivieren klicken Sie bitte folgenden Link:
								localhost/SolWeb/Verify/verify.php?email=" . $email . "&hash=" . $password_hash;

								$headers = "From:noreply@localhost \r\n";
								mail($email, $subject, $message, $headers);*/
								echo "<p>Sie haben sich erfolgreich registriert und können sich nun einloggen.</p>";
							}
							else
							{
								echo "<p>Es ist ein Fehler aufgetreten!</p>";
							}
						}
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
