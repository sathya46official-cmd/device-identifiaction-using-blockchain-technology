<?php
session_start();
// If already logged in, go straight to admin panel
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Device DID System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 0;
        }
        .login-container h1 {
            color: #333;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 2.2em;
            font-weight: 600;
            text-align: center;
            border: 2px solid rgba(102, 126, 234, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .error-message {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
            border-left: 4px solid #dc3545;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-top: 15px;
        }
        .success-message {
            color: #28a745;
            background: rgba(40, 167, 69, 0.1);
            border-left: 4px solid #28a745;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            margin-top: 15px;
        }
        .back-link {
            color: #333;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            display: inline-block;
            border: 2px solid rgba(102, 126, 234, 0.2);
        }
        .back-link:hover {
            color: #667eea;
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>
        <form class="login-form" method="POST" action="api/admin_auth.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div id="message">
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
                unset($_SESSION['login_error']);
            }
            ?>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="index.html" class="back-link">← Back to Main</a>
        </div>
    </div>
</body>
</html>
