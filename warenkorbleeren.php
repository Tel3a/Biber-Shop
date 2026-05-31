<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if (!isset($_SESSION['KID'])) {
    die("Error: Bitte einloggen, bevor du den Warenkorb leerst.");
}

require 'db_config.php';
$conn = get_db_connection();

$KID = (int) $_SESSION['KID'];

// WID holen
$widStmt = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ?");
$widStmt->bind_param("i", $KID);
$widStmt->execute();
$widRes = $widStmt->get_result();

if ($widRes->num_rows > 0) {
    $row = $widRes->fetch_assoc();
    $WID = (int) $row['WID'];

    // Alle Inhalte des Warenkorbs löschen
    $delStmt = $conn->prepare("DELETE FROM warenkorbinhalt WHERE WID = ?");
    $delStmt->bind_param("i", $WID);
    $delStmt->execute();
    $delStmt->close();

    // Optional: Warenkorb-Tabelle selbst auch leeren (falls du nur 1 Wareneintrag pro Kunde hast)
    // Wenn du den Warenkorb mit WID behalten willst, lass diesen Teil weg:
    $delWk = $conn->prepare("DELETE FROM warenkorb WHERE WID = ?");
    $delWk->bind_param("i", $WID);
    $delWk->execute();
    $delWk->close();
}

$widStmt->close();

// Session-Warenkorb leeren
$_SESSION['warenkorb'] = [];

header("Location: warenkorb.php");
exit;