<?php
// User registration script
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    $errors = array();

    if (empty($fullname)) {
        $errors[] = 'Full name is required';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    }

    if (empty($username) || strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters';
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match';
    }

    // Check if username already exists
    $check_username = $conn->prepare('SELECT id FROM members WHERE username = ?');
    $check_username->bind_param('s', $username);
    $check_username->execute();
    $check_username->store_result();

    if ($check_username->num_rows > 0) {
        $errors[] = 'Username already exists';
    }
    $check_username->close();

    // Check if email already exists
    $check_email = $conn->prepare('SELECT id FROM members WHERE email = ?');
    $check_email->bind_param('s', $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        $errors[] = 'Email already registered';
    }
    $check_email->close();

    // If no errors, register the user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $registration_date = date('Y-m-d H:i:s');

        $stmt = $conn->prepare('INSERT INTO members (fullname, email, phone, username, password, registration_date) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $fullname, $email, $phone, $username, $hashed_password, $registration_date);

        if ($stmt->execute()) {
            $_SESSION['success'] = 'Registration successful! Please log in.';
            header('Location: ../login.html');
            exit();
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
    }
}

// Redirect back to registration page with error message if any
header('Location: ../register.html');
exit();

?>