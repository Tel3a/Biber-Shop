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

    $warenkorb = $_SESSION['warenkorb'] ?? [];
    $gesamt = 0;
?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Warenkorb</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
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
        $sql = "SELECT * FROM warenkorbinhalt JOIN produkte ON warenkorbinhalt.PID = produkte.PID WHERE warenkorbinhalt.WID = ?";
        $winhalt = $conn->prepare($sql);
        $winhalt->bind_param("i", $_SESSION['WID']);
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

<!-- Warenkorbinhaltsliste -->
<h1>Warenkorb</h1>
<?php if ($warenkorb): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Produkt</th><th>Preis</th><th>Subtotal</th>
        </tr>
        <?php foreach ($warenkorb as $id => $item): 
            $subtotal = $item['Ppreis'];
            $gesamt += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['Pname']) ?></td>
            <td>$<?= number_format($item['Ppreis'], 2) ?></td>
            <td>$<?= number_format($subtotal, 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Gesamtpreis</strong></td>
            <td><strong>$<?= number_format($gesamt, 2) ?></strong></td>
        </tr>
    </table>
<?php else: ?>
    <p>Dein Warenkorb ist leer.</p>
<?php endif; ?>



<p><a href="kaufen.php">Weiter einkaufen</a></p>
    <!-- Bestell-Button -->
    <form method="GET" action="bestellen.php">
        <input type="hidden" name="WID" value="<?= $WID ?>">
        <input type="hidden" name="KID" value="<?= $KID ?>">
        <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
        <button type="submit" name="bestellen">Bestellen</button>
</form>
<!-- Warenkorb leeren Button -->
<form method="POST" action="warenkorbleeren.php">
    <button type="submit" >Warenkorb leeren</button>
</form>
<form method="GET" action="allebestellungen.php">
    <input type="hidden" name="WID" value="<?= $WID ?>">
    <input type="hidden" name="KID" value="<?= $KID ?>">
    <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
    <button type="submit" name="allebestellungen">Alle Bestellungen anzeigen</button>
</form>
    <button onclick="window.location.href='logout.php'">Abmelden</button>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
