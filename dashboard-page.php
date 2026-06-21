<?php
// Dashboard page with session validation
include 'php/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Meru National Polytechnic Gym</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">MNPG - Gym</div>
            <ul class="nav-menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="dashboard-page.php" class="active">Dashboard</a></li>
                <li><a href="php/logout.php" class="btn-register">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="container">
            <h1>Welcome to Your Dashboard</h1>
            <div id="errorMessage" class="error-message" style="display:none;"></div>
            <div id="successMessage" class="success-message" style="display:none;"></div>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>👤 My Profile</h3>
                    <div id="memberInfo">
                        <p><strong>Name:</strong> <span id="displayName"><?php echo htmlspecialchars($fullname); ?></span></p>
                        <p><strong>Username:</strong> <span id="displayUsername"><?php echo htmlspecialchars($username); ?></span></p>
                        <p><strong>Email:</strong> <span id="displayEmail">Loading...</span></p>
                        <p><strong>Phone:</strong> <span id="displayPhone">Loading...</span></p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <h3>💪 Membership Status</h3>
                    <p>Status: <strong id="memberStatus">Active</strong></p>
                    <p>Join Date: <span id="joinDate">Loading...</span></p>
                    <p>Member ID: <strong><?php echo $user_id; ?></strong></p>
                </div>

                <div class="dashboard-card">
                    <h3>📞 Contact Support</h3>
                    <p>Email: gym@mnp.ac.ke</p>
                    <p>Phone: +254-XXX-XXXXXX</p>
                    <p>Hours: Mon-Fri 6AM-10PM</p>
                </div>

                <div class="dashboard-card">
                    <h3>⚙️ Settings</h3>
                    <a href="update-profile.php" class="btn-link">Update Profile</a>
                    <a href="change-password.php" class="btn-link">Change Password</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Meru National Polytechnic Gym. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Load user data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadUserData();
        });

        function loadUserData() {
            fetch('php/get-user-info.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update HTML elements with user data
                        document.getElementById('displayEmail').textContent = data.email;
                        document.getElementById('displayPhone').textContent = data.phone;
                        document.getElementById('joinDate').textContent = formatDate(data.registration_date);
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error loading user data:', error);
                    showError('Failed to load user information');
                });
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }

        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            successDiv.textContent = message;
            successDiv.style.display = 'block';
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>