<?php
session_start();
include 'db_connect.php';

// Ensure only admins can delete records
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

// Get student ID from URL
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}
$student_id = $_GET['id'];

// Delete student record
$query = "DELETE FROM students WHERE id = '$student_id'";
if (mysqli_query($conn, $query)) {
    $_SESSION['message'] = "Student record deleted successfully!";
} else {
    $_SESSION['error'] = "Error deleting student record!";
}

// Redirect back to dashboard
header("Location: admin_dashboard.php");
exit();
?>
