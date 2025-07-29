<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Designations';
include 'includes/header.php';

// Handle add designation
$success = '';
$error = '';
if (isset($_POST['add_designation'])) {
    $name = trim($_POST['designation_name']);
    if (strlen($name) < 2) {
        $error = 'Designation name must be at least 2 characters.';
    } else {
        $stmt = $conn->prepare('INSERT INTO designations (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        if ($stmt->execute()) {
            $success = 'Designation added!';
        } else {
            $error = 'Error adding designation.';
        }
    }
}
// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM designations WHERE id=$id");
    header('Location: designations.php');
    exit();
}
// Fetch all designations
$result = $conn->query('SELECT * FROM designations ORDER BY id ASC');
?>
<div class="dashboard-container">
    <h2 class="dashboard-title">Designations</h2>
    <?php if ($success): ?><div style="color:green;text-align:center;">✔ <?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;text-align:center;">✖ <?php echo $error; ?></div><?php endif; ?>
    <form method="POST" style="margin-bottom:20px;text-align:center;">
        <input type="text" name="designation_name" placeholder="New Designation Name" required style="padding:8px;width:220px;">
        <button type="submit" name="add_designation" style="padding:8px 16px;background:#00796b;color:#fff;border:none;border-radius:5px;">Add Designation</button>
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
                    <a href="designations.php?delete=<?php echo $row['id']; ?>" style="color:#d32f2f;" onclick="return confirm('Delete this designation?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
