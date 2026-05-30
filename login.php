<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Kaufen</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 

<div class ="container">
    <div class="form-box" id="login-form">
	    <?php
            $texttext = "Hallo! ";
            $error = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
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
 
    	<h1>Login</h1>
    	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method ="post">
            <input type="text" name="email" placeholder="Email" required><br>
            <input type="password" name="passwort" placeholder="Passwort" required><br>
            <button type="submit">Login</button><br>
            <p>Noch kein Konto? <a href="registrieren.php">Hier registrieren</a></p>
            <?php echo $error ?>

        </form>
    </div>
    
</div>

<!--
<div class="item" id="footer"> 
			<div id="footerinhalt"><br>© 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj <br> <br> 	<a href="Impressum.html">IMPRESSUM</a> <br>  </div>
</div>
-->

</body>
</html>
