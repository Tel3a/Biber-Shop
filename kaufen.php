<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Kaufen</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 


<?php include 'header.php'; ?>

<div class="seiteninhalt">


<?php
$products = [
  ["name" => "T-Shirt", "category" => "shirts", "image" => "img/shirt1.jpg", "price" => "19,90 €"],
  ["name" => "Sneaker", "category" => "shoes", "image" => "img/shoe1.jpg", "price" => "49,90 €"]
];

foreach ($products as $p) {
  echo '<article class="product-boxen" data-category="'.$p["category"].'">';
  echo '<a href="'.$p["image"].'" class="open-lightbox">';
  echo '<img src="'.$p["image"].'" alt="'.$p["name"].'">';
  echo '</a>';
  echo '<h3>'.$p["name"].'</h3>';
  echo '<p>'.$p["price"].'</p>';
  echo '</article>';
}
?>
  </div>
</section>

<div class="lightbox" id="lightbox" hidden>
  <button id="closeLightbox">×</button>
  <img id="lightboxImg" src="" alt="">
</div>


<div id="produktgallerie"> 
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

        /* für jedes Produkt eine Box mit Bild, Name und Warenkorb Button */
        /*while ($i = $result->fetch_assoc()):
            ?>
            <a class="boxen" href="produktdetails.php?pid=<?= $i['PID'] ?>">
            <img src="<?= htmlspecialchars($i['Pbild']) ?>" alt="kein Bild verfügbar">
            <p><?= htmlspecialchars($i['Pname']) ?></p>
            </a>
            <button onclick="addToCart(<?= $i['PID'] ?>)">In den Warenkorb</button>
        <?php endwhile; ?>
        */ ?>

<!-- button für in den Warenkorb hinzufügen -->
<h1>Product List</h1>
<?php while ($row = $result->fetch_assoc()): ?>
    <div>
        <h3><?= htmlspecialchars($row['Pname']) ?></h3>
        <p>Preis: $<?= number_format($row['Ppreis'], 2) ?></p>
        <form method="POST" action="oinwarenkorb.php">
            <input type="hidden" name="PID" value="<?= $row['PID'] ?>">
            <button type="submit">add to cart</button>
        </form>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br>

<?php endwhile; ?>

<p><a href="warenkorb.php">Warenkorb ansehen</a></p>

<!-- Datenbank wieder schließen -->
        <?php mysqli_close($conn);
    ?>
</div>



<!--
<?php
    require_once 'db_config.php';
    $conn = get_db_connection();

    $pid = isset($_GET['pid']) ? (int)$_GET['pid'] : 0;
		if ($pid > 0) {}
			  $sql = "INSERT INTO whinhalt (PID, WID) VALUES (?, ?)" ;
			  $stmt = $conn->prepare($sql);
			  $stmt->bind_param("i", $pid);
			  $stmt->execute();
			  $result = $stmt->get_result();
            if ($result) {
                echo "Produkt zum Warenkorb hinzugefügt!";
            } else {
                echo "Fehler beim Hinzufügen zum Warenkorb: " . $conn->error;
            }

?>
-->

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="script.js"></script>


<div class="item" id="footer"> 
			<div id="footerinhalt"><br>© 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj <br> <br> 	<a href="Impressum.html">IMPRESSUM</a> <br>  </div>
</div>

</body>
</html>
