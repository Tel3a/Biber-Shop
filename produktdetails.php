<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Produktdetails</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<?php include 'header.php'; ?>
<div class="seiteninhalt">


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

		$PID = isset($_GET['PID']) ? (int)$_GET['PID'] : 0;
		if ($PID > 0) {
			$sql = "SELECT * FROM produkte WHERE PID = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("i", $PID);
			$stmt->execute();
			$result = $stmt->get_result();
        }


       
	while ($i = $result->fetch_assoc()): ?>
    <div class="produktdetails">
        <div class="detailfotos">
            <img src="<?= htmlspecialchars($i['Pbild']) ?>" alt="<?= htmlspecialchars($i['Pname']) ?>">
        </div>

        <div class="produktinfos">
            <h4><?= htmlspecialchars($i['Pname']) ?></h4>
            <div class="produktpreis"><?= htmlspecialchars($i['Ppreis']) ?> €</div>
            <p><?= htmlspecialchars($i['Pbeschreibung']) ?></p>

            <form method="POST" action="pinwarenkorb.php">
                <input type="hidden" name="PID" value="<?= (int)$i['PID'] ?>">
                <button type="submit">In den Warenkorb</button>
            </form>
        </div>
    </div>
    <?php endwhile; ?>

    <p><a href="warenkorb.php">Warenkorb ansehen</a></p><br>
	<?php 
        mysqli_close($conn);
    ?>


</div>


<?php include 'footer.php'; ?>

</body>
</html>
