<?php
// API endpoint to get user information
include 'config.php';
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Not logged in'
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Prepare and execute query
$stmt = $conn->prepare('SELECT fullname, email, phone, registration_date FROM members WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'fullname' => $user['fullname'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'registration_date' => $user['registration_date']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'User not found'
    ]);
}

$stmt->close();
$conn->close();
?>