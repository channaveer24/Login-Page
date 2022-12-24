<?php

define('DB_SERVER', 'localhost'); // DEFINES THE hostname or Server IP
define('DB_USERNAME', 'root'); // DEFINES db user name 
define('DB_PASSWORD','');
define('DB_NAME', 'log');

// Try connecting to the database:
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // MySQLI HERE 'I' IS IMPROVED  VERSION OF MYSQL

// Check the connection;
if($conn == false) {
    die('Error: Cannot Connect');
}

?>