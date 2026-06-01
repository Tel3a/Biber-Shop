<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'db_config.php';
$conn = get_db_connection();

$istangemeldet = isset($_SESSION['email']);
$error = "";

// Nur Login-Verarbeitung wenn nicht angemeldet
if (!$istangemeldet && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["emailorusername"] ?? "";
    $username = $_POST["emailorusername"] ?? "";
    $passwort = $_POST["passwort"] ?? "";

    if (empty($email)) {
        $error = "<h5>Ungültiger Benutzername oder E-Mail</h5>";
    }
    elseif (empty($passwort)) {
        $error = "<h5>Ungültiges Passwort</h5>";
    } else {
        $obrichtigerUser = $conn->prepare('SELECT KID, Username, Passwort FROM Kunden WHERE Email = ? OR Username = ?');
        $obrichtigerUser->bind_param('ss', $email, $username);
        $obrichtigerUser->execute();
        $row = $obrichtigerUser->get_result()->fetch_assoc();

        if ($row && password_verify($passwort, $row['Passwort'])) {
            $_SESSION['KID'] = $row['KID'];
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $row['Username'];
            
            // Wenn anonymer Warenkorb, dann KID
            if (isset($_SESSION['WID'])) {
                $WIDzuweisen = $conn->prepare("UPDATE warenkorb SET KID = ? WHERE WID = ? AND (KID IS NULL OR KID = 0)");
                $WIDzuweisen->bind_param("ii", $_SESSION['KID'], $_SESSION['WID']);
                $WIDzuweisen->execute();
                $WIDzuweisen->close();
            }
            
            // Warenkorb weiternutzen oder neu erstellen
            $check = $conn->prepare("SELECT WID FROM warenkorb WHERE KID = ? AND WID NOT IN (SELECT WID FROM bestellungen) ORDER BY WID DESC LIMIT 1");
            $check->bind_param("i", $_SESSION['KID']);
            $check->execute();
            $res = $check->get_result()->fetch_assoc();
            $check->close();

            if ($res && isset($res['WID'])) {
                $_SESSION['WID'] = (int) $res['WID'];
            } else {
                $werstellen = $conn->prepare("INSERT INTO warenkorb (KID) VALUES (?)");
                $werstellen->bind_param("i", $_SESSION['KID']);
                if ($werstellen->execute()) {
                    $_SESSION['WID'] = $conn->insert_id;
                } else {
                    error_log("Fehler bei Warenkorb-Erstellung: " . $werstellen->error);
                }
                $werstellen->close();
            }
            
            // Weiterleiten zur entsprechenden Seite
            $redirectTarget = $_SESSION['post_login_redirect'] ?? 'index.php';
            unset($_SESSION['post_login_redirect']);

            header('Location: ' . $redirectTarget);
            exit();
        } else {
            $error = "<h5>E-Mail oder Passwort falsch</h5>";
        }
        $obrichtigerUser->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 
<?php include 'header.php'; ?>
<div class="container">
    <div class="form-box" id="login-form">
        <?php if ($istangemeldet): ?>
            <!-- Willkommensseite für angemeldete Nutzer -->
        <h1>Willkommen, <span><?= htmlspecialchars($_SESSION['name'] ?? $_SESSION['email'] ?? 'Gast') ?></span></h1>
            <div class="warenkorb-kopf">
                <p>Du bist bereits angemeldet.</p>
                <div class="warenkorb-aktionen">
                    <button onclick="window.location.href='index.php'">Zur Startseite</button>
                    <button onclick="window.location.href='kaufen.php'">Zum Shop</button>
                    <button onclick="window.location.href='warenkorb.php'">Zum Warenkorb</button>
                    <button onclick="window.location.href='allebestellungen.php'">Meine Bestellungen</button>
                    <button onclick="window.location.href='logout.php'">Abmelden</button>
                </div>
            </div>
        <?php else: ?>
            <!-- Login-Formular für nicht angemeldete Nutzer -->
            <h1>Login</h1>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="text" name="emailorusername" placeholder="E-Mail oder Benutzername" required><br>
                <input type="password" name="passwort" placeholder="Passwort" required><br>
                <button type="submit">Anmelden</button><br>
                <p>Noch kein Konto? <a href="registrieren.php">Hier registrieren</a></p>
                <?php echo $error ?>
            </form>
        <?php endif; ?>
    </div>
</div>


<?php include 'footer.php'; ?>

</body>
</html>
