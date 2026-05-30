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
	    <?php
            $texttext = "Hallo! ";
            $error = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["name"])) {
                    $error = "<h5>" . "ungültiger Name" . "</h5>";
                }
                elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    $error = "<h5>" . "ungültige E-mail" . "</h5>";
                }
                elseif (empty($_POST["passwort"])) {
                    $error = "<h5>" . "ungültiges Passwort" . "</h5>";
                }
                else {
                    header("Location: index.php");
                    exit();
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