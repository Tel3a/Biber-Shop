<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Kaufen</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 
<div class="container">
    <div class="form-box" id="registrieren-form">
        <!-- Seite mit DB verknüpfen -->
	    <?php
            require 'db_config.php';
            $error = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST["name"] ?? "";
                $email = $_POST["email"] ?? "";
                $passwort = $_POST["passwort"] ?? "";

                if (empty($name)) {
                    $error = "<h5>Ungültiger Name</h5>";
                }
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "<h5>Ungültige E-Mail</h5>";
                }
                elseif (empty($passwort)) {
                    $error = "<h5>Ungültiges Passwort</h5>";
                }
                else {
                    $obrichtigerUser = $conn->prepare('SELECT KID, Username, Email FROM Kunden WHERE Username = ? OR Email = ?');
                    $obrichtigerUser->bind_param('ss', $name, $email);
                    $obrichtigerUser->execute();
                    $result = $obrichtigerUser->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if ($row['Username'] == $name) {
                            $error = "<h5>Dieser Benutzername existiert bereits</h5>";
                        } else {
                            $error = "<h5>Diese E-Mail ist bereits registriert</h5>";
                        }
                    } else {
                        $pass_hash = password_hash($passwort, PASSWORD_DEFAULT);
                        $obrichtigerUser = $conn->prepare('INSERT INTO Kunden (Username, Email, Passwort) VALUES (?, ?, ?)');
                        $obrichtigerUser->bind_param('sss', $name, $email, $pass_hash);
                        if ($obrichtigerUser->execute()) {
                            header('Location: index.php');
                            exit();
                        } else {
                            $error = "<h5>Fehler bei der Registrierung. Bitte erneut versuchen.</h5>";
                        }
                    }
                    $obrichtigerUser->close();
                }
            }
        ?>
 
    	<h1>Registrieren</h1>
    	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method ="post">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="text" name="email" placeholder="Email" required><br>
            <input type="password" name="passwort" placeholder="Passwort" required><br>
            <button type="submit">Registrieren</button><br>
            <p>Schon ein Konto? <a href="login.php">Hier einloggen</a></p>
            <?php echo $error ?>

        </form>
    </div>
</div>
</body>
</html>
