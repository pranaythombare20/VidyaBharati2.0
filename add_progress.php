<?php
include 'db_connect.php'; // Database connection

$message = "";

// Fetch Student IDs from the database
$students = [];
$result = $conn->query("SELECT id, name FROM students"); // Adjust table name if needed
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate & Fetch POST data safely
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;
    $subject = isset($_POST['subject']) ? $_POST['subject'] : null;
    $marks_obtained = isset($_POST['marks_obtained']) ? $_POST['marks_obtained'] : null;
    $total_marks = isset($_POST['total_marks']) ? $_POST['total_marks'] : null;
    $exam_type = isset($_POST['exam_type']) ? $_POST['exam_type'] : null;
    $semester = isset($_POST['semester']) ? $_POST['semester'] : null;

    // Check for required fields
    if ($student_id && $subject && $marks_obtained !== null && $total_marks !== null && $exam_type && $semester) {
        $stmt = $conn->prepare("INSERT INTO student_marks (student_id, subject, marks_obtained, total_marks, exam_type, semester) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $student_id, $subject, $marks_obtained, $total_marks, $exam_type, $semester);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Progress added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>All fields are required!</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student Progress</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Student Progress</h2>
        <?php echo $message; ?>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Student ID</label>
                <select name="student_id" class="form-control" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>"><?= $student['id'] . " - " . $student['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Marks Obtained</label>
                <input type="number" name="marks_obtained" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Total Marks</label>
                <input type="number" name="total_marks" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Exam Type</label>
                <select name="exam_type" class="form-control" required>
                    <option value="Midterm">Midterm</option>
                    <option value="Final">Final</option>
                    <option value="Quiz">Quiz</option>
                    <option value="Assignment">Assignment</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Semester</label>
                <input type="text" name="semester" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Progress</button>
        </form>
    </div>
</body>
</html>
