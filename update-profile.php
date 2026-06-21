<?php
// Update profile page
include 'php/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Get current user info
$stmt = $conn->prepare('SELECT fullname, email, phone FROM members WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validation
    $errors = [];
    if (empty($fullname)) $errors[] = 'Full name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($phone)) $errors[] = 'Phone number is required';

    if (empty($errors)) {
        $update_stmt = $conn->prepare('UPDATE members SET fullname = ?, email = ?, phone = ? WHERE id = ?');
        $update_stmt->bind_param('sssi', $fullname, $email, $phone, $user_id);
        
        if ($update_stmt->execute()) {
            $_SESSION['fullname'] = $fullname;
            $message = '<div class="success-message">Profile updated successfully!</div>';
            $user['fullname'] = $fullname;
            $user['email'] = $email;
            $user['phone'] = $phone;
        } else {
            $message = '<div class="error-message">Failed to update profile</div>';
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
    <title>Update Profile - Meru National Polytechnic Gym</title>
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
            <h2>Update Your Profile</h2>
            <?php echo $message; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>

                <button type="submit" class="btn-primary">Update Profile</button>
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