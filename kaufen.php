<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Kaufen</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 


 <div class="menuband">
	<a id="logo" href="index.php"><img src="house.png" alt="Startseite" ></a>
	<div menuoptionen> <a  href="kaufen.php">Kaufen</a>
	<a href="login.php">Login</a> </div>
</div>

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
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
	<a class="boxen" href="produktdetails.php"><img src="shampoo.jpg" alt="photo1"> test1</a>
</div>




</div>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="script.js"></script>


<div class="item" id="footer"> 
			<div id="footerinhalt"><br>© 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj <br> <br> 	<a href="Impressum.html">IMPRESSUM</a> <br>  </div>
</div>

</body>
</html>