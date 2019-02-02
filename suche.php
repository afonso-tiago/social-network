<!DOCTYPE html>
<html>
  <head>
    
    <link href="css/stylesheet5.css" rel="stylesheet"/>
  </head>
  <body>
    
	<!--Die Menüleiste wird eingefügt-->
    <?php include("menue.php");?>				

	<?php	
		#Es werden alle Leerzeichen aus der Suchanfrage entfernt
		@$trimmed = str_replace(' ', '', $_GET["suche"]);
		#Die Daten der Profile, die die Suchanfrage erfüllen, werden ausgelesen
		@$result = $conn->query("SELECT benutzername, vorname, nachname, profilbild, login FROM benutzer WHERE((concat(vorname, nachname) LIKE \"%{$trimmed}%\") AND (benutzername != \"".$benutzername."\"));");
			
		#Überprüft, ob die Suchanfrage leer ist
		if(!($trimmed === ""))
		{
			echo '<div id="suche">';
				
				#Die Anzahl der Ergebnisse wird ausgegeben
				if(@$result->num_rows == null)
				{
					echo '<p id="suche-info">0 Ergebnisse</p>';
				} else
				{
					if(@$result->num_rows == 1)
					{
						echo '<p id="suche-info">1 Ergebnis</p>';
					}else
					{
						echo '<p id="suche-info">'.@$result->num_rows.' Ergebnisse</p>';
					}
				}
				
				#Die gefundenen Profile werden angezeigt
				for($i = 0;$i < @$result->num_rows;$i++)
				{
					$temp = $result->fetch_assoc();
					#Die Anzahl der Freunde eines Profils wird bestimmt
					$anzFreunde = $conn->query("SELECT count(*) AS anz FROM freunde WHERE((benutzername1 = \"{$temp["benutzername"]}\"));")->fetch_assoc()["anz"] + $conn->query("SELECT count(*) AS anz FROM freunde WHERE((benutzername2 = \"{$temp["benutzername"]}\"));")->fetch_assoc()["anz"];
						
                    echo '<div class="suche-ergebnis">';
                        
						echo '<div class="suche-ergebnis-bild">';
							#Falls ein Profilbild vorhanden ist, wird dieses ausgegeben, ansonsten wird ein Standartbild verwendet
							if($temp["profilbild"] != null)
							{
								echo '<a href="profil.php?bn='.$temp["benutzername"].'"><img class="suche-ergebnis-bild-bild" src="data:image/jpeg;base64,' . base64_encode($temp['profilbild']) . '"/></a>';
							} else
							{
								echo '<a href="profil.php?bn='.$temp["benutzername"].'"><img class="suche-ergebnis-bild-bild" src="bilder/default.png"/></a>';
							}
						
							
						echo '</div>';
						
                        echo '<div class="suche-ergebnis-daten">';

                            echo '<span class="suche-ergebnis-daten-name"><a href="profil.php?bn='.$temp["benutzername"].'">'.$temp["vorname"].' '.$temp["nachname"].'</a></span>';
							
							#Die Anzahl der Freunde eines Profils wird angezeigt
                            if($anzFreunde == 1)
                            {
                                echo '<span class="suche-ergebnis-daten-freunde">1 Freund</span>';
                            }else
                            {
                                echo '<span class="suche-ergebnis-daten-freunde">'.$anzFreunde.' Freunde</span>';
                            }

                            echo '<span class="suche-ergebnis-daten-login">Zuletzt online: '.$temp["login"].'</span>';
                        echo '</div>';
                        echo '<a href=""><img class="suche-ergebnis-icon" src="bilder/freundHinzufuegen-icon.png"/></a>';
				   echo '</div>';
				}
			echo '</div>';
		}else
		{
			#Gibt bei leerer Suchanfage aus, dass keine Ergebnisse gefunden wurden
			echo '<div id="suche">';
				echo '<p id="suche-info">0 Ergebnisse</p>';
			echo '</div>';
		}
	?>
  </body>
</html>