<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare('SELECT * FROM admin WHERE username = ? AND password = MD5(?)');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $_SESSION['admin'] = $username;
        $_SESSION['login_success'] = true;
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['login_error'] = 'Invalid username or password!';
        header('Location: index.php');
        exit();
    }
}
else {
    header('Location: index.php');
    exit();
}
?>
