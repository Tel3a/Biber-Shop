<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if (!isset($_SESSION['KID'])) {
    die("Error: Bitte einloggen, bevor du bestellst.");
}

$KID = (int) $_SESSION['KID'];
$WID = null;

require 'db_config.php';
$conn = get_db_connection();

$pinwarenkorb = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
$pinwarenkorb->bind_param("i", $KID);
$pinwarenkorb->execute();
$cartRow = $pinwarenkorb->get_result()->fetch_assoc();
$pinwarenkorb->close();
if ($cartRow && isset($cartRow['WID'])) {
    $WID = (int) $cartRow['WID'];
    $_SESSION['WID'] = $WID;
}

if ($WID === null) {
    die("Error: Kein aktiver Warenkorb gefunden.");
}

// Prüfen, ob KID in Session mit POST übereinstimmt
if ($KID !== (int) $_SESSION['KID']) {
    die("Error: Inkonsistente KID." . " Session KID: " . $_SESSION['KID'] . ", POST KID: " . $KID);
}

// Validieren, ob die WID zum eingeloggten Warenkorb gehört
$validCart = $conn->prepare("SELECT WID FROM warenkorb WHERE WID = ? AND KID = ? LIMIT 1");
$validCart->bind_param("ii", $WID, $KID);
$validCart->execute();
$validResult = $validCart->get_result();
if ($validResult->num_rows === 0) {
    die("Error: Ungültige Warenkorb-ID oder kein Warenkorb für diesen Benutzer.");
}
$validCart->close();

// Prüfen, ob bereits eine Bestellung für diesen Warenkorb existiert
$checkOrder = $conn->prepare("SELECT BID FROM bestellungen WHERE WID = ? LIMIT 1");
$checkOrder->bind_param("i", $WID);
$checkOrder->execute();
$checkOrderResult = $checkOrder->get_result();
if ($checkOrderResult->num_rows > 0) {
    die("Error: Für diesen Warenkorb wurde bereits eine Bestellung abgeschickt.");
}
$checkOrder->close();

// Prüfen, ob der Warenkorb noch Inhalte hat
$countCart = $conn->prepare("SELECT COUNT(*) AS anzahl FROM warenkorbinhalt WHERE WID = ?");
$countCart->bind_param("i", $WID);
$countCart->execute();
$countRow = $countCart->get_result()->fetch_assoc();
if (($countRow['anzahl'] ?? 0) === 0) {
    die("Error: Der Warenkorb ist leer.");
}
$countCart->close();

// Berechne den aktuellen Gesamtpreis serverseitig
$totalStmt = $conn->prepare(
    "SELECT SUM(p.Ppreis) AS gesamt FROM warenkorbinhalt w JOIN produkte p ON w.PID = p.PID WHERE w.WID = ?"
);
$totalStmt->bind_param("i", $WID);
$totalStmt->execute();
$totalRow = $totalStmt->get_result()->fetch_assoc();
$totalStmt->close();
$gesamt = (float) ($totalRow['gesamt'] ?? 0);

$stmt = $conn->prepare("INSERT INTO bestellungen (WID, KID, Datum, Bpreis) VALUES (?, ?, NOW(), ?)");
$stmt->bind_param("iid", $WID, $KID, $gesamt);
$stmt->execute();
$stmt->close();

// Direkt einen neuen Warenkorb für den Nutzer erstellen
$newCart = $conn->prepare("INSERT INTO warenkorb (KID) VALUES (?)");
$newCart->bind_param("i", $KID);
if ($newCart->execute()) {
    $_SESSION['WID'] = $conn->insert_id;
} else {
    error_log("Fehler bei neuer Warenkorb-Erstellung nach Bestellung: " . $newCart->error);
}
$newCart->close();

// Optional: Warenkorb nach Bestellung leeren
$del = $conn->prepare("DELETE FROM warenkorbinhalt WHERE WID = ?");
$del->bind_param("i", $WID);
$del->execute();
$del->close();

// Session-Warenkorb leeren
$_SESSION['warenkorb'] = [];

//header("Location: warenkorb.php");
$conn->close();
exit;
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
    <div class="bestell-kopf">
        <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['email'] ?? 'Gast') ?></span></h1>
        <p>Die Bestellung ist abgeschlossen</p>
    </div>

        <div class="warenkorb-aktionen">

            <form method="GET" action="allebestellungen.php">
                <input type="hidden" name="WID" value="<?= $WID ?>">
                <input type="hidden" name="KID" value="<?= $KID ?>">
                <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
                <button type="submit" name="allebestellungen">Alle Bestellungen anzeigen</button>
            </form>

            <button onclick="window.location.href='logout.php'">Abmelden</button>
        </div>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
