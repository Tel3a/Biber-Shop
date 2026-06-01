<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if (!isset($_SESSION['KID'])) {
    $_SESSION['post_login_redirect'] = 'bestellen.php';
    header('Location: login.php');
    exit();
}

require 'db_config.php';
$conn = get_db_connection();

$KID = (int) $_SESSION['KID'];
$bestellungserfolgreich = false;
$bestellungsid = null;
$bestellungspreis = null;
$bestellungsdatum = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bestellen'])) {

    // Aktiven Warenkorb finden
    $pinwarenkorb = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
    $pinwarenkorb->bind_param("i", $KID);
    $pinwarenkorb->execute();
    $cartRow = $pinwarenkorb->get_result()->fetch_assoc();
    $pinwarenkorb->close();

    if (!$cartRow || !isset($cartRow['WID'])) {
        $error = "Kein aktiver Warenkorb gefunden.";
    } else {
        $WID = (int) $cartRow['WID'];
        $_SESSION['WID'] = $WID;

        // ob warenkorb gültig
        $validatew = $conn->prepare("SELECT WID FROM warenkorb WHERE WID = ? AND KID = ? LIMIT 1");
        $validatew->bind_param("ii", $WID, $KID);
        $validatew->execute();
        if ($validatew->get_result()->num_rows === 0) {
            $error = "Ungültige Warenkorb-ID oder kein Warenkorb für diesen Benutzer.";
        }
        $validatew->close();

        if (!$error) {
            // Warenkorb-Inhalt prüfen
            $countCart = $conn->prepare("SELECT COUNT(*) AS anzahl FROM warenkorbinhalt WHERE WID = ?");
            $countCart->bind_param("i", $WID);
            $countCart->execute();
            $countRow = $countCart->get_result()->fetch_assoc();
            if (($countRow['anzahl'] ?? 0) === 0) {
                $error = "Der Warenkorb ist leer.";
            }
            $countCart->close();
        }

        if (!$error) {
            // Berechne Gesamtpreis
            $gesamtStmt = $conn->prepare(
                "SELECT SUM(p.Ppreis) AS gesamt FROM warenkorbinhalt w JOIN produkte p ON w.PID = p.PID WHERE w.WID = ?"
            );
            $gesamtStmt->bind_param("i", $WID);
            $gesamtStmt->execute();
            $gesamtRow = $gesamtStmt->get_result()->fetch_assoc();
            $gesamtStmt->close();
            $gesamt = (float) ($gesamtRow['gesamt'] ?? 0);

            // Bestellung erstellen
            $stmt = $conn->prepare("INSERT INTO bestellungen (WID, KID, Datum, Bpreis) VALUES (?, ?, NOW(), ?)");
            $stmt->bind_param("iid", $WID, $KID, $gesamt);
            $stmt->execute();
            $bestellungsid = $conn->insert_id;
            $bestellungspreis = $gesamt;
            $stmt->close();

            // Neuen Warenkorb erstellen
            $neuwarenkorb = $conn->prepare("INSERT INTO warenkorb (KID) VALUES (?)");
            $neuwarenkorb->bind_param("i", $KID);
            $neuwarenkorb->execute();
            $_SESSION['WID'] = $conn->insert_id;
            $neuwarenkorb->close();

            // Warenkorbinhalt beibehalten (nicht löschen) - bleibt als Archiv der Bestellung erhalten
            // Session-Warenkorb leeren (UI-Cache), die DB-Positionen bleiben erhalten
            $_SESSION['warenkorb'] = [];
            $bestellungserfolgreich = true;
            $bestellungsdatum = date('d.m.Y H:i:s');
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Bestellung</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<div class="seiteninhalt">
<img src="dankebiber.png" alt="Danke Biber" class="dankebiber">
<div class="container">
    <?php if ($bestellungserfolgreich): ?>
        <div class="erfolgsseite">
            <h1>✓ Bestellung erfolgreich!</h1>
            <div class="bestellungsdetails">
                <p><strong>Bestellungs-ID:</strong> <?= htmlspecialchars($bestellungsid) ?></p>
                <p><strong>Gesamtpreis:</strong> <?= number_format($bestellungspreis, 2, ',', '.') ?> €</p>
                <p><strong>Bestelldatum:</strong> <?= htmlspecialchars($bestellungsdatum) ?></p>
            </div>
            <div class="bestellungsaktionen">
                <button onclick="window.location.href='kaufen.php'">Weiter einkaufen</button>
                <button onclick="window.location.href='allebestellungen.php'">Meine Bestellungen</button>
                <button onclick="window.location.href='warenkorb.php'">Zum Warenkorb</button>
                <button onclick="window.location.href='logout.php'">Abmelden</button>
            </div>
        </div>
    <?php elseif ($error): ?>
        <div class="fehlerseite">
            <h1>✗ Fehler</h1>
            <p><?= htmlspecialchars($error) ?></p>
            <button onclick="window.location.href='warenkorb.php'">Zurück zum Warenkorb</button>
        </div>
    <?php else: ?>
        <div class="seite-leer">
            <p>Um die Bestellung abzuschließe, gehen Sie zum Warenkorb.</p>
            <button onclick="window.location.href='warenkorb.php'">Zum Warenkorb</button>
        </div>
    <?php endif; ?>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
