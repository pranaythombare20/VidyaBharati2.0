<?php include 'header.php'; ?>
<?php
include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php

$pdo = new PDO("mysql:host=localhost;dbname=student_tracking_db", "root", "");  // Update with your database credentials
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$student_id = ""; // Replace with the specific student_id you want to fetch
$attendance_records = [];
$defaulters = [];
$total_days = 0;

// Fetch total number of working days (distinct dates in the attendance table)
$total_days_query = "SELECT COUNT(DISTINCT date) AS total_days FROM attendance";
$stmt_days = $pdo->query($total_days_query);
$total_days = $stmt_days->fetch(PDO::FETCH_ASSOC)['total_days'] ?? 0;

// Fetch attendance records for a specific student
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    if (!empty($student_id)) {
        // Fetch attendance records for the given student_id
        $sql_attendance = "
            SELECT date, period_1, period_2, period_3, period_4, period_5, period_6, period_7, period_8
            FROM attendance
            WHERE student_id = :student_id";
        
        $stmt = $pdo->prepare($sql_attendance);
        $stmt->execute([':student_id' => $student_id]);
        $attendance_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

$stmt_defaulters = $pdo->query($sql_defaulters);
while ($row = $stmt_defaulters->fetch(PDO::FETCH_ASSOC)) {
    $total_periods_possible = $total_days * 8; // 8 periods per day

    if ($total_periods_possible > 0) {
        $attendance_percentage = ($row['total_present_periods'] / $total_periods_possible) * 100;

        if ($attendance_percentage < 75) {
            $row['attendance_percentage'] = round($attendance_percentage, 2);
            $defaulters[] = $row;
        }
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

        /* Form Styles */
        form {
            margin: 20px auto;
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            margin-right: 10px;
        }

        form input[type="text"],
        form input[type="date"],
        form button {
            padding: 10px;
            font-size: 14px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 20px);
            max-width: 300px;
        }

        form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: auto;
        }

        form button:hover {
            background-color: #0056b3;
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

        th, td {
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

        /* No Records Message */
        p {
            text-align: center;
            font-size: 16px;
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            form input[type="text"],
            form input[type="date"],
            form button {
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <h2>Attendance Records for Student ID: <?php echo htmlspecialchars($student_id); ?></h2>

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
</body>
</html>
<?php include 'footer.php'; ?>