<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Departments';
include 'includes/header.php';

// Handle add department
$success = '';
$error = '';
if (isset($_POST['add_department'])) {
    $name = trim($_POST['department_name']);
    if (strlen($name) < 2) {
        $error = 'Department name must be at least 2 characters.';
    } else {
        $stmt = $conn->prepare('INSERT INTO departments (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        if ($stmt->execute()) {
            $success = 'Department added!';
        } else {
            $error = 'Error adding department.';
        }
    }
}
// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM departments WHERE id=$id");
    header('Location: departments.php');
    exit();
}
// Fetch all departments
$result = $conn->query('SELECT * FROM departments ORDER BY id ASC');
?>
<div class="dashboard-container">
    <h2 class="dashboard-title">Departments</h2>
    <?php if ($success): ?><div style="color:green;text-align:center;">✔ <?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;text-align:center;">✖ <?php echo $error; ?></div><?php endif; ?>
    <form method="POST" style="margin-bottom:20px;text-align:center;">
        <input type="text" name="department_name" placeholder="New Department Name" required style="padding:8px;width:220px;">
        <button type="submit" name="add_department" style="padding:8px 16px;background:#00796b;color:#fff;border:none;border-radius:5px;">Add Department</button>
    </form>
    <div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#e0f7fa;">
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>
                    <a href="departments.php?delete=<?php echo $row['id']; ?>" style="color:#d32f2f;" onclick="return confirm('Delete this department?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
