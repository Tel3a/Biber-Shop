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

<div class="warenkorbseite">
    <div class="warenkorb-kopf">
        <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['email'] ?? 'Gast') ?></span></h1>
        <p>Dies ist dein Warenkorb</p>
    </div>

    <?php if ($warenkorbInhalt == 0): ?>
        <div class="warenkorb-leer">
            <h2>Dein Warenkorb ist leer</h2>
            <p>Füge Produkte hinzu, um sie hier zu sehen!</p>
            <button onclick="window.location.href='kaufen.php'">Zum Shop</button>
        </div>
    <?php else: ?>
        <h2>Hier sind deine Produkte:</h2>

        <?php if ($warenkorb): ?>
            <table class="warenkorb-tabelle">
                <tr>
                    <th>Produkt</th>
                    <th>Preis</th>
                </tr>
                <?php foreach ($warenkorb as $id => $item):
                    $subtotal = $item['Ppreis'];
                    $gesamt += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['Pname']) ?></td>
                        <td><?= number_format($item['Ppreis'], 2, ',', '.') ?> €</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="warenkorb-gesamt">
                    <td>Gesamtpreis</td>
                    <td><?= number_format($gesamt, 2, ',', '.') ?> €</td>
                </tr>
            </table>
        <?php else: ?>
            <div class="warenkorb-leer">
                <p>Dein Warenkorb ist leer.</p>
            </div>
        <?php endif; ?>

        <p><a href="kaufen.php">Weiter einkaufen</a></p>

        <div class="warenkorb-aktionen">
            <form method="GET" action="bestellen.php">
                <input type="hidden" name="WID" value="<?= $WID ?>">
                <input type="hidden" name="KID" value="<?= $KID ?>">
                <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
                <button type="submit" name="bestellen">Bestellen</button>
            </form>

            <form method="POST" action="warenkorbleeren.php">
                <button type="submit">Warenkorb leeren</button>
            </form>

            <form method="GET" action="allebestellungen.php">
                <input type="hidden" name="WID" value="<?= $WID ?>">
                <input type="hidden" name="KID" value="<?= $KID ?>">
                <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
                <button type="submit" name="allebestellungen">Alle Bestellungen anzeigen</button>
            </form>

            <button onclick="window.location.href='logout.php'">Abmelden</button>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
