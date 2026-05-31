<?php
    function get_db_connection(): mysqli {
        static $conn = null;
        if ($conn === null) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "bibershop";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) die('DB-Fehler: '.$conn->connect_error);
            $conn->set_charset('utf8mb4');
        }
        return $conn;
    }
?>
