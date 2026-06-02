<?php
    session_start();


    require_once 'db_config.php';
    $conn = get_db_connection();

    // WID und KID aus Session holen
    $WID = $_SESSION['WID'] ?? null;
    $KID = $_SESSION['KID'] ?? null;
    $warenkorb = [];
    $gesamt = 0;
    $warenkorbInhalt = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['PID'])) {
        $action = $_POST['action'];
        $pid = (int) $_POST['PID'];

        if ($WID !== null && in_array($action, ['increment', 'decrement'], true)) {
            if ($action === 'increment') {
                $addStmt = $conn->prepare("INSERT INTO warenkorbinhalt (PID, WID) VALUES (?, ?)");
                $addStmt->bind_param("ii", $pid, $WID);
                $addStmt->execute();
                $addStmt->close();
            } else {
                $removeStmt = $conn->prepare("DELETE FROM warenkorbinhalt WHERE WID = ? AND PID = ? LIMIT 1");
                $removeStmt->bind_param("ii", $WID, $pid);
                $removeStmt->execute();
                $removeStmt->close();
            }
        }

        header('Location: warenkorb.php');
        exit();
    }

    if ($WID !== null) {
        if ($KID !== null) {
            $validate = $conn->prepare("SELECT WID FROM warenkorb WHERE WID = ? AND KID = ? AND WID NOT IN (SELECT WID FROM bestellungen)");
            $validate->bind_param("ii", $WID, $KID);
        } else {
            $validate = $conn->prepare("SELECT WID FROM warenkorb WHERE WID = ? AND KID IS NULL AND WID NOT IN (SELECT WID FROM bestellungen)");
            $validate->bind_param("i", $WID);
        }
        $validate->execute();
        $validRes = $validate->get_result();
        if ($validRes->num_rows === 0) {
            unset($_SESSION['WID']);
            $WID = null;
        }
        $validate->close();
    }

    if ($WID === null && $KID !== null) {
        $widStmt = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
        $widStmt->bind_param("i", $KID);
        $widStmt->execute();
        $row = $widStmt->get_result()->fetch_assoc();
        if ($row && isset($row['WID'])) {
            $WID = (int) $row['WID'];
            $_SESSION['WID'] = $WID;
        }
        $widStmt->close();
    }

    if ($WID !== null) {
        $countStmt = $conn->prepare("SELECT COUNT(Wposition) AS anzahl FROM warenkorbinhalt WHERE WID = ?");
        $countStmt->bind_param("i", $WID);
        $countStmt->execute();
        $row = $countStmt->get_result()->fetch_assoc();
        $warenkorbInhalt = $row['anzahl'] ?? 0;
        $countStmt->close();

        if ($warenkorbInhalt > 0) {
            if (!isset($_SESSION['versandkosten'])) {
                $_SESSION['versandkosten'] = rand(1, 100);
            }

            $contentStmt = $conn->prepare(
                "SELECT produkte.PID, produkte.Pname, produkte.Ppreis, COUNT(*) AS Menge
                 FROM warenkorbinhalt 
                 JOIN produkte ON warenkorbinhalt.PID = produkte.PID
                 WHERE warenkorbinhalt.WID = ?
                 GROUP BY produkte.PID, produkte.Pname, produkte.Ppreis"
            );
            $contentStmt->bind_param("i", $WID);
            $contentStmt->execute();
            $result = $contentStmt->get_result();
            while ($item = $result->fetch_assoc()) {
                $warenkorb[] = [
                    'PID' => (int) $item['PID'],
                    'Pname' => $item['Pname'],
                    'Ppreis' => (float) $item['Ppreis'],
                    'Menge' => (int) $item['Menge'],
                ];
            }
            $contentStmt->close();
        } else {
            unset($_SESSION['versandkosten']);
        }
    }

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
<div class="seiteninhalt">
<div class="warenkorbseite">
    <div class="warenkorb-kopf">
        <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['email'] ?? 'Gast') ?></span></h1>
        <p>Dies ist dein Warenkorb</p>
    </div>

    <?php if ($warenkorbInhalt == 0): ?>
        <div class="warenkorb-leer">
            <h2>Dein Warenkorb ist leer</h2>
            <p>Willst du dich bei unseren Produkten umsehen?</p>
            <button onclick="window.location.href='kaufen.php'">Zum Shop</button>
            
            <form method="GET" action="allebestellungen.php">
                <input type="hidden" name="WID" value="<?= $WID ?>">
                <input type="hidden" name="KID" value="<?= $KID ?>">
                <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
                <button type="submit" name="allebestellungen">Bisherige Bestellungen anzeigen</button>
            </form>

            <a href="login.php">Anmelden</a>
        </div>
    <?php else: ?>
        <h2>Hier sind deine Produkte:</h2>

        <?php if ($warenkorb): ?>
            <table class="warenkorb-tabelle">
                <tr>
                    <th>Produkt</th>
                    <th>Einzelpreis</th>
                    <th>Menge</th>
                    <th>Preis für Menge</th>
                </tr>
                <?php foreach ($warenkorb as $id => $item):
                    $positionTotal = $item['Ppreis'] * $item['Menge'];
                    $gesamt += $positionTotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['Pname']) ?></td>
                        <td><?= number_format($item['Ppreis'], 2, ',', '.') ?> €</td>
                        <td>
                            <form method="post" class="quantity-form">
                                <input type="hidden" name="PID" value="<?= $item['PID'] ?>">
                                <button type="submit" name="action" value="decrement">−</button>
                                <span class="quantity-value"><?= $item['Menge'] ?></span>
                                <button type="submit" name="action" value="increment">+</button>
                            </form>
                        </td>
                        <td><?= number_format($positionTotal, 2, ',', '.') ?> €</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="warenkorb-gesamt">
                    <td colspan="3">Versandkosten</td>
                    <td><?= number_format($_SESSION['versandkosten'] ?? 0, 2, ',', '.') ?> €</td>
                </tr>
                <?php $gesamt += ($_SESSION['versandkosten'] ?? 0); ?>
                <tr class="warenkorb-gesamt">
                    <td colspan="3">Gesamtpreis</td>
                    <td><?= number_format($gesamt, 2, ',', '.') ?> €</td>
                </tr>
            </table>
        <?php else: ?>
            <div class="warenkorb-leer">
                <p>Dein Warenkorb ist leer.</p>
            </div>
            <p><a class="einkaufbutton" href="kaufen.php">Weiter einkaufen</a></p>

        <?php endif; ?>

        <p><a href="kaufen.php">Weiter einkaufen</a></p>
        <!-- macht das einen Unterschied?
            <p><a class="einkaufbutton" href="kaufen.php">Weiter einkaufen</a></p>
        -->
        <div class="warenkorb-aktionen">
            <form method="POST" action="bestellen.php">
                <button type="submit" name="bestellen">Bestellen (<?= number_format($gesamt, 2, ',', '.') ?> €)</button>
            </form>



            <form method="POST" action="warenkorbleeren.php">
                <button type="submit">Warenkorb leeren</button>
            </form>

            <form method="GET" action="allebestellungen.php">
                <input type="hidden" name="WID" value="<?= $WID ?>">
                <input type="hidden" name="KID" value="<?= $KID ?>">
                <input type="hidden" name="gesamt" value="<?= $gesamt ?>">
                <button type="submit" name="allebestellungen">Bisherige Bestellungen anzeigen</button>
            </form>

            <button onclick="window.location.href='logout.php'">Abmelden</button>
        </div>
    <?php endif; ?>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
