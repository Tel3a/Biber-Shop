<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if (!isset($_SESSION['KID'])) {
    die("Bitte zuerst einloggen.");
}

require 'db_config.php';
$conn = get_db_connection();

$KID = (int) $_SESSION['KID'];

$sql = "
    SELECT 
        bestellungen.BID,
        bestellungen.Datum,
        warenkorb.WID,
        warenkorbinhalt.PID,
        produkte.Pname,
        produkte.Ppreis
    FROM bestellungen
    JOIN warenkorb warenkorb ON bestellungen.WID = warenkorb.WID
    JOIN warenkorbinhalt warenkorbinhalt ON warenkorb.WID = warenkorbinhalt.WID
    JOIN produkte produkte ON warenkorbinhalt.PID = produkte.PID
    WHERE bestellungen.KID = ?
    ORDER BY bestellungen.Datum DESC, bestellungen.BID DESC, produkte.Pname ASC
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
            'items' => []
        ];
    }

    $orders[$bid]['items'][] = [
        'PID' => (int)$row['PID'],
        'Pname' => $row['Pname'],
        'Ppreis' => (float)$row['Ppreis'],
        'Pbild' => $row['Pbild'],
        'Menge' => (int)$row['Menge']
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
    <h1>Vergangene Bestellungen</h1>

    <?php if (empty($orders)): ?>
        <p>Es wurden noch keine Bestellungen gefunden.</p>
    <?php else: ?>
        <?php foreach ($orders as $bid => $order): ?>
            <section class="bestellung-block">
                <h2>Bestellung #<?= $bid ?></h2>
                <p>Datum: <?= htmlspecialchars($order['Datum']) ?></p>

                <div class="bestellartikel">
                    <?php foreach ($order['items'] as $item): ?>
                        <article class="bestellposition">
                            <img src="<?= htmlspecialchars($item['Pbild']) ?>" alt="<?= htmlspecialchars($item['Pname']) ?>">
                            <div>
                                <h3><?= htmlspecialchars($item['Pname']) ?></h3>
                                <p>Preis: <?= number_format($item['Ppreis'], 2, ',', '.') ?> €</p>
                                <p>Gesamt: <?= number_format($item['Ppreis'], 2, ',', '.') ?> €</p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>