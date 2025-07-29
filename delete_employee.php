<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Get photo filename to delete from uploads
    $stmt = $conn->prepare('SELECT photo FROM employees WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($photo);
    $stmt->fetch();
    $stmt->close();
    // Delete employee
    $stmt = $conn->prepare('DELETE FROM employees WHERE id = ?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        // Delete photo file if exists
        if ($photo && file_exists('uploads/' . $photo)) {
            unlink('uploads/' . $photo);
        }
        header('Location: employees.php?msg=Employee+deleted+successfully');
        exit();
    } else {
        header('Location: employees.php?error=Unable+to+delete+employee');
        exit();
    }
} else {
    header('Location: employees.php');
    exit();
}
