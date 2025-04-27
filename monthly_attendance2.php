<?php include 'header.php'; ?>
<?php
include 'db_connect.php';

$student_id = ""; // Replace with the specific student_id you want to fetch
$attendance_records = [];
$defaulters = [];
$total_days = 0;

// Handle delete request
if (isset($_POST['delete_attendance'])) {
    $attendance_id = $_POST['attendance_id'];

    $delete_query = "DELETE FROM attendance WHERE id = ?";
    $stmt_delete = $conn->prepare($delete_query);
    $stmt_delete->bind_param("i", $attendance_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Attendance record deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting attendance record: " . $conn->error . "');</script>";
    }
}

// Fetch total number of working days (distinct dates in the attendance table)
$total_days_query = "SELECT COUNT(DISTINCT date) AS total_days FROM attendance";
$result_days = $conn->query($total_days_query);
if ($result_days) {
    $row_days = $result_days->fetch_assoc();
    $total_days = $row_days['total_days']; // Total working days
} else {
    die("Error fetching total days: " . $conn->error);
}

// Fetch attendance records for a specific student
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    if (!empty($student_id)) {
        // Fetch attendance records for the given student_id
        $sql_attendance = "
            SELECT date, period_1, period_2, period_3, period_4, period_5, period_6, period_7, period_8
            FROM attendance
            WHERE student_id = ?";
        
        $stmt = $conn->prepare($sql_attendance);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("s", $student_id); // Use "s" for string parameters
        $stmt->execute();
        $result_attendance = $stmt->get_result();

        while ($row = $result_attendance->fetch_assoc()) {
            $attendance_records[] = $row;
        }
    } else {
        echo "<script>alert('Student ID is required.');</script>";
    }
}

// Fetch defaulter list
$sql_defaulters = "
    SELECT s.roll_number, s.name,
        SUM(CASE WHEN a.period_1 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_2 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_3 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_4 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_5 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_6 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_7 = 'Present' THEN 1 ELSE 0 END +
            CASE WHEN a.period_8 = 'Present' THEN 1 ELSE 0 END
        ) AS total_present_periods
    FROM students s
    LEFT JOIN attendance a ON s.roll_number = a.student_id
    GROUP BY s.roll_number, s.name";

$result_defaulters = $conn->query($sql_defaulters);
if (!$result_defaulters) {
    die("Error fetching defaulter list: " . $conn->error);
}

if ($result_defaulters) {
    while ($row = $result_defaulters->fetch_assoc()) {
        $total_periods_possible = $total_days * 8; // 8 periods per day

        if ($total_periods_possible > 0) {
            $attendance_percentage = ($row['total_present_periods'] / $total_periods_possible) * 100;

            if ($attendance_percentage < 75) {
                $row['attendance_percentage'] = round($attendance_percentage, 2);
                $defaulters[] = $row;
            }
        }
    }
}

// Fetch all attendance records
$all_attendance_records = [];
$sql_all_attendance = "
    SELECT a.id AS attendance_id, a.student_id, s.name, a.date, a.period_1, a.period_2, a.period_3, a.period_4, a.period_5, a.period_6, a.period_7, a.period_8
    FROM attendance a
    LEFT JOIN students s ON a.student_id = s.roll_number
    ORDER BY a.date, s.name";

$result_all_attendance = $conn->query($sql_all_attendance);
if ($result_all_attendance) {
    while ($row = $result_all_attendance->fetch_assoc()) {
        $all_attendance_records[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #444;
            margin-top: 20px;
            text-align: center;
        }

        /* Table Styles */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input,th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Button Styles */
        form button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
        <br>
    <h2>Attendance Records for Student ID: <?php echo htmlspecialchars($student_id); ?></h2>
    <center>
    <form method="GET" action="">
        <label>Student ID: </label>
        <input type="text" name="student_id" required value="<?php echo htmlspecialchars($student_id); ?>">
        <button type="submit">Fetch Attendance</button>
    </form>

    <?php if (!empty($attendance_records)): ?>
        <table>
            <tr>
                <th>Date</th>
                <th>Period 1</th>
                <th>Period 2</th>
                <th>Period 3</th>
                <th>Period 4</th>
                <th>Period 5</th>
                <th>Period 6</th>
                <th>Period 7</th>
                <th>Period 8</th>
            </tr>
            <?php foreach ($attendance_records as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_1']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_2']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_3']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_4']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_5']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_6']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_7']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_8']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No attendance records found for this student.</p>
    <?php endif; ?>

    </center>


    <h2>Defaulter List (Attendance Below 75%)</h2>

    <table>
        <tr>
            <th>Roll Number</th>
            <th>Name</th>
            <th>Attendance Percentage</th>
        </tr>
        <?php if (count($defaulters) > 0): ?>
            <?php foreach ($defaulters as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo $student['attendance_percentage'] . "%"; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No defaulters found.</td></tr>
        <?php endif; ?>
    </table>

    <h2>All Attendance Records</h2>

    <table>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Date</th>
            <th>Period 1</th>
            <th>Period 2</th>
            <th>Period 3</th>
            <th>Period 4</th>
            <th>Period 5</th>
            <th>Period 6</th>
            <th>Period 7</th>
            <th>Period 8</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($all_attendance_records)): ?>
            <?php foreach ($all_attendance_records as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_1']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_2']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_3']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_4']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_5']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_6']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_7']); ?></td>
                    <td><?php echo htmlspecialchars($row['period_8']); ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="attendance_id" value="<?php echo $row['attendance_id']; ?>">
                            <button type="submit" name="delete_attendance">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="12">No attendance records found.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>
<?php include 'footer.php'; ?>