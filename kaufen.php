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




<!--
 was ist eine sektion?
<section class="product-gallery">
  <div class="filters">
    <button data-filter="all">Alle</button>
    <button data-filter="shirts">Shirts</button>
    <button data-filter="shoes">Schuhe</button>
  </div>

  <div class="grid" id="productGrid">
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
-->

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
        while ($i = $result->fetch_assoc()):
            ?>
            <div class="boxen"><a href="produktdetails.php?pid=<?= $i['PID'] ?>">
            <img src="<?= htmlspecialchars($i['Pbild']) ?>" alt="kein Bild verfügbar">
            <p><?= htmlspecialchars($i['Pname']) ?></p>
            </a>
            <button> In den Warenkorb</button> 
            </div>  
            
    <?php endwhile; 
        mysqli_close($conn);
    ?>
</div>
<!--	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1 <br> <button> 
      In den Warenkorb</button> </a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
</div>
  -->

</div>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="script.js"></script>


<?php include 'footer.php'; ?>

</body>
</html>
