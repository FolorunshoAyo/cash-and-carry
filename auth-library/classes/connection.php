<?php
    date_default_timezone_set("Africa/Lagos");
    
    $server_name = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $db_name = $_ENV['DB_NAME'];

    $db = $conn = new mysqli($server_name, $username, $password, $db_name);
    if ($db) {
       //echo "Connected Successfully!"; 
    }else{
        echo "DB error: " . $db->connect_error;
    }
?>