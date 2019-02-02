<!DOCTYPE html>
<html>
  <head>
    
    <link href="css/stylesheet3.css" rel="stylesheet"/>
  </head>
  <body>
    
	<!--Die Menüleiste wird eingefügt-->
    <?php include("menue.php");?>
	
    <div id="startseite">

      <div id="startseite-links">
      
        <div id="startseite-links-profil">
          <div id="startseite-links-profil-bild">
			<?php
				#Der Datensatz des eingeloggten Benutzers wird ausgelesen
				@$result = $conn->query("SELECT benutzername, vorname, geburtsdatum, nachname, profilbild, login FROM benutzer WHERE(benutzername = \"".$benutzername."\");")->fetch_assoc();
			?>
			
			<?php
				#Falls ein Profilbild vorhanden ist, wird dieses ausgegeben, ansonsten wird ein Standartbild verwendet
				if($result['profilbild'] != null)
				{
					echo '<img src="data:image/jpeg;base64,' . base64_encode($result['profilbild']) . '"/>';
				}else
				{
					echo "<img src='bilder/default.png'>"; 
				}
			?>
          </div>
          <div id="startseite-links-profil-daten">
            
			<!--Die persönlichen Daten werden angezeigt-->
            <span class="startseite-links-profil-text"><b>Vorname:</b> <?php echo $result["vorname"]; ?></span>
            <span class="startseite-links-profil-text"><b>Nachname:</b> <?php echo $result["nachname"]; ?></span>
            <span class="startseite-links-profil-text"><b>Geburtstag:</b> <?php echo $result["geburtsdatum"]; ?></span>
          </div>
        </div>
        <div id="startseite-links-login">
          
		  <!--Der letzte Login wird angezeigt-->
          <span id="startseite-links-login-text"><b>letzer Login:</b> <?php echo $result["login"]; ?></span>
        </div>
      </div>
      <div id="startseite-mitte">

        <div id="startseite-mitte-verfassen">
          
          <form id="startseite-mitte-verfassen-form" method="POST">
            
            <div id="startseite-mitte-verfassen-inhalt">
																										 <!--Bei jedem Tastenschlag wird die javascipt Funktion func() aufgerufen-->
              <textarea id="startseite-mitte-verfassen-inhalt-textarea" name="status-inhalt" onkeyup="func(this)" maxlength="160"></textarea>
            </div>
            <div id="startseite-mitte-verfassen-info">
              <span id="startseite-mitte-verfassen-info-text" name="zeichen">160</span>
     <?php
	#Der Inhalt des Textfeldes wird in der Datenbank gespeichert 
    if(@$_POST["status-inhalt"] != "")
    {
     $conn->query("INSERT INTO status (benutzername, text) VALUES (\"{$benutzername}\", \"{$_POST["status-inhalt"]}\")");
    }
     ?>
     
              <button id="startseite-mitte-verfassen-info-button">Posten</button>
            </div>
          </form>
        </div>
        <div id="startseite-mitte-statusmeldungen">
        
		  <?php
		   #Die Status werden aus der Datenbank ausgelesen und angezeigt
		   $status = ($conn->query("SELECT uhrzeit, text  FROM status WHERE(benutzername = \"{$benutzername}\") ORDER BY s_ID DESC"));

		   for($i = 0;$i < 2 && $i < $status->num_rows;$i++)
		   {
			$row = $status->fetch_assoc();
			echo '<div class="startseite-mitte-statusmeldungen-status">';
			echo '<textarea class="startseite-mitte-statusmeldungen-status-textarea" readonly>'.$row["text"].'</textarea>';
			echo '<span class="startseite-mitte-statusmeldungen-status-zeit">';
			echo $row["uhrzeit"];
			echo '</span>';
			echo '</div>';
		   }
		  ?>
        </div>
      </div>
      <div id="startseite-rechts">

        <div id="startseite-rechts-titel">
        
          <h2 id="startseite-rechts-titel-text">Freunde</h2>
        </div>
        <div id="startseite-rechts-freunde">
          
		  <?php	
			
			#Die Daten der Freunde werden aus der Datenbank ausgelesen und angezeigt
			@$result = $conn->query("SELECT DISTINCT benutzername, vorname, nachname, login, profilbild FROM freunde, benutzer WHERE((benutzername1=benutzername OR benutzername2=benutzername) AND (benutzername1='$benutzername' OR benutzername2='$benutzername') AND benutzername!='$benutzername') ORDER BY vorname, nachname;");
				
			for($i = 0;$i < @$result->num_rows;$i++)
			{
				$temp = $result->fetch_assoc();

				echo '<div class="startseite-rechts-freunde-freund">';

					echo '<div class="startseite-rechts-freunde-freund-bild">';
						#Falls ein Profilbild vorhanden ist, wird dieses ausgegeben, ansonsten wird ein Standartbild verwendet
						if($temp["profilbild"] != null)
						{
							echo '<a href="profil.php?bn='.$temp["benutzername"].'"><img class="startseite-rechts-freunde-freund-bild-bild" src="data:image/jpeg;base64,' . base64_encode($temp['profilbild']) . '"/></a>';
						} else
						{
							echo '<a href="profil.php?bn='.$temp["benutzername"].'"><img class="startseite-rechts-freunde-freund-bild-bild" src="bilder/default.png"/></a>';
						}
					echo '</div>';

					echo '<div class="startseite-rechts-freunde-freund-daten">';

						echo '<span class="startseite-rechts-freunde-freund-name"><a href="profil.php?bn='.$temp["benutzername"].'">'.$temp["vorname"].' '.$temp["nachname"].'</a></span>';

						echo '<span class="startseite-rechts-freunde-freund-login">'.$temp["login"].'</span>';

						echo '<form>';
							echo '<button class="startseite-rechts-freunde-freund-button">Freund entfernen</button>';
						echo '</form>';
					echo '</div>';
			   echo '</div>';
			}
		  ?>
        </div>
      </div>
    </div>
  </body>
  
  <script>
  //Die Anzahl der noch verfügbaren Zeichen wird ermittelt und angezeigt
 function func(text) 
 {
  document.getElementById("startseite-mitte-verfassen-info-text").innerHTML = (160-text.value.length).toString();
 }
 </script>
</html>