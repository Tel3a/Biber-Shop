<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if (!isset($_SESSION['KID'])) {
    header("Location: login.php");
    exit();
}

require 'db_config.php';
$conn = get_db_connection();

$KID = (int) $_SESSION['KID'];

$sql = "
    SELECT 
        bestellungen.BID,
        bestellungen.Datum,
        bestellungen.Bpreis,
        warenkorb.WID,
        warenkorbinhalt.PID,
        produkte.Pname,
        produkte.Ppreis
    FROM bestellungen
    JOIN warenkorb warenkorb ON bestellungen.WID = warenkorb.WID
    LEFT JOIN warenkorbinhalt warenkorbinhalt ON warenkorb.WID = warenkorbinhalt.WID
    LEFT JOIN produkte produkte ON warenkorbinhalt.PID = produkte.PID
    WHERE bestellungen.KID = ?
    ORDER BY bestellungen.Datum DESC, bestellungen.BID DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $KID);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];

while ($row = $result->fetch_assoc()) {
    $bid = (int)$row['BID'];

    if (!isset($orders[$bid])) {
        $orders[$bid] = [
            'Datum' => $row['Datum'],
            'WID' => (int)$row['WID'],
            'Bestellpreis' => (float) $row['Bpreis'],
            'items' => []
        ];
    }

    $orders[$bid]['items'][] = [
        'PID' => (int)$row['PID'],
        'Pname' => $row['Pname'],
        'Ppreis' => (float)$row['Ppreis'],
    ];
}
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Vergangene Bestellungen</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<div class="seiteninhalt">
<div class="warenkorbseite">
    <div class="warenkorb-kopf">
        <h1>Vergangene Bestellungen</h1>
    </div>
    <?php if (empty($orders)): ?>
        <div class="warenkorb-leer">
            <h2>Keine Bestellungen gefunden</h2>
            <p>Du hast noch keine Bestellungen aufgegeben.</p>
            <button onclick="window.location.href='kaufen.php'">Zum Shop</button>
        </div>
    <?php else: ?>
        <?php foreach ($orders as $bid => $order): ?>
            <?php $orderTotal = 0; ?>
            <div style="margin-bottom: 24px;">
                <div style="margin-bottom: 16px;">
                    <h2>Bestellung #<?= $bid ?></h2>
                    <p>Datum: <?= htmlspecialchars($order['Datum'] ?? '') ?></p>
                </div>

                <table class="warenkorb-tabelle">
                    <thead>
                        <tr>
                            <th>Produkt</th>
                            <th>Preis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <?php $orderTotal += (float) $item['Ppreis']; ?>
                            <tr>
                                <td><?= htmlspecialchars($item['Pname'] ?? 'Unbekannt') ?></td>
                                <td><?= number_format($item['Ppreis'], 2, ',', '.') ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="warenkorb-gesamt">
                            <td>Bestellsumme (inkl. Versand)</td>
                            <td><?= number_format($order['Bestellpreis'], 2, ',', '.') ?> €</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>

        <div class="warenkorb-aktionen">
            <button onclick="window.location.href='kaufen.php'">Weiter einkaufen</button>
            <button onclick="window.location.href='warenkorb.php'">Zum Warenkorb</button>
        </div>
    <?php endif; ?>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
