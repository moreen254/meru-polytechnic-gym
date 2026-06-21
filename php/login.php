<?php
// User login script
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validation
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username and password are required';
        header('Location: ../login.html');
        exit();
    }

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare('SELECT id, username, password, fullname, email, phone FROM members WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['success'] = 'Login successful!';

            // Redirect to dashboard
            header('Location: ../dashboard-page.php');
            exit();
        } else {
            $_SESSION['error'] = 'Invalid password';
        }
    } else {
        $_SESSION['error'] = 'Username not found';
    }

    $stmt->close();
}

// Redirect back to login page
header('Location: ../login.html');
exit();
?>