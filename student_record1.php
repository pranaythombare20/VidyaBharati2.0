<?php
session_start();
include 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];  // Added ID column
    $roll_number = $_POST['roll_number'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = date('Y-m-d', strtotime($_POST['dob']));  // Convert to YYYY-MM-DD
    $address = $_POST['address'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_contact = $_POST['guardian_contact'];
    $admission_date = date('Y-m-d', strtotime($_POST['admission_date'])); // Convert format
    $gender = $_POST['gender'];

    // Insert data into students table
    $sql = "INSERT INTO students (id, roll_number, name, email, phone, dob, address, course, year, guardian_name, guardian_contact, admission_date, gender)
            VALUES ('$id', '$roll_number', '$name', '$email', '$phone', '$dob', '$address', '$course', '$year', '$guardian_name', '$guardian_contact', '$admission_date', '$gender')";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color:green; text-align:center;'>Record inserted successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
