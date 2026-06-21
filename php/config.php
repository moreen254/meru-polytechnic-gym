<?php
// Database configuration file

// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'gym_management');

// Create connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die('Connection Error: ' . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset('utf8');

?>