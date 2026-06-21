// Main JavaScript file for Meru National Polytechnic Gym Website

// Form validation for registration
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fullname = document.getElementById('fullname').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        // Validation
        if (!fullname) {
            alert('Please enter your full name');
            return;
        }

        if (!email || !isValidEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }

        if (!phone || phone.length < 10) {
            alert('Please enter a valid phone number');
            return;
        }

        if (!username || username.length < 3) {
            alert('Username must be at least 3 characters long');
            return;
        }

        if (!password || password.length < 6) {
            alert('Password must be at least 6 characters long');
            return;
        }

        if (password !== confirmPassword) {
            alert('Passwords do not match');
            return;
        }

        // If validation passes, submit the form
        registerForm.submit();
    });
}

// Form validation for login
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;

        if (!username) {
            alert('Please enter your username');
            return;
        }

        if (!password) {
            alert('Please enter your password');
            return;
        }

        loginForm.submit();
    });
}

// Email validation function
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Load member info on dashboard
function loadMemberInfo() {
    // This will be populated by the PHP backend
    const memberInfo = document.getElementById('memberInfo');
    if (memberInfo) {
        // Placeholder for member data from PHP
        console.log('Member info loaded');
    }
}

// On page load
document.addEventListener('DOMContentLoaded', function() {
    loadMemberInfo();
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});