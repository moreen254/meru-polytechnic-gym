<?php
// Dashboard backend script
include 'config.php';
include 'header.php';

// Check if user is logged in
if (!$isLoggedIn) {
    header('Location: login.html');
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT fullname, email, phone, registration_date FROM members WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

?>