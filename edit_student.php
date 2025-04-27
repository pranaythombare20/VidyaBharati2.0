<?php
session_start();
include 'db_connect.php';

// Ensure only admins can access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

$fields = [
    'roll_number' => 'Roll Number', 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'dob' => 'DOB',
    'address' => 'Address', 'course' => 'Course', 'year' => 'Year',
    'guardian_name' => 'Guardian Name', 'guardian_contact' => 'Guardian Contact',
    'admission_date' => 'Admission Date', 'gender' => 'Gender'
];

// Get student ID from URL
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}
$student_id = $_GET['id'];

// Fetch student record
$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    echo "<p class='text-danger text-center'>Student not found!</p>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [];
    foreach ($fields as $key => $label) {
        $data[$key] = mysqli_real_escape_string($conn, $_POST[$key]);
    }
    $update_query = "UPDATE students SET 
                        roll_number='{$data['roll_number']}', name='{$data['name']}', email='{$data['email']}',
                        phone='{$data['phone']}', dob='{$data['dob']}', address='{$data['address']}',
                        course='{$data['course']}', year='{$data['year']}', guardian_name='{$data['guardian_name']}',
                        guardian_contact='{$data['guardian_contact']}', admission_date='{$data['admission_date']}',
                        gender='{$data['gender']}' WHERE id='$student_id'";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['message'] = "Student record updated successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<p class='text-danger text-center'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card p-4">
            <h2 class="text-center text-primary">Edit Student Record</h2>
            <form method="POST" action="">
                <?php foreach ($fields as $key => $label): ?>
                    <div class="mb-3">
                        <label class="form-label"> <?= $label ?> </label>
                        <input type="text" name="<?= $key ?>" class="form-control" value="<?= htmlspecialchars($student[$key]) ?>" required>
                    </div>
                <?php endforeach; ?>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>