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

}

$widStmt->close();

// Session-Warenkorb leeren
$_SESSION['warenkorb'] = [];

header("Location: warenkorb.php");
exit;
?>
