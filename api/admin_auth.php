<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    $_SESSION['login_error'] = "Username and password required.";
    header("Location: ../admin_login.php");
    exit;
}

// Hardcoded admin credentials
// (For production, replace with DB check and hashed passwords)
if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = $username;

    header("Location: ../admin.php");
    exit;
} else {
    $_SESSION['login_error'] = "Invalid username or password.";
    header("Location: ../admin_login.php");
    exit;
}
