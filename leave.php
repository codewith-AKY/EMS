<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Manage Leave Requests';
include 'includes/header.php';

// Handle approve/reject/delete actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $leave_id = intval($_GET['id']);
    if ($_GET['action'] === 'approve') {
        $stmt = $conn->prepare('UPDATE leaves SET status = ? WHERE id = ?');
        $status = 'Approved';
        $stmt->bind_param('si', $status, $leave_id);
        $stmt->execute();
        $msg = 'Leave request approved.';
    } elseif ($_GET['action'] === 'reject') {
        $stmt = $conn->prepare('UPDATE leaves SET status = ? WHERE id = ?');
        $status = 'Rejected';
        $stmt->bind_param('si', $status, $leave_id);
        $stmt->execute();
        $msg = 'Leave request rejected.';
    } elseif ($_GET['action'] === 'delete') {
        $stmt = $conn->prepare('DELETE FROM leaves WHERE id = ?');
        $stmt->bind_param('i', $leave_id);
        $stmt->execute();
        $msg = 'Leave request deleted.';
    }
}

// Handle add leave request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_leave'])) {
    $employee_id = intval($_POST['employee_id']);
    $leave_type = trim($_POST['leave_type']);
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $reason = trim($_POST['reason']);
    $status = 'Pending';
    $errors = [];
    if (!$employee_id) $errors[] = 'Employee is required.';
    if (!$leave_type) $errors[] = 'Leave type is required.';
    if (!$from_date || !$to_date) $errors[] = 'Both dates are required.';
    if (strtotime($from_date) > strtotime($to_date)) $errors[] = 'From date cannot be after To date.';
    if (!$reason) $errors[] = 'Reason is required.';
    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO leaves (employee_id, leave_type, from_date, to_date, reason, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('isssss', $employee_id, $leave_type, $from_date, $to_date, $reason, $status);
        $stmt->execute();
        $msg = 'Leave request added.';
    }
}

// Fetch employees for dropdown
$employees = [];
$res = $conn->query('SELECT id, name FROM employees ORDER BY name');
while ($row = $res->fetch_assoc()) {
    $employees[] = $row;
}

// Fetch all leave requests
$leaves = [];
$sql = 'SELECT l.*, e.name FROM leaves l JOIN employees e ON l.employee_id = e.id ORDER BY l.id ASC';
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
    $leaves[] = $row;
}
?>
<div class="container">
    <h2>Manage Leave Requests</h2>
    <?php if (!empty($msg)) { echo '<div class="success-msg">' . htmlspecialchars($msg) . '</div>'; } ?>
    <?php if (!empty($errors)) { echo '<div class="error-msg">' . implode('<br>', $errors) . '</div>'; } ?>
    <div class="form-section">
        <h3>Add Leave Request</h3>
        <form method="post" onsubmit="return validateLeaveForm();">
            <label>Employee:</label>
            <select name="employee_id" required>
                <option value="">Select Employee</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?php echo $emp['id']; ?>"><?php echo htmlspecialchars($emp['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Leave Type:</label>
            <input type="text" name="leave_type" maxlength="50" required>
            <label>From Date:</label>
            <input type="date" name="from_date" required>
            <label>To Date:</label>
            <input type="date" name="to_date" required>
            <label>Reason:</label>
            <textarea name="reason" maxlength="255" required></textarea>
            <button type="submit" name="add_leave">Add Leave</button>
        </form>
    </div>
    <div class="table-section">
        <h3>All Leave Requests</h3>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leaves)): ?>
                    <tr><td colspan="8">No leave requests found.</td></tr>
                <?php else: foreach ($leaves as $leave): ?>
                    <tr>
                        <td><?php echo $leave['id']; ?></td>
                        <td><?php echo htmlspecialchars($leave['name']); ?></td>
                        <td><?php echo htmlspecialchars($leave['leave_type']); ?></td>
                        <td><?php echo htmlspecialchars($leave['from_date']); ?></td>
                        <td><?php echo htmlspecialchars($leave['to_date']); ?></td>
                        <td><?php echo htmlspecialchars($leave['reason']); ?></td>
                        <td><?php echo htmlspecialchars($leave['status']); ?></td>
                        <td>
                            <?php if ($leave['status'] === 'Pending'): ?>
                                <a href="?action=approve&id=<?php echo $leave['id']; ?>" class="btn-approve" onclick="return confirm('Approve this leave request?');">Approve</a>
                                <a href="?action=reject&id=<?php echo $leave['id']; ?>" class="btn-reject" onclick="return confirm('Reject this leave request?');">Reject</a>
                            <?php endif; ?>
                            <a href="?action=delete&id=<?php echo $leave['id']; ?>" class="btn-delete" onclick="return confirm('Delete this leave request?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
function validateLeaveForm() {
    var emp = document.querySelector('[name="employee_id"]').value;
    var type = document.querySelector('[name="leave_type"]').value.trim();
    var from = document.querySelector('[name="from_date"]').value;
    var to = document.querySelector('[name="to_date"]').value;
    var reason = document.querySelector('[name="reason"]').value.trim();
    if (!emp || !type || !from || !to || !reason) {
        alert('All fields are required.');
        return false;
    }
    if (from > to) {
        alert('From date cannot be after To date.');
        return false;
    }
    return true;
}
</script>
<?php include 'includes/footer.php'; ?>
