<?php
session_start();
include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php

// Ensure only admins can update records
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $roll_number = $_POST['roll_number'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_contact = $_POST['guardian_contact'];
    $admission_date = $_POST['admission_date'];

    // Ensure student ID is valid
    if (empty($student_id)) {
        $_SESSION['error'] = "Invalid student ID.";
        header("Location: dashboard.php");
        exit();
    }

    // Update query using PDO
    $query = "UPDATE students SET 
                roll_number = :roll_number, 
                name = :name, 
                email = :email, 
                phone = :phone, 
                dob = :dob,
                gender = :gender, 
                address = :address, 
                course = :course, 
                year = :year,
                guardian_name = :guardian_name, 
                guardian_contact = :guardian_contact, 
                admission_date = :admission_date
              WHERE id = :student_id";

    $stmt = $pdo->prepare($query);
    $params = [
        ':roll_number' => $roll_number,
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':dob' => $dob,
        ':gender' => $gender,
        ':address' => $address,
        ':course' => $course,
        ':year' => $year,
        ':guardian_name' => $guardian_name,
        ':guardian_contact' => $guardian_contact,
        ':admission_date' => $admission_date,
        ':student_id' => $student_id
    ];

    if ($stmt->execute($params)) {
        $_SESSION['message'] = "Student record updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating student record.";
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