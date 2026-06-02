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
                $PID = urlencode($row['PID']);
                $img = htmlspecialchars($row['Pbild']);
                $alt = htmlspecialchars($row['Pname']);
                echo '<a class="galleriefoto" href="produktdetails.php?PID='.$PID.'"><img src="'.$img.'" alt="'.$alt.'"></a>';
            }
        }
        mysqli_close($conn);
    }
    ?>
	</div>
	<a class="zumShop dunklerbutton" href="kaufen.php">Zum Shop</a>

	<br><br><br>
	
	
	<h1>Willkommen bei <i>Biber Bedarf</i></h1>
    <h4>Dem Bibershop ihres Vertrauens</h4> 
    <p>Wir lieben Biber — und genau deshalb haben wir diesen Shop gegründet. </p>
    <p>Bei <i>Biber Bedarf</i> findest du alles rund um den Biber: von wichtigen Produkten bis hin Dienstleistungen von Bibern bei uns gibt es alles.
    <p>Unsere Idee entstand aus der Begeisterung für diese faszinierenden Tiere und dem Wunsch, einen Ort zu schaffen wo jeder Biber sich woll fühlt.</p>
    <p>Dabei achten wir auf:</p>
    <p>- gute Qualität</p>
    <p>- faire Preise</p>
    <p>- einfache Bestellung</p>
    <p>- freundlichen Service</p>
    <p>Egal ob du nach einem Produkt für einen Biber suchst oder nach einer Dienstleistung von einem Biber — bei Biber Bedarf bist du genau richtig.</p>
    Vielen Dank für deinen Besuch und viel Spaß beim Stöbern!
    — Das Team von <i>Biber Bedarf</i> </p>
</div>


<?php include 'footer.php'; ?>
</body>
</html>
