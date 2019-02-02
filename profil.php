<!DOCTYPE html>
<html>
  <head>
    
    <link href="css/stylesheet6.css" rel="stylesheet"/>
  </head>
  <body>
    
	<!--Die Menüleiste wird eingefügt-->
    <?php include("menue.php");?>
	
	<?php
		
		#Der Datensatz des besuchten Profils wird ausgelesen
		@$result = $conn->query("SELECT benutzername, vorname, geburtsdatum, nachname, profilbild, login FROM benutzer WHERE(benutzername = \"{$_GET["bn"]}\");")->fetch_assoc();
	?>
    
    <div id="profil">
      
      <div id="profil-oben">
        
        <div id="profil-oben-links">
          
          <div id="profil-oben-links-info">
            
            <div id="profil-oben-links-bild">
				<?php
				#Falls ein Profilbild vorhanden ist, wird dieses ausgegeben, ansonsten wird ein Standartbild verwendet
				if($result["profilbild"] != null)
				{
					echo '<img src="data:image/jpeg;base64,' . base64_encode($result['profilbild']) . '"/>';
				} else
				{
					echo '<img src="bilder/default.png"/>';
				}
				
               
				?>
            </div>
            <div id="profil-oben-links-daten">
              
			  <!--Die persönlichen Daten werden angezeigt-->
              <span class="profil-oben-links-daten-text"><b>Vorname:</b> <?php echo ($conn->query("SELECT vorname FROM benutzer WHERE(benutzername = \"{$_GET["bn"]}\")"))->fetch_assoc()["vorname"]; ?></span>
              <span class="profil-oben-links-daten-text"><b>Nachname:</b> <?php echo ($conn->query("SELECT nachname FROM benutzer WHERE(benutzername = \"{$_GET["bn"]}\")"))->fetch_assoc()["nachname"];  ?></span>
              <span class="profil-oben-links-daten-text"><b>Geburtstag:</b> <?php echo ($conn->query("SELECT geburtsdatum FROM benutzer WHERE(benutzername = \"{$_GET["bn"]}\")"))->fetch_assoc()["geburtsdatum"];  ?></span>
            </div>
          </div>
          <div id="profil-oben-links-login">
            
			<!--Der letzte Login wird angezeigt-->
            <p>letzter Login: <?php echo ($conn->query("SELECT login FROM benutzer WHERE(benutzername = \"{$_GET["bn"]}\")"))->fetch_assoc()["login"];  ?></p>
          </div>
        </div>
        <div id="profil-oben-rechts">
          
          <a href=""><img id="profil-oben-rechts-icon" src="bilder/freundHinzufuegen-icon.png"/></a>
        </div>
      </div>
      <div id="profil-unten">
        
        <div id="profil-unten-tabs">  
																			<!--Der Verweis der Knöpfe "Statusmeldungen" und "Freunde" wird auf das besuchte Profil gesetzt-->
          <button class="profil-unten-tabs-aktiv" id="profil-unten-tabs-1" <?php echo 'onclick=\'window.location="profil.php?bn='.$_GET["bn"].'"\';' ?>>Statusmeldungen</button>
          <button class="profil-unten-tabs-passiv" id="profil-unten-tabs-2" <?php echo 'onclick=\'window.location="profil2.php?bn='.$_GET["bn"].'"\';' ?>>Freunde</button>
        </div>
        <div id="profil-unten-inhalt">
          <?php
		  
		   #Die Staus werden ausgelesen und angezeigt
           $status = ($conn->query("SELECT uhrzeit, text  FROM status WHERE(benutzername = \"{$_GET["bn"]}\") ORDER BY s_ID DESC"));

           for($i = 0;$i<2 && $i < $status->num_rows;$i++)
           {
            $row = $status->fetch_assoc();
            echo '<div class="profil-unten-inhalt-status">';
            echo '<textarea readonly>'.$row["text"].'</textarea>';
            echo '<p>';
            echo $row["uhrzeit"];
            echo '</p>';
            echo '</div>';
           }
          ?>
        </div>
      </div>
    </div>
  </body>
</html>