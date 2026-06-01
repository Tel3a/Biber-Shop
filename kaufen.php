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
-->
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

        // Prüfe ob Art-Spalte existiert, wenn nicht, erstelle sie
        $check_art = $conn->query("SHOW COLUMNS FROM produkte LIKE 'Art'");
        if ($check_art->num_rows == 0) {
            $conn->query("ALTER TABLE produkte ADD COLUMN Art VARCHAR(50) DEFAULT 'Sonstiges'");
            // Kategorisiere Produkte
            $categorize = [
                "UPDATE produkte SET Art = 'Pflege' WHERE PID IN (1,2,3,4)",
                "UPDATE produkte SET Art = 'Kleidung' WHERE PID IN (5,6,7)",
                "UPDATE produkte SET Art = 'Lebensmittel' WHERE PID = 8",
                "UPDATE produkte SET Art = 'Werkzeuge' WHERE PID = 9",
                "UPDATE produkte SET Art = 'Services' WHERE PID IN (101,102,103,104,105)"
            ];
            foreach ($categorize as $sql) {
                $conn->query($sql);
            }
        }

        // Hole Filter aus URL-Parameter
        $filter_art = isset($_GET['art']) ? $conn->real_escape_string($_GET['art']) : '';
        
        // SQL mit optionalem Filter
        if ($filter_art) {
            $sql = "SELECT * FROM produkte WHERE Art = '$filter_art'";
        } else {
            $sql = "SELECT * FROM produkte";
        }
        
        // Hole alle verfügbaren Art-Kategorien
        $art_result = $conn->query("SELECT DISTINCT Art FROM produkte ORDER BY Art");
        $kategorien = [];
        while ($row = $art_result->fetch_assoc()) {
            $kategorien[] = $row['Art'];
        }
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

<!-- Filter-Buttons -->
<div class="filter-buttons">
    <a href="kaufen.php" class="filter-btn <?= !$filter_art ? 'active' : '' ?>">Alle Produkte</a>
    <?php foreach ($kategorien as $kat): ?>
        <a href="kaufen.php?art=<?= urlencode($kat) ?>" class="filter-btn <?= $filter_art === $kat ? 'active' : '' ?>">
            <?= htmlspecialchars($kat) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- button für in den Warenkorb hinzufügen -->
<!-- <h1>Product List</h1>-->

<?php $result = $conn->query($sql); ?>

<?php while ($row = $result->fetch_assoc()): ?>
    <article class="boxen">
        <a href="produktdetails.php?PID=<?= (int)$row['PID'] ?>">
          <img src="<?= htmlspecialchars($row['Pbild']) ?>" alt="<?= htmlspecialchars($row['Pname']) ?>">

        <div class="produktinfo">
            <h3><?= htmlspecialchars($row['Pname']) ?></h3>
            <p><?= number_format((float)$row['Ppreis'], 2, ',', '.') ?> €</p>
        </div>
        </a>
        <form method="POST" action="pinwarenkorb.php">
            <input type="hidden" name="PID" value="<?= (int)$row['PID'] ?>">
            <button type="submit">In den Warenkorb</button>
        </form>
    </article>
<?php endwhile; ?>

</div>
<p><a href="warenkorb.php">Warenkorb ansehen</a></p><br>

<!-- Datenbank wieder schließen -->
        <?php mysqli_close($conn);
    ?>
</div>



<?php include 'footer.php'; ?>

</body>
</html>
