<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'includes/db.php';
$page_title = 'Add Employee';
include 'includes/header.php';

// Fetch departments and designations for dropdowns
$departments = $conn->query('SELECT name FROM departments');
$designations = $conn->query('SELECT name FROM designations');

// Handle form submission
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $salary = $_POST['salary'];
    $join_date = $_POST['join_date'];
    $photo = '';

    // Server-side validation
    if (strlen($name) < 3) {
        $error = 'Name must be at least 3 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error = 'Phone must be 10-15 digits.';
    } elseif ($salary < 0) {
        $error = 'Salary must be positive.';
    } elseif (empty($gender) || empty($department) || empty($designation) || empty($join_date)) {
        $error = 'All fields are required.';
    } else {
        // Handle file upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo = 'uploads/' . uniqid('emp_', true) . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        }
        $stmt = $conn->prepare('INSERT INTO employees (name, email, phone, gender, department, designation, salary, join_date, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssssdss', $name, $email, $phone, $gender, $department, $designation, $salary, $join_date, $photo);
        if ($stmt->execute()) {
            $success = 'Employee added successfully!';
        } else {
            $error = 'Error adding employee.';
        }
    }
}
?>
<div class="form-container" style="max-width:500px;margin:30px auto;background:#fff;padding:30px 25px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
    <h2 style="color:#00796b;text-align:center;margin-bottom:20px;">Add New Employee</h2>
    <?php if ($success): ?><div style="color:green;text-align:center;">✔ <?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div style="color:red;text-align:center;">✖ <?php echo $error; ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data" autocomplete="off" id="addEmployeeForm" onsubmit="return validateEmployeeForm();">
        <input type="text" name="name" id="name" placeholder="Full Name" required><br>
        <input type="email" name="email" id="email" placeholder="Email" required><br>
        <input type="text" name="phone" id="phone" placeholder="Phone" required><br>
        <select name="gender" id="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br>
        <select name="department" id="department" required>
            <option value="">Select Department</option>
            <?php $departments->data_seek(0); while($row = $departments->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['name']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select><br>
        <select name="designation" id="designation" required>
            <option value="">Select Designation</option>
            <?php $designations->data_seek(0); while($row = $designations->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['name']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select><br>
        <input type="number" name="salary" id="salary" placeholder="Salary" step="0.01" min="0" required><br>
        <input type="date" name="join_date" id="join_date" required><br>
        <label style="display:block;margin:10px 0 5px 0;">Profile Photo:</label>
        <input type="file" name="photo" id="photo" accept="image/*"><br><br>
        <button type="submit" style="width:100%;padding:10px;background:#00796b;color:#fff;border:none;border-radius:5px;font-size:1.1em;">Add Employee</button>
    </form>
</div>
<script>
function validateEmployeeForm() {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var gender = document.getElementById('gender').value;
    var department = document.getElementById('department').value;
    var designation = document.getElementById('designation').value;
    var salary = document.getElementById('salary').value;
    var join_date = document.getElementById('join_date').value;
    var photo = document.getElementById('photo').value;
    if (name.length < 3) { alert('Name must be at least 3 characters.'); return false; }
    var emailPattern = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
    if (!emailPattern.test(email)) { alert('Invalid email address.'); return false; }
    if (!/^\d{10,15}$/.test(phone)) { alert('Phone must be 10-15 digits.'); return false; }
    if (salary === '' || isNaN(salary) || Number(salary) < 0) { alert('Salary must be a positive number.'); return false; }
    if (!gender || !department || !designation || !join_date) { alert('All fields are required.'); return false; }
    if (photo && !photo.match(/\.(jpg|jpeg|png|gif)$/i)) { alert('Profile photo must be an image file (jpg, jpeg, png, gif).'); return false; }
    return true;
}
</script>
<?php include 'includes/footer.php'; ?>
