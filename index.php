<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}
// Show login success message if set
if (isset($_SESSION['login_success'])) {
    echo '<div class="login-success-msg">Login successful! Redirecting to dashboard...</div>';
    unset($_SESSION['login_success']);
    echo '<script>setTimeout(function(){ window.location.href = "dashboard.php"; }, 1500);</script>';
}
// Show login error if set
if (isset($_SESSION['login_error'])) {
    echo '<div id="loginError" class="login-error-msg">'.$_SESSION['login_error'].'</div>';
    unset($_SESSION['login_error']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: url('uploads/index.jpg') no-repeat center center fixed; background-size: cover;">
<div class="container-flex">
    <div class="login-box">
        <h2>Admin Login</h2>
        <form action="auth.php" method="POST" id="loginForm" onsubmit="return validateLogin();">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#00796b" viewBox="0 0 24 24"><path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7 12-7 12-7-4.367-7-12-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5zm0-8c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3z"/></svg>
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#00796b" viewBox="0 0 24 24" style="display:none;"><path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7c2.042 0 3.885-.293 5.5-.793l-1.5-1.5c-1.19.188-2.44.293-4 .293-5.523 0-9.5-4.477-9.5-4.477s3.977-4.477 9.5-4.477c1.56 0 2.81.105 4 .293l1.5-1.5c-1.615-.5-3.458-.793-5.5-.793zm10.293 2.293l-18 18 1.414 1.414 18-18-1.414-1.414z"/></svg>
                </span>
            </div>
            <button type="submit">Login</button>
            <div class="login-forgot-link">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>
        </form>
    </div>
    <div class="left-panel left-panel-margin">
        <!-- Title removed as requested -->
    </div>
</div>
<script src="js/main.js"></script>
<script>
function validateLogin() {
    var username = document.getElementById('username').value.trim();
    var password = document.getElementById('password').value.trim();
    var errorDiv = document.getElementById('loginError');
    if (username === '' || password === '') {
        if (errorDiv) errorDiv.innerText = 'Username and password are required!';
        else alert('Username and password are required!');
        return false;
    }
    if (password.length < 4) {
        if (errorDiv) errorDiv.innerText = 'Password must be at least 4 characters!';
        else alert('Password must be at least 4 characters!');
        return false;
    }
    return true;
}
</script>
</body>
</html>
