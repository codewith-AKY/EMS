<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Admin Dashboard';
include 'includes/header.php';

// Get total employees
$emp_result = $conn->query('SELECT COUNT(*) as total FROM employees');
$total_employees = $emp_result ? $emp_result->fetch_assoc()['total'] : 0;

// Get total departments
$dept_result = $conn->query('SELECT COUNT(*) as total FROM departments');
$total_departments = $dept_result ? $dept_result->fetch_assoc()['total'] : 0;

// Get total leave requests
$leave_result = $conn->query('SELECT COUNT(*) as total FROM leaves');
$total_leaves = $leave_result ? $leave_result->fetch_assoc()['total'] : 0;

// Get total salaries paid
$salary_result = $conn->query('SELECT SUM(amount) as total FROM salaries');
$total_salaries = $salary_result ? $salary_result->fetch_assoc()['total'] : 0;
?>
    <div class="dashboard-container">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">Total Employees</div>
                <div class="stat-value"><?php echo $total_employees; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Departments</div>
                <div class="stat-value"><?php echo $total_departments; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Leave Requests</div>
                <div class="stat-value"><?php echo $total_leaves; ?></div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Salaries Paid</div>
                <div class="stat-value">₹<?php echo number_format($total_salaries, 2); ?></div>
            </div>
        </div>

    </div>
<?php include 'includes/footer.php'; ?>
