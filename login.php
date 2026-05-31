<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Kaufen</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 
<?php include 'header.php'; ?>
<div class ="container">
    <div class="form-box" id="login-form">
	    <?php
            require 'db_config.php';
            $conn = get_db_connection();
            session_start();
            // Überprüfen, ob der Benutzer bereits eingeloggt ist
            if (isset($_SESSION['email'])) {
                header("Location: index.php");
                exit();
            }

            $error = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["emailorusername"] ?? "";
                $username = $_POST["emailorusername"] ?? "";
                $passwort = $_POST["passwort"] ?? "";

                if (empty($email)) {
                    $error = "<h5>Ungültiger Benutzername oder E-Mail</h5>";
                }
                elseif (empty($passwort)) {
                    $error = "<h5>Ungültiges Passwort</h5>";
                } else {
                    $obrichtigerUser = $conn->prepare('SELECT KID, Username, Passwort FROM Kunden WHERE Email = ? OR Username = ?'); //prepare schützt vor Hacking
                    $obrichtigerUser->bind_param('ss', $email, $username); // bind_param schützt vor Hacking
                    $obrichtigerUser->execute();
                    $row = $obrichtigerUser->get_result()->fetch_assoc();

                    if ($row && password_verify($passwort, $row['Passwort'])) {
                        $_SESSION['KID'] = $row['KID'];
                        $_SESSION['email'] = $email;
                        $_SESSION['name'] = $row['Username'];
                    // Warenkorb für den Kunden erstellen
                    $werstellen = $conn->prepare("INSERT INTO warenkorb (KID) VALUES (?)");
                    $werstellen->bind_param("i", $_SESSION['KID']);
                    
                    if ($werstellen->execute()) {

                    } else {
                        // Fehler bei Warenkorb-Erstellung loggingn, aber Login trotzdem zulassen
                        error_log("Fehler bei Warenkorb-Erstellung: " . $werstellen->error);
                    }
                    $werstellen->close();


                        header('Location: index.php');
                        exit();
                    } else {
                        $error = "<h5>E-Mail oder Passwort falsch</h5>";
                    }
                    $obrichtigerUser->close();
                }
            }
        ?>
 
    	<h1>Login</h1>
    	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method ="post">
            <input type="text" name="emailorusername" placeholder="E-Mail oder Benutzername" required><br>
            <input type="password" name="passwort" placeholder="Passwort" required><br>
            <button type="submit">Anmelden</button><br>
            <p>Noch kein Konto? <a href="registrieren.php">Hier registrieren</a></p>
            <?php echo $error ?>

        </form>
    </div>
    
</div>


<?php include 'footer.php'; ?>

</body>
</html>
