<?php
// Session handling and header file
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

?>