<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    require_once 'db_config.php';
    $conn = get_db_connection();

    // Warenkorbanzahl mit Alias abfragen
    $sqlWarenkorb = "SELECT COUNT(Wposition) AS anzahl FROM warenkorbinhalt JOIN warenkorb ON warenkorbinhalt.WID = warenkorb.WID WHERE warenkorb.KID = ?";
    $anzahlinw = $conn->prepare($sqlWarenkorb);
    $anzahlinw->bind_param("i", $_SESSION['KID']);
    $anzahlinw->execute();
    $resultWarenkorb = $anzahlinw->get_result();
    $row = $resultWarenkorb->fetch_assoc();
    $warenkorbInhalt = $row['anzahl'] ?? 0;
    ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Warenkorb</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="menuband">
    <a id="logo" href="index.php"><img src="biber.svg" alt="Startseite"></a>
    <div class="menuoptionen">
        <a href="kaufen.php">Kaufen</a>
        <a href="login.php">Konto</a>
    </div>
    <a href="warenkorb.php">Warenkorb (<?= $warenkorbInhalt ?>)</a>
</div>

<div class="box">
    <br><br><br><br>
    <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['email'] ?? 'Gast') ?></span></h1>
    <p>Dies ist dein Warenkorb</p>

    <?php if ($warenkorbInhalt == 0): ?>
        <h2>Dein Warenkorb ist leer</h2>
        <p>Füge Produkte hinzu, um sie hier zu sehen!</p>
        <button onclick="window.location.href='kaufen.php'">Zum Shop</button>
    <?php else: ?>
        <h2>Hier sind deine Produkte:</h2>
        <?php
        $sql = "SELECT * FROM winhalt JOIN produkte ON winhalt.PID = produkte.PID WHERE winhalt.KID = ?";
        $winhalt = $conn->prepare($sql);
        $winhalt->bind_param("i", $_SESSION['KID']);
        $winhalt->execute();
        $result = $winhalt->get_result();

        while($i = $result->fetch_assoc()):
        ?>
            <p>PID: <?= $i["PID"] ?></p>
            <h4><i>Name:</i> <?= htmlspecialchars($i["Pname"]) ?></h4>
            <p><i>Preis:</i> <?= htmlspecialchars($i["Ppreis"]) ?> €</p>
        <?php endwhile;
        $conn->close();
        ?>
    <?php endif; ?>


    <button onclick="window.location.href='logout.php'">Abmelden</button>
</div>


</body>
</html>
