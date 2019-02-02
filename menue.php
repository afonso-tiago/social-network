<?php

 #Es wird eine Session gestartet, damit jede Seite auf den Benutzernamen zugreifen kann
 session_start();
 $benutzername = $_SESSION['bname'];

 #Baut eine Verbindung zur Datenbank auf
 $conn = new mysqli("localhost", "root", "", "AfonsoWeihrauchDB");
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="css/stylesheet2.css" rel="stylesheet"/>
  </head>
  <body>
    <div id="menue-hintergrund">

      <div id="menue-menue">

        <div id="menue-links">
          
          <a href="startseite.php"><img id="menue-logo" src="bilder/logo2.png" /></a>
        </div>

        <div id="menue-mitte">

          <form id="menue-suche" action="suche.php" method="get">

            <input id="menue-suche-text" type="text" name="suche" />
            <input class="menue-icon" id="menue-suche-icon" type="image" src="bilder/search-icon.png" />
          </form>
        </div>

        <div id="menue-rechts">
		  
		  <!--Der Benutzername wird ausgelesen, um in der Menüleiste angezeigt zu werden-->
          <a id="menue-benutzername" href="startseite.php"><?php echo ($conn->query("SELECT vorname FROM benutzer WHERE(benutzername = \"{$benutzername}\")"))->fetch_assoc()["vorname"]; ?> <?php echo ($conn->query("SELECT nachname FROM benutzer WHERE(benutzername = \"{$benutzername}\")"))->fetch_assoc()["nachname"];  ?></a>
          <a class="menue-icon" id="menue-startseite-icon" href="startseite.php"><img src="bilder/home-icon.png"/></a>
          <a class="menue-icon" id="menue-einstellungen-icon" href="einstellungen.php"><img src="bilder/settings-icon.png"/></a>
        </div>
      </div>
    </div>
  </body>
</html>