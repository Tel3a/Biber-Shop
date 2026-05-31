<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Produktdetails</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
 <div class="menuband">
	<a id="logo" href="index.php"><img src="house.png" alt="Startseite" ></a>
	<div menuoptionen> <a  href="kaufen.php">Kaufen</a>
	<a href="login.php">Login</a> </div>
</div>

<div class="seiteninhalt">



<div class="detailfotos"> 
	<img src="shampoo.jpg" alt="photo1">
	<img src="shampoo2.jpg" alt="photo1">
	<img src="shampoo3.jpg" alt="photo1">
</div> 
<div class="alleeinzelprodukte">
	<h3>Name des Produkts</h3>
	<p>10,00 €</p>
	<button type="submit">In den Warenkorb</button>
	<p>Beschreibung des Produkts</p>
</div>


</div>


<?php 
        require 'db_config.php';
        $servername = "localhost";
        $username = "root";
        $passwort = "";
        $datenbank = "bibershop";

        $conn = mysqli_connect($servername, $username, $passwort, $datenbank);
        if($conn->connect_error) {
            die ("es funktioniert nicht..." . $conn->connect_error);
        }
        /*echo "connected" . "<br>";*/

        $sql = "SELECT * FROM produkte";
        $result = $conn->query($sql);
        while ($i = $result->fetch_assoc()):
            ?>
            <a class="boxen" href="produktdetails.php?pid=<?= $i['PID'] ?>">
            <!--<img src="<?= htmlspecialchars($i['Pbild']) ?>" alt="<?= htmlspecialchars($i['Pname']) ?>">-->
            <h4><?= htmlspecialchars($i['Pname']) ?></h4>
            <!--<p><?= htmlspecialchars($i['Pbeschreibung']) ?></p>-->
            </a>
    <?php endwhile; 
        mysqli_close($conn);
    ?>


</div>


<div class="item" id="footer"> 
	<div id="footerinhalt"> © 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj  </div>  
</div>







</body>
</html>

