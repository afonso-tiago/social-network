

<!DOCTYPE html>
<html>
  <head>
    
    <link href="css/stylesheet4.css" rel="stylesheet"/>
  </head>
  <body>
    
	<!--Die Menüleiste wird eingefügt-->
    <?php include("menue.php");?>
    
    <div id="einstellungen">
        
        <div id="einstellungen-ueberschrift">
            <h1>Einstellungen</h1>
        </div>
        
        <form id="einstellungen-inhalt" method="POST">
          
          <div id="einstellungen-inhalt-daten">
            
            <div id="einstellungen-inhalt-daten-oben">
            
              <div id="einstellungen-inhalt-daten-oben-links">
                
				<?php
					
					@$newDate = "'".$_POST["jahr"]."-".$_POST["monat"]."-".$_POST["tag"]."'";
					#Falls kein Passwort eingegeben wird, werden nur persönliche Daten in der Datenbank gespeichert
					if(@($_POST["passwortAlt"] == "") && @($_POST["passwortNeu1"] == "") && @($_POST["passwortNeu2"] == ""))
					{	
						#Es wird überprüft, ob die Datensätze leer sind
						if(@($_POST["vorname"] != "") && @($_POST["nachname"] != "") && @($newDate != "'--'"))
						{	
							@$conn->query("UPDATE benutzer SET vorname = \"{$_POST["vorname"]}\", nachname = \"{$_POST["nachname"]}\", geburtsdatum = {$newDate} WHERE(benutzername = \"{$benutzername}\");");
						}
					}else
					{
						#Überprüft, ob die Passwörter übereinstimmen
						if(@($_POST["passwortAlt"] == $conn->query("SELECT passwort FROM benutzer WHERE(benutzername = '{$benutzername}')")->fetch_assoc()["passwort"]) && @($_POST["passwortNeu1"] == @$_POST["passwortNeu2"]))
						{
							if(@($_POST["vorname"] != "") && @($_POST["nachname"] != "") && @($newDate != "'--'"))
							{	
								@$conn->query("UPDATE benutzer SET vorname = \"{$_POST["vorname"]}\", nachname = \"{$_POST["nachname"]}\", geburtsdatum = {$newDate}, passwort = \"{$_POST["passwortNeu1"]}\" WHERE(benutzername = \"{$benutzername}\");");
							}
						}	
					}
					
					#Daten des Benutzers werden ausgelesen
					@$result = ($conn->query("SELECT vorname, nachname, geburtsdatum FROM benutzer WHERE(benutzername = '{$benutzername}')"))->fetch_assoc();
					#Das Geburtsdatum wird in Tage, Monate und Jahre umgewandelt
					@$year = $conn->query("SELECT year('{$result["geburtsdatum"]}') AS year")->fetch_assoc()["year"];
					@$month = $conn->query("SELECT month('{$result["geburtsdatum"]}') AS month")->fetch_assoc()["month"];
					@$day = $conn->query("SELECT day('{$result["geburtsdatum"]}') AS day")->fetch_assoc()["day"];
				?>
				
                <p>Persönliche Daten</p>
                <input class="einstellungen-inhalt-daten-input" placeholder="Vorname" name="vorname" type="text" value= <?php echo "\"{$result["vorname"]}\""; ?>/>
                <input class="einstellungen-inhalt-daten-input" placeholder="Nachname" name="nachname" type="text" value= <?php echo "\"{$result["nachname"]}\""; ?>/>
                <div id="einstellungen-inhalt-daten-geburtstag">
                  
                  <input class="einstellungen-inhalt-daten-geburtstag-input" placeholder="Tag" name="tag" type="text" value= <?php echo "\"$day\""; ?>/>
                  <input class="einstellungen-inhalt-daten-geburtstag-input" placeholder="Monat" name="monat" type="text" value= <?php echo "\"$month\""; ?>/>
                  <input class="einstellungen-inhalt-daten-geburtstag-input" placeholder="Jahr" name="jahr" type="text" value= <?php echo "\"$year\""; ?>/>
                </div>
              </div>
              <div id="einstellungen-inhalt-daten-oben-rechts">
                
                <p>Passwort ändern</p>
                <input class="einstellungen-inhalt-daten-input" placeholder="altes Passwort" name="passwortAlt" type="text" />
                <input class="einstellungen-inhalt-daten-input" placeholder="neues Passwort" name="passwortNeu1" type="text" />
                <input class="einstellungen-inhalt-daten-input" placeholder="Passwort wiederholen" name="passwortNeu2" type="text" />
              </div>
            </div>
            <div id="einstellungen-inhalt-daten-unten">
              
              <div id="einstellungen-inhalt-daten-unten-bild">
				<?php
					$profilbild = ($conn->query("SELECT profilbild FROM benutzer WHERE(benutzername = '{$benutzername}')"))->fetch_assoc();
					
					#Falls ein Profilbild vorhanden ist, wird dieses ausgegeben, ansonsten wird ein Standartbild verwendet
					if($profilbild["profilbild"] != null)
					{
						echo '<img src="data:image/jpeg;base64,' . base64_encode($profilbild['profilbild']) . '"/>';
					} else
					{
						echo '<img src="bilder/default.png"/>';
					}
					
				?>
              </div>
              <div id="einstellungen-inhalt-daten-unten-info">
                
                <p>Profilbild ändern</p>
                <input id="einstellungen-inhalt-daten-url" placeholder="URL" type="text" />
                <button id="einstellungen-inhalt-daten-durchsuchen" type="button">Durchsuchen</button>
              </div>
            </div>
          </div>
          <div id="einstellungen-inhalt-optionen">
																						  <!--Beim klicken des Knopfes, wird die javascipt Funktion neuLaden() aufgerufen-->
            <input type="button" value="Zurücksetzen" id="einstellungen-inhalt-optionen-nein" onclick="neuLaden()"/>
            <button id="einstellungen-inhalt-optionen-ja">Übernehmen</button>
          </div>
        </form>
    </div>
    </form>
  </body>
  
  <script>
	//Die Seite wird neu geladen
	function neuLaden()
	{
		location.reload();
	}
  </script>
  
</html>