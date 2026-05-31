<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
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

<div class="box">
    <h1> Willkommen, <span> <?= $_SESSION['name']; ?> </span> </h1>
    <p> Dies ist dein Warenkorb </p>
    <button onclick="window.location.href='logout.php'"> Logout </button>
</div>







</body>
</html>
