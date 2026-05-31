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
	<a id="logo" href="index.php"><img src="biber.svg" alt="Startseite" ></a>
	<div menuoptionen> <a  href="kaufen.php">Kaufen</a>
	<a href="login.php">Konto</a> </div>
	<a href="warenkorb.php">Warenkorb</a>
</div>




<div class="seiteninhalt"> 

	<div class="fotogallerie"
	data-flickity-options='{ "wrapAround": true }'>
	<!-- <div class="galleriefoto"><p class="cursor typewriter-animation">Hallo einsamer Biber! Schön, dass du da bist! </p> </div> -->
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
</div>





<div class="item" id="footer"> 
	<div id="footerinhalt"> 
        <h4>KONTAKT</h4>
        <p>Telefon: +49 123 456 789</p>
        <p>Email: info@bibershop.de</p>
        © 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj  </div>  
</div>

	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="script.js"></script>
</body>
</html>
