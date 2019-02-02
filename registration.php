<?php
	
	#Baut eine Verbindung zur Datenbank auf
	$conn = new mysqli("localhost", "root", "", "AfonsoWeihrauchDB");
	
	#Überprüft, ob ein Textfeld leer ist
	if((@$_POST["benutzername"] != "") && (@$_POST["vorname"] != "") && (@$_POST["nachname"] != "") && (@$_POST["passwort"] != "") && (@$_POST["passwort2"] != "")) 
	{	
		@$result = $conn->query("SELECT benutzername FROM benutzer WHERE(benutzername = \"{$_POST["benutzername"]}\")");
		#Überprüft, ob der Benutzername bereits existiert
		if(!isset($result->fetch_assoc()["benutzername"])){
			
			#Überprüft, ob die Passwörter übereinstimmen
			if(@$_POST["passwort"] == @$_POST["passwort2"] && @$_POST["passwort"] != "")
			{
				#Fügt die eingegebenen Daten in die Datenbank ein
				$geburtsdaten = "\"{$_POST["jahr"]}-{$_POST["monat"]}-{$_POST["tag"]}\"";
				$sql = "INSERT INTO benutzer (benutzername, passwort, vorname, nachname, geburtsdatum)
						VALUES (\"{$_POST["benutzername"]}\", \"{$_POST["passwort"]}\", \"{$_POST["vorname"]}\", \"{$_POST["nachname"]}\", $geburtsdaten)";		
				if (($conn->query($sql) === TRUE)) 
				{
					#Es wird eine Session gestartet, damit jede Seite auf den Benutzernamen zugreifen kann
					session_start();
					$_SESSION['bname'] = $_POST["benutzername"];
					#letzter Login wird aktualisiert
					$conn->query("UPDATE benutzer SET login=now() WHERE(benutzername = \"{$_POST["benutzername"]}\")");
					#Weiterleitung zur Startseite
					header("Location: startseite.php");
				}
			}
		
/*
	Alle folgenden If-Anweisungen überpfrüfen, ob Daten eingegeben wurden
*/
		}else
		{
			$bExists = 1;
			if(@$_POST["passwort"] != @$_POST["passwort2"])
			{
				$samePassword = 1;
			}
		} 
	} else
	{
		@$result = $conn->query("SELECT benutzername FROM benutzer WHERE(benutzername = \"{$_POST["benutzername"]}\")");
		if(@isset($result->fetch_assoc()["benutzername"]))
		{
			$bExists = 1;
		}
		
		if(isset($_POST["benutzername"]) && @$_POST["benutzername"] == "")
		{
			$bLeer = 1;
		}
		
		if(isset($_POST["vorname"]) && @$_POST["vorname"] == "")
		{
			$vLeer = 1;
		}
		if(isset($_POST["nachname"]) && @$_POST["nachname"] == "")
		{
			$nLeer = 1;
		}
		if(@$_POST["passwort"] != @$_POST["passwort2"])
		{
			$samePassword = 1;
		} else
		{
			if(isset($_POST["passwort"]) && @$_POST["passwort"] == "")
			{
				$pLeer = 1;
			}
			if(isset($_POST["passwort2"]) && @$_POST["passwort2"] == "")
			{
				$p2Leer = 1;
			}
		}
		
	}
?>

<!DOCTYPE html>

<html>
<head>
	<link href="css/stylesheet.css" rel="stylesheet" />
</head>
<body>
	
	<div id="background">
		
		<div id="registration">
			
			<div id="logo2">
    			<img src="bilder/logo.png"/>
  			</div>
			
			<div id="registration-info">
				
				<form action="registration.php" method="post" id="registration-form">
					
					<p>Benutzername</p>
					
					<?php
					#Falls kein Benutzername eingegeben wurde oder er bereits existiert, wird eine Fehlermeldung ausgegeben
						if(@$bExists == 1)
						{
							echo "<input type=\"text\" name=\"benutzername\" placeholder=\"Benutzername bereits vergeben\" class=\"rot\"/>";
						} else
						{
							if(@$bLeer == 1)
							{
								echo "<input type=\"text\" name=\"benutzername\" placeholder=\"Benutzername muss angegeben werden\" class=\"rot\"/>";
							} else
							{
								echo "<input type=\"text\" name=\"benutzername\" placeholder=\"Benutzername\" class=\"input\"/>";
							}
						}
					?>
					
					
					<p>Persöhnliche Daten</p>
					<?php
					#Falls kein Vorname eingegeben wurde, wird eine Fehlermeldung ausgegeben
						if(@$vLeer == 1)
						{
							echo "<input type=\"text\" name=\"vorname\" placeholder=\"Vorname muss angegeben werden\" class=\"rot\"/>";
						} else
						{
							echo "<input type=\"text\" name=\"vorname\" placeholder=\"Vorname\"  class=\"input\"/>";
						}
						
					?>
					
					<?php
					#Falls kein Nachname eingegeben wurde, wird eine Fehlermeldung ausgegeben
						if(@$nLeer == 1)
						{
							echo "<input type=\"text\" name=\"nachname\" placeholder=\"Nachname muss angegeben werden\" class=\"rot\"/>";
						} else
						{
							echo "<input type=\"text\" name=\"nachname\" placeholder=\"Nachname\" class=\"input\"/>";
						}
					?>
					

					<div id="geburtstag"> 
					   <input type="text" name="tag" placeholder="Tag" class="input-geburtstag"/>
					   <input type="text" name="monat" placeholder="Monat" class="input-geburtstag"/>
					   <input type="text" name="jahr" placeholder="Jahr" class="input-geburtstag"/>
					</div>
					
                    <p>Passwort erstellen</p>
					
					<?php
					#Falls kein Passwort eingegeben wurde oder die Passwörter nicht übereinstimmen, wird eine Fehlermeldung ausgegeben
						if((@$samePassword ==  1))
						{
							echo "<input type=\"password\" name=\"passwort\" placeholder=\"Paswörter stimmen nicht überein!\" class=\"rot\"/>";
							echo "<input type=\"password\" name=\"passwort2\" placeholder=\"Passwort wiederholen\" class=\"rot\"/>";
						}else
						{
							if(@$pLeer == 1)
							{
								echo "<input type=\"password\" name=\"passwort\" placeholder=\"Paswort muss angegeben werden\" class=\"rot\"/>";
							} else
							{
								echo "<input type=\"password\" name=\"passwort\" placeholder=\"Passwort\" class=\"input\"/>";
							}
							
							if(@$p2Leer == 1)
							{
								echo "<input type=\"password\" name=\"passwort2\" placeholder=\"Paswort muss angegeben werden\" class=\"rot\"/>";
							} else
							{
								echo "<input type=\"password\" name=\"passwort2\" placeholder=\"Passwort wiederholen\" class=\"input\"/>";
							}
						}
					?>
					
					<?php
						
					?>

					<button>Registrieren </button>

					<p>Bereits registriert? <a id="login" href="start.php">Anmelden</a></p>
				</form>
			</div>
		</div>
	</div>

	
	
</body>
</html>