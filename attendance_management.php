<?php
session_start();
include 'db_connect.php'; // Database connection

// Check user role
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

echo "<h2>Welcome to Attendance Management System</h2>";
echo "<h3>Dashboard - $role</h3>";

if ($role == 'student') {
    // Student Dashboard
    echo "<h4>Your Attendance Record</h4>";
    $query = "SELECT * FROM attendance WHERE student_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    echo "<table border='1'>
            <tr><th>Date</th><th>Period 1</th><th>Period 2</th><th>Period 3</th><th>Period 4</th><th>Period 5</th><th>Period 6</th><th>Period 7</th><th>Period 8</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['date']}</td><td>{$row['period_1']}</td><td>{$row['period_2']}</td>
                <td>{$row['period_3']}</td><td>{$row['period_4']}</td>
                <td>{$row['period_5']}</td><td>{$row['period_6']}</td>
                <td>{$row['period_7']}</td><td>{$row['period_8']}</td></tr>";
    }
    echo "</table>";
} elseif ($role == 'teacher') {
    // Teacher Dashboard - Mark Attendance
    echo "<h4>Mark Student Attendance</h4>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $student_id = $_POST['student_id'];
        $date = $_POST['date'];
        $attendance = array_map('mysqli_real_escape_string', $_POST);
        
        $query = "INSERT INTO attendance (student_id, date, period_1, period_2, period_3, period_4, period_5, period_6, period_7, period_8) VALUES ('$student_id', '$date', '{$attendance['period_1']}', '{$attendance['period_2']}', '{$attendance['period_3']}', '{$attendance['period_4']}', '{$attendance['period_5']}', '{$attendance['period_6']}', '{$attendance['period_7']}', '{$attendance['period_8']}') ON DUPLICATE KEY UPDATE period_1='{$attendance['period_1']}', period_2='{$attendance['period_2']}', period_3='{$attendance['period_3']}', period_4='{$attendance['period_4']}', period_5='{$attendance['period_5']}', period_6='{$attendance['period_6']}', period_7='{$attendance['period_7']}', period_8='{$attendance['period_8']}'";
        mysqli_query($conn, $query);
        echo "Attendance marked successfully!";
    }
    echo "<form method='POST'>
            Student ID: <input type='text' name='student_id' required>
            Date: <input type='date' name='date' required>
            Period 1: <select name='period_1'><option>Present</option><option>Absent</option></select>
            Period 2: <select name='period_2'><option>Present</option><option>Absent</option></select>
            Period 3: <select name='period_3'><option>Present</option><option>Absent</option></select>
            Period 4: <select name='period_4'><option>Present</option><option>Absent</option></select>
            Period 5: <select name='period_5'><option>Present</option><option>Absent</option></select>
            Period 6: <select name='period_6'><option>Present</option><option>Absent</option></select>
            Period 7: <select name='period_7'><option>Present</option><option>Absent</option></select>
            Period 8: <select name='period_8'><option>Present</option><option>Absent</option></select>
            <button type='submit'>Submit</button>
          </form>";
} elseif ($role == 'admin') {
    // Admin Dashboard
    echo "<h4>Manage Attendance Records</h4>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $student_id = $_POST['student_id'];
        $date = $_POST['date'];
        $attendance = array_map('mysqli_real_escape_string', $_POST);
        
        $query = "INSERT INTO attendance (student_id, date, period_1, period_2, period_3, period_4, period_5, period_6, period_7, period_8) VALUES ('$student_id', '$date', '{$attendance['period_1']}', '{$attendance['period_2']}', '{$attendance['period_3']}', '{$attendance['period_4']}', '{$attendance['period_5']}', '{$attendance['period_6']}', '{$attendance['period_7']}', '{$attendance['period_8']}') ON DUPLICATE KEY UPDATE period_1='{$attendance['period_1']}', period_2='{$attendance['period_2']}', period_3='{$attendance['period_3']}', period_4='{$attendance['period_4']}', period_5='{$attendance['period_5']}', period_6='{$attendance['period_6']}', period_7='{$attendance['period_7']}', period_8='{$attendance['period_8']}'";
        mysqli_query($conn, $query);
        echo "Attendance record updated successfully!";
    }
    echo "<form method='POST'>
            Student ID: <input type='text' name='student_id' required>
            Date: <input type='date' name='date' required>
            Period 1: <select name='period_1'><option>Present</option><option>Absent</option></select>
            Period 2: <select name='period_2'><option>Present</option><option>Absent</option></select>
            Period 3: <select name='period_3'><option>Present</option><option>Absent</option></select>
            Period 4: <select name='period_4'><option>Present</option><option>Absent</option></select>
            Period 5: <select name='period_5'><option>Present</option><option>Absent</option></select>
            Period 6: <select name='period_6'><option>Present</option><option>Absent</option></select>
            Period 7: <select name='period_7'><option>Present</option><option>Absent</option></select>
            Period 8: <select name='period_8'><option>Present</option><option>Absent</option></select>
            <button type='submit'>Submit</button>
          </form>";
}
?>
