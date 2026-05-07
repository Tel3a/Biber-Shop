<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Mein Biber Webshop</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 
<!-- <div class="menuband">
	<div id="logo"> </div>
	<br>

</div>
 -->
<div class="pfeil"> <a href="startseite.php"> <b>↑</b> </a></div>
   
   <h1>Willkommen auf diesem Webshop!!</h1>
   <p>Dies ist ein einfacher Absatz.</p>
<div class="item" id="item4"> 
			<div id="footerinhalt"><br>© 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj <br> <br> 	<a href="Impressum.html">IMPRESSUM</a> <br>  <a href="Quellen.html">QUELLEN</a> <br> </div>
</div>

        <h1>Shop und Produkte für Biber</h1> 
	<?php
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$datenbank = "Bibershop";

	// Verbindung herstellen
	$conn = mysqli_connect($servername, $username, $password, $datenbank);
	
	//Daten abfragen
	$sql = "SELECT * FROM Produkte";
	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_assoc($result)) {
	    echo "id: " . $row["PID"]. " - Name: " . $row["PName"]. " - Beschreibung: " . $row["PBeschreibung"]. " - Preis: ".$row["PPreis"]. " - Bestand: ".$row["PBestand"]."<br>";
	  }
	
	 mysqli_close($conn); 
	?> 






</body>
</html>
