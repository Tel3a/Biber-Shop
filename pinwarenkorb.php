<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();
require 'db_config.php';
$conn = get_db_connection();

// Debug output 
// echo "pinwarenkorb.php geladen<br>";
// echo "POST: "; var_dump($_POST); echo "<br>";

if (isset($_POST['PID'])) {
    $id = (int) $_POST['PID'];

    $stmt = $conn->prepare("SELECT Pname, Ppreis FROM produkte WHERE PID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $produkt = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$produkt) {
        die("DEBUG: Produkt nicht gefunden");
    }

    // Gast erlaubt, KID NULL bis Anmeldung
    $KID = isset($_SESSION['KID']) ? (int) $_SESSION['KID'] : null;

    // Prüfe vorhandene Session-WID nur auf aktive Warenkörbe
    if (isset($_SESSION['WID'])) {
        $checkWID = $conn->prepare("SELECT WID FROM warenkorb WHERE WID = ? AND WID NOT IN (SELECT WID FROM bestellungen) LIMIT 1");
        $checkWID->bind_param("i", $_SESSION['WID']);
        $checkWID->execute();
        $widResult = $checkWID->get_result();
        if ($widResult->num_rows === 0) {
            unset($_SESSION['WID']);
        }
        $checkWID->close();
    }

    if (!isset($_SESSION['WID'])) {
        if ($KID !== null) {
            $existW = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
            $existW->bind_param("i", $KID);
            $existW->execute();
            $existRow = $existW->get_result()->fetch_assoc();
            $existW->close();
            if ($existRow && isset($existRow['WID'])) {
                $_SESSION['WID'] = (int) $existRow['WID'];
            }
        }
    }

    if (!isset($_SESSION['WID'])) {
        if ($KID === null) {
            $res = $conn->query("INSERT INTO warenkorb (KID) VALUES (NULL)");
            if ($res === false) {
                die("DB-Error: " . $conn->error);
            }
            $_SESSION['WID'] = $conn->insert_id;
        } else {
            $neuerw = $conn->prepare("INSERT INTO warenkorb (KID) VALUES (?)");
            $neuerw->bind_param("i", $KID);
            $neuerw->execute();
            $_SESSION['WID'] = $conn->insert_id;
            $neuerw->close();
        }
    }

    $WID = (int) $_SESSION['WID'];

    $peinfuegen = $conn->prepare("INSERT INTO warenkorbinhalt (PID, WID) VALUES (?, ?)");
    $peinfuegen->bind_param("ii", $id, $WID);
    $peinfuegen->execute();
    $peinfuegen->close();

    $_SESSION['warenkorb'] = $_SESSION['warenkorb'] ?? [];
    $_SESSION['warenkorb'][] = [
        'PID' => $id,
        'Pname' => $produkt['Pname'],
        'Ppreis' => $produkt['Ppreis'],
    ];
}

header("Location: warenkorb.php");
exit;
?>
