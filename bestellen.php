<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

//prüfen, ob WID in Session existiert
$WID = $_SESSION['WID'] ?? null;
if ($WID === null) {
    die("Error: WID ist nicht in der Session gespeichert.");
}


if (!isset($_SESSION['KID'])) {
    die("Error: Bitte einloggen, bevor du bestellst.");
}

if (!isset($_POST['WID'], $_SESSION['KID'], $_POST['gesamt'])) {
    die("Error: Fehlende Daten für Bestellung.");
}

require 'db_config.php';
$conn = get_db_connection();

$WID = (int) $_POST['WID'];
$KID = (int) $_SESSION['KID'];
$gesamt = (float) $_POST['gesamt'];

// Prüfen, ob KID in Session mit POST übereinstimmt
if ($KID !== (int) $_SESSION['KID']) {
    die("Error: Inkonsistente KID." . " Session KID: " . $_SESSION['KID'] . ", POST KID: " . $KID);
}

// Bestellung einfügen
$stmt = $conn->prepare("INSERT INTO bestellungen (WID, KID, Datum) VALUES (?, ?, NOW())");
$stmt->bind_param("ii", $WID, $KID);
$stmt->execute();
$stmt->close();

// Optional: Warenkorb nach Bestellung leeren
$del = $conn->prepare("DELETE FROM warenkorbinhalt WHERE WID = ?");
$del->bind_param("i", $WID);
$del->execute();
$del->close();

// Session-Warenkorb leeren
$_SESSION['warenkorb'] = [];

header("Location: waren.korb.php");
$wid->close();
exit;
?>