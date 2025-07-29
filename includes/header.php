<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) session_start();
$company_name = 'AK Tech Solution';
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo isset($page_title) ? $page_title . ' | ' . $company_name : $company_name; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <span class="header-title"><?php echo $company_name; ?></span>
            <?php if (isset($_SESSION['admin'])): ?>
                <nav class="header-nav">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="employees.php">Employees</a>
                    <a href="departments.php">Departments</a>
                    <a href="designations.php">Designations</a>
                    <a href="salary.php">Salaries</a>
                    <a href="leave.php">Leave Requests</a>
                    <a href="logout.php" style="color:#d32f2f;">Logout</a>
                </nav>
            <?php endif; ?>
        </div>
    </header>
    <main class="main-content">
