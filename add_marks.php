<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $marks_obtained = $_POST['marks_obtained'];
    $total_marks = $_POST['total_marks'];
    $exam_type = $_POST['exam_type'];
    $semester = $_POST['semester'];

    $sql = "INSERT INTO student_marks (student_id, subject, marks_obtained, total_marks, exam_type, semester) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiiis", $student_id, $subject, $marks_obtained, $total_marks, $exam_type, $semester);
    
    if ($stmt->execute()) {
        echo "<script>alert('Marks added successfully'); window.location.href='progress_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error adding marks');</script>";
    }
}
?>
