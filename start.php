<?php
	
	#Baut eine Verbindung zur Datenbank auf
	$conn = new mysqli("localhost", "root", "", "AfonsoWeihrauchDB");
	
	#Falls $_POST["benutzername"], $_POST["passwort"] nicht existiert, wird der Standartwert "" gesetzt
	if(!isset($_POST["benutzername"])) {

		$_POST["benutzername"] = "";
	}

	if(!isset($_POST["passwort"])) {

		$_POST["passwort"] = "";
	}

	#Das Passwort des eingegebenen Benutzers wird aus der Datenbank ausgelesen
	$result = $conn->query("SELECT passwort FROM benutzer WHERE(benutzername = \"{$_POST["benutzername"]}\")");
	$passwort = $result->fetch_assoc()["passwort"];

	#Eingegebenes Passwort wird mit dem ausgelesenen Passwort verglichen
	if($passwort === $_POST["passwort"])
	{
		#Es wird eine Session gestartet, damit jede Seite auf den Benutzernamen zugreifen kann
		session_start();
		$_SESSION['bname'] = $_POST["benutzername"];
		#letzter Login wird aktualisiert
		$conn->query("UPDATE benutzer SET login=now() WHERE(benutzername = \"{$_POST["benutzername"]}\")");
		#Weiterleitung zur Startseite
		header("Location: startseite.php");
	}
?>

<!DOCTYPE html>

<html>
<head>
	<link href="css/stylesheet.css" rel="stylesheet" />
</head>
<body>
	
	<div id="background">
		
		<div id="login">
			
			<div id="logo">
    			<img src="bilder/logo.png"/>
  			</div>
			
			<div id="login-info">
				
				<form action="start.php" method="post" id="login-form">
					
					<p>Benutzername</p>
					
					<input type="text" name="benutzername" placeholder="Benutzername" class="input"/>
					
					<p>Passwort</p>
					
					<input type="password" name="passwort" placeholder="Passwort" class="input"/>
					
					<span id="checkbox-text">
						<input type="checkbox" value="checkbox" name="checkbox" /> angemeldet bleiben 
					</span>

					<button>Login </button>

					<p>Kein Account? <a id="registrieren" href="registration.php">Registrieren</a></p>
				</form>
			</div>
		</div>
	</div>
</body>
</html>