<?php
// Change password page
include 'php/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    $errors = [];

    // Get current password
    $stmt = $conn->prepare('SELECT password FROM members WHERE id = ?');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        $errors[] = 'Current password is incorrect';
    }

    if (empty($new_password) || strlen($new_password) < 6) {
        $errors[] = 'New password must be at least 6 characters';
    }

    if ($new_password !== $confirm_password) {
        $errors[] = 'Passwords do not match';
    }

    if (empty($errors)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare('UPDATE members SET password = ? WHERE id = ?');
        $update_stmt->bind_param('si', $hashed_password, $user_id);
        
        if ($update_stmt->execute()) {
            $message = '<div class="success-message">Password changed successfully!</div>';
        } else {
            $message = '<div class="error-message">Failed to change password</div>';
        }
        $update_stmt->close();
    } else {
        $message = '<div class="error-message">' . implode('<br>', $errors) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Meru National Polytechnic Gym</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">MNPG - Gym</div>
            <ul class="nav-menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="dashboard-page.php">Dashboard</a></li>
                <li><a href="php/logout.php" class="btn-register">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="form-container">
        <div class="form-box">
            <h2>Change Your Password</h2>
            <?php echo $message; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn-primary">Change Password</button>
                <a href="dashboard-page.php" class="btn-link">Back to Dashboard</a>
            </form>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Meru National Polytechnic Gym. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>