<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Employees';
include 'includes/header.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM employees WHERE id=$id");
    header('Location: employees.php');
    exit();
}

// Fetch all employees
$result = $conn->query('SELECT * FROM employees ORDER BY id ASC');
?>
<div class="dashboard-container">
    <h2 class="dashboard-title">All Employees</h2>
    <div style="text-align:right;margin-bottom:15px;">
        <a href="add_employee.php" class="dashboard-link" style="background:#00796b;color:#fff;padding:8px 16px;border-radius:5px;">+ Add Employee</a>
    </div>
    <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#e0f7fa;">
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Join Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php if ($row['photo']): ?><img src="<?php echo $row['photo']; ?>" alt="Photo" style="width:40px;height:40px;border-radius:50%;object-fit:cover;"><?php endif; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['gender']); ?></td>
                <td><?php echo htmlspecialchars($row['department']); ?></td>
                <td><?php echo htmlspecialchars($row['designation']); ?></td>
                <td>₹<?php echo number_format($row['salary'],2); ?></td>
                <td><?php echo htmlspecialchars($row['join_date']); ?></td>
                <td>
                    <a href="edit_employee.php?id=<?php echo $row['id']; ?>" style="color:#00796b;">Edit</a> |
                    <a href="employees.php?delete=<?php echo $row['id']; ?>" style="color:#d32f2f;" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
