<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Salaries';
include 'includes/header.php';

// Handle add salary
$success = '';
$error = '';
if (isset($_POST['add_salary'])) {
    $employee_id = intval($_POST['employee_id']);
    $amount = floatval($_POST['amount']);
    $paid_date = $_POST['paid_date'];
    if ($employee_id <= 0 || $amount <= 0 || empty($paid_date)) {
        $error = 'All fields are required and must be valid.';
    } else {
        $stmt = $conn->prepare('INSERT INTO salaries (employee_id, amount, paid_date) VALUES (?, ?, ?)');
        $stmt->bind_param('ids', $employee_id, $amount, $paid_date);
        if ($stmt->execute()) {
            $success = 'Salary record added!';
        } else {
            $error = 'Error adding salary.';
        }
    }
}
// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM salaries WHERE id=$id");
    header('Location: salary.php');
    exit();
}
// Fetch all salaries
$salaries = $conn->query('SELECT s.*, e.name FROM salaries s LEFT JOIN employees e ON s.employee_id = e.id ORDER BY s.id ASC');
// Fetch employees for dropdown
$employees = $conn->query('SELECT id, name FROM employees');
?>
<div class="dashboard-container">
    <h2 class="dashboard-title">Salaries</h2>
    <?php if ($success): ?><div style="color:green;text-align:center;">✔ <?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;text-align:center;">✖ <?php echo $error; ?></div><?php endif; ?>
    <form method="POST" style="margin-bottom:20px;text-align:center;">
        <select name="employee_id" required style="padding:8px;width:180px;">
            <option value="">Select Employee</option>
            <?php while($row = $employees->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="amount" placeholder="Amount" step="0.01" min="0" required style="padding:8px;width:120px;">
        <input type="date" name="paid_date" required style="padding:8px;width:140px;">
        <button type="submit" name="add_salary" style="padding:8px 16px;background:#00796b;color:#fff;border:none;border-radius:5px;">Add Salary</button>
    </form>
    <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#e0f7fa;">
                <th>ID</th>
                <th>Employee</th>
                <th>Amount</th>
                <th>Paid Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $salaries->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>₹<?php echo number_format($row['amount'],2); ?></td>
                <td><?php echo htmlspecialchars($row['paid_date']); ?></td>
                <td>
                    <a href="salary.php?delete=<?php echo $row['id']; ?>" style="color:#d32f2f;" onclick="return confirm('Delete this salary record?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
