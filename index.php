<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Mein Biber Webshop</title>
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
</head>

<body> 

 <div class="menuband">
	<a id="logo" href="index.php"><img src="house.png" alt="Startseite" ></a>
	<div menuoptionen> <a  href="kaufen.php">Kaufen</a>
	<a href="login.php">Konto</a> </div>
</div>




<div class="seiteninhalt"> 

	<div class="fotogallerie"
	data-flickity-options='{ "wrapAround": true }'>
	<div class="galleriefoto"><p class="cursor typewriter-animation">Hallo einsamer Biber! Schön, dass du da bist! </p> </div>
	<div class="galleriefoto"><img src="shampoo.jpg" alt="photo1"></div>
	<div class="galleriefoto"><img src="shampoo2.jpg" alt="photo1"></div>
	<div class="galleriefoto"><img src="shampoo3.jpg" alt="photo1"></div>
	
	</div>
	

	<br><br><br>
	
	<h1>Shop und Produkte für Biber</h1> 
	<h1>Willkommen auf dieser Seite!!</h1>

	<!-- Datenbanken einbinden-->
    <?php
        $servername = "localhost";
        $username = "root";
        $passwort = "";
        $datenbank = "bibershop";

        $conn = mysqli_connect($servername, $username, $passwort, $datenbank);
        if($conn->connect_error) {
            die ("es funktioniert nicht..." . $conn->connect_error);
        }
        echo "connected" . "<br>";

        $sql = "SELECT * FROM produkte";
        $result = $conn->query($sql);

        if($result->num_rows > 0) {
            while($i = $result->fetch_assoc()){
                echo "PID: " . $i["PID"] . "<br>" . "<h4>" .  "<i>Name:</i> " . $i["Pname"] . "</h4>"  .  "<i>Beschreibung: </i>" . $i["Pbeschreibung"] . "<br><br><br><br>" ;
            }
        }
        else{
            echo "kein Kunde gefunden" . $conn->error;
        }
        
        mysqli_close($conn);


    ?>

	<!-- Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.  

	Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.  

	Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.  

	Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. LoremLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.  

	Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.  

	Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.  

	Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem
-->
</div>





<div class="item" id="footer"> 
	<div id="footerinhalt"> © 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj  </div>  
</div>

<?php
/* $servername = "localhost";
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
	
mysqli_close($conn); */
?> 



<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="script.js"></script>
</body>
</html>
