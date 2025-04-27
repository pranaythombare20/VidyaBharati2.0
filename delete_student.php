<?php
session_start();
include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php

// Ensure only admins can delete records
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=student_tracking_db", "root", "");  // Update with your database credentials
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Get student ID from URL
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}
$student_id = $_GET['id'];

// Delete student record using PDO
$query = "DELETE FROM students WHERE id = :id";
$stmt = $pdo->prepare($query);

if ($stmt->execute([':id' => $student_id])) {
    $_SESSION['message'] = "Student record deleted successfully!";
} else {
    $_SESSION['error'] = "Error deleting student record!";
}

// Redirect back to dashboard
header("Location: admin_dashboard.php");
exit();
?>