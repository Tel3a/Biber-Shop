<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Kaufen</title>
  <link href="style.css" rel="stylesheet">
</head>

<body> 
 <div class="menuband">
	<div id="logo"> 
		<a href="index.php"><img src="house.png" alt="Startseite" ></a>
	</div>
	<a class="menuoptionen" href="kaufen.php">Kaufen</a>
	<a class="menuoptionen" href="login.php">Login</a>
</div>


<div class="pfeil"> <a href="login.php"> <b>↑</b> </a></div>

<div class="login">
	<?php
        $texttext = "Hallo! ";
        $error = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["name"])) {
                $error = "ungültiger Name";
            }
            elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $error = "ungültige E-mail";
            }
            else {
                echo "<h1> Hallo " . $_POST["name"] . ", viel Spaß beim Kaufen! </h1>";
                echo "<h3> Liebe/r " . $_POST["name"] . ", deine Emailadresse lautet:" . $_POST["email"] . "</h3>";
            }
        }
    ?>
 
	<h1>Login</h1>
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method ="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <?php echo $error ?>
        <input type="submit">
    </form>
</div>
          
<div class="item" id="footer"> 
			<div id="footerinhalt"><br>© 2026 Jamie-Lee Jones, Telsa Schaurer, Sophie Gorqaj <br> <br> 	<a href="Impressum.html">IMPRESSUM</a> <br>  </div>
</div>


</body>
</html>
