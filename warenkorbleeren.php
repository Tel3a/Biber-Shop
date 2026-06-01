<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

require 'db_config.php';
$conn = get_db_connection();

$WID = null;
if (isset($_SESSION['KID'])) {
    $KID = (int) $_SESSION['KID'];
    $widStmt = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
    $widStmt->bind_param("i", $KID);
    $widStmt->execute();
    $widRes = $widStmt->get_result();
    if ($widRes->num_rows > 0) {
        $row = $widRes->fetch_assoc();
        $WID = (int) $row['WID'];
    }
    $widStmt->close();
} elseif (isset($_SESSION['WID'])) {
    // Gast WID zuweisen
    $WID = (int) $_SESSION['WID'];
}

if ($WID !== null) {
    $delStmt = $conn->prepare("DELETE FROM warenkorbinhalt WHERE WID = ?");
    $delStmt->bind_param("i", $WID);
    $delStmt->execute();
    $delStmt->close();
}

// Session-Warenkorb leeren
$_SESSION['warenkorb'] = [];

header("Location: warenkorb.php");
exit;
?>
