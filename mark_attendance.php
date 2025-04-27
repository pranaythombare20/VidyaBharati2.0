<?php include 'header.php'; ?>
<?php
include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php
$pdo = new PDO("mysql:host=localhost;dbname=student_tracking_db", "root", "");  // Update with your database credentials
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];

    if (!empty($_POST['attendance'])) {
        foreach ($_POST['attendance'] as $student_id => $period_data) {
            // Ensure valid student_id
            if (empty($student_id)) {
                echo "Invalid student ID: $student_id<br>";
                continue;
            }

            // Prepare period values
            $periods = [];
            for ($i = 1; $i <= 8; $i++) {
                $periods[] = isset($period_data[$i]) ? $period_data[$i] : 'Absent';
            }

            // Check if attendance already exists for the student on the given date
            $stmt_check = $pdo->prepare("SELECT * FROM attendance WHERE student_id = :student_id AND date = :date");
            $stmt_check->execute([':student_id' => $student_id, ':date' => $date]);

            if ($stmt_check->rowCount() == 0) {
                // Insert attendance data
                $stmt_insert = $pdo->prepare("
                    INSERT INTO attendance 
                    (student_id, date, period_1, period_2, period_3, period_4, period_5, period_6, period_7, period_8) 
                    VALUES (:student_id, :date, :period_1, :period_2, :period_3, :period_4, :period_5, :period_6, :period_7, :period_8)
                ");
                $params = [
                    ':student_id' => $student_id,
                    ':date' => $date,
                    ':period_1' => $periods[0],
                    ':period_2' => $periods[1],
                    ':period_3' => $periods[2],
                    ':period_4' => $periods[3],
                    ':period_5' => $periods[4],
                    ':period_6' => $periods[5],
                    ':period_7' => $periods[6],
                    ':period_8' => $periods[7]
                ];

                if (!$stmt_insert->execute($params)) {
                    echo "Error for Student ID $student_id: " . implode(", ", $stmt_insert->errorInfo()) . "<br>";
                }
            } else {
                echo "Attendance already marked for Student ID $student_id on $date.<br>";
            }
        }

        echo "<script>alert('Attendance marked successfully for all students.');</script>";
    } else {
        echo "<script>alert('No attendance data received.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
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
            max-width: 800px;
        }

        form label {
            font-size: 16px;
            font-weight: bold;
            margin-right: 10px;
        }

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

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }

            form input[type="date"],
            form button {
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <h2>Mark Attendance</h2>
    <form method="POST" action="mark_attendance.php">
        <label for="date">Select Date:</label>
        <input type="date" name="date" required>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Period 1</th>
                <th>Period 2</th>
                <th>Period 3</th>
                <th>Period 4</th>
                <th>Period 5</th>
                <th>Period 6</th>
                <th>Period 7</th>
                <th>Period 8</th>
            </tr>
            <?php
            $stmt_students = $pdo->query("SELECT * FROM users WHERE role = 'student'");
            while ($row = $stmt_students->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['name']}</td>";
                for ($i = 1; $i <= 8; $i++) {
                    echo "<td>
                        <select name='attendance[{$row['name']}][$i]'>
                            <option value='Present'>P</option>
                            <option value='Absent'>A</option>
                            <option value='Late'>L</option>
                        </select>
                    </td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <button type="submit">Submit Attendance</button>
    </form>  
</body>
</html>
<?php include 'footer.php'; ?>