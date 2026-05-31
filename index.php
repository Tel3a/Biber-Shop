<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Mein Biber Webshop</title>
  <link href="style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
</head>

<body> 



<?php include 'header.php'; ?>


<div class="seiteninhalt"> 

	<div class="fotogallerie"
	data-flickity-options='{ "wrapAround": true }'>
    <?php
    $servername = "localhost";
    $username = "root";
    $passwort = "";
    $datenbank = "bibershop";

    $conn = mysqli_connect($servername, $username, $passwort, $datenbank);
    if($conn && !$conn->connect_error) {
        $sql = "SELECT PID, Pbild, Pname FROM produkte WHERE PID=7 OR PID=3 OR PID=102";
        $result = $conn->query($sql);
        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pid = urlencode($row['PID']);
                $img = htmlspecialchars($row['Pbild']);
                $alt = htmlspecialchars($row['Pname']);
                echo '<a class="galleriefoto" href="produktdetails.php?pid='.$pid.'"><img src="'.$img.'" alt="'.$alt.'"></a>';
            }
        }
        mysqli_close($conn);
    }
    ?>
	</div>
	<a class="zumShop" href="kaufen.php">Zum Shop</a>

	<br><br><br>
	
	<h1>Shop und Produkte für Biber</h1> 
	<h1>Willkommen auf dieser Seite!!</h1>

	<!-- Datenbanken einbinden 
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
-->
</div>


<?php include 'footer.php'; ?>

<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="script.js"></script>
</body>
</html>
