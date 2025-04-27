<?php
session_start();
include 'db_connect.php';

// Ensure only admins can update records
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $roll_number = mysqli_real_escape_string($conn, $_POST['roll_number']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $guardian_name = mysqli_real_escape_string($conn, $_POST['guardian_name']);
    $guardian_contact = mysqli_real_escape_string($conn, $_POST['guardian_contact']);
    $admission_date = mysqli_real_escape_string($conn, $_POST['admission_date']);

    // Ensure student ID is valid
    if (empty($student_id)) {
        $_SESSION['error'] = "Invalid student ID.";
        header("Location: dashboard.php");
        exit();
    }

    // Update query
    $query = "UPDATE students SET 
                roll_number='$roll_number', 
                name='$name', 
                email='$email', 
                phone='$phone', 
                dob='$dob',
                gender='$gender', 
                address='$address', 
                course='$course', 
                year='$year',
                guardian_name='$guardian_name', 
                guardian_contact='$guardian_contact', 
                admission_date='$admission_date'
              WHERE id='$student_id'";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Student record updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating student record: " . mysqli_error($conn);
    }

    // Redirect back to dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // If accessed directly, redirect to dashboard
    $_SESSION['error'] = "Invalid request!";
    header("Location: dashboard.php");
    exit();
}
?>
