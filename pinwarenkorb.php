<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();
require 'db_config.php';
$conn = get_db_connection();

echo "pinwarenkorb.php geladen<br>";
echo "POST: ";
var_dump($_POST);
echo "<br>";

if (isset($_POST['PID'])) {
    echo "DEBUG: PID wurde gesendet: " . $_POST['PID'] . "<br>";
    $id = (int) $_POST['PID'];

    $stmt = $conn->prepare("SELECT Pname, Ppreis FROM produkte WHERE PID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $produkt = $stmt->get_result()->fetch_assoc();

    if (!$produkt) {
        die("DEBUG: Produkt nicht gefunden");
    }

    if (!isset($_SESSION['KID'])) {
        die("DEBUG: KID nicht in Session");
    }

    $KID = (int) $_SESSION['KID'];
    echo "DEBUG KID: $KID<br>";

    if (isset($_SESSION['WID'])) {
        $checkWID = $conn->prepare("SELECT WID FROM warenkorb WHERE WID = ? AND KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) LIMIT 1");
        $checkWID->bind_param("ii", $_SESSION['WID'], $KID);
        $checkWID->execute();
        $widResult = $checkWID->get_result();
        if ($widResult->num_rows === 0) {
            unset($_SESSION['WID']);
        }
        $checkWID->close();
    }

    if (!isset($_SESSION['WID'])) {
        $existingCart = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
        $existingCart->bind_param("i", $KID);
        $existingCart->execute();
        $existingRow = $existingCart->get_result()->fetch_assoc();
        $existingCart->close();
        if ($existingRow && isset($existingRow['WID'])) {
            $_SESSION['WID'] = (int) $existingRow['WID'];
        } else {
            $neuerw = $conn->prepare("INSERT INTO warenkorb (KID) VALUES (?)");
            $neuerw->bind_param("i", $KID);
            $neuerw->execute();
            $_SESSION['WID'] = $conn->insert_id;
            $neuerw->close();
        }
    }

    $WID = (int) $_SESSION['WID'];

    echo "DEBUG WID: $WID<br>";

    $peinfuegen = $conn->prepare("INSERT INTO warenkorbinhalt (PID, WID) VALUES (?, ?)");
    $peinfuegen->bind_param("ii", $id, $WID);
    $peinfuegen->execute();
    echo "DEBUG INSERT erfolgreich<br>";
    $peinfuegen->close();

    if (!isset($_SESSION['warenkorb'])) {
        $_SESSION['warenkorb'] = [];
    }
    $_SESSION['warenkorb'][] = [
        'PID' => $id,
        'Pname' => $produkt['Pname'],
        'Ppreis' => $produkt['Ppreis']
    ];
}

header("Location: warenkorb.php");
exit;
?>

