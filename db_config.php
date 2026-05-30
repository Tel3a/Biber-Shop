<?php
$conn = new mysqli('localhost','root','','Bibershop');
if ($conn->connect_error) die('DB-Fehler: '.$conn->connect_error);
$conn->set_charset('utf8mb4');
?>