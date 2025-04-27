
<?php include 'header.php'; ?>
<?php
include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php

$role = $_SESSION['role']; // Get the role from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
        padding:0px;
        font-family: 'Times New Roman', sans-serif;
        background: linear-gradient(to right,rgb(207, 221, 233),  white);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        }
        .card {
            height: 100%;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .table-container {
            max-height: 400px;
            overflow-x: auto;
            overflow-y: auto;
        }
        /* Button Styling */
    .btn-custom {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(106, 17, 203, 0.5);
        }

        .dashboard-card a.btn:hover {
            color:white;
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(106, 17, 203, 0.8);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(255, 65, 108, 0.5);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 65, 108, 0.8);
        }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .dashboard-row {
            flex-direction: column;
            align-items: center;
        }
        .dashboard-card {
            text-align: center;
            flex-direction: column;
            padding: 20px;
        }
        .dashboard-card i {
            margin-bottom: 15px;
        }
    }
    .btn-back {
            display: inline-block;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(67, 206, 162, 0.5);
            width: 200px;
            margin: 20px auto;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #185a9d, #43cea2);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(67, 206, 162, 0.8);
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Student Progress Management</h2>

        <div class="row">
            <!-- Add Progress Card -->
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Add Student Progress</h5>
                    </div>
                    <div class="card-body">
                        <?php include 'add_progress.php'; ?>
                    </div>
                </div>
            </div>

            <!-- Delete Progress Card -->
            <div class="col-md-6">
                <div class="card shadow h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Delete Student Progress</h5>
                    </div>
                    <div class="card-body">
                        <?php include 'delete_progress.php'; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Progress Display Card -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">All Student Progress Records</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Progress ID</th>
                                        <th>Roll Number</th>
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Marks Obtained</th>
                                        <th>Total Marks</th>
                                        <th>Exam Type</th>
                                        <th>Semester</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch progress records using PDO
                                    $sql = "
                                        SELECT sm.id, sm.subject, sm.marks_obtained, sm.total_marks, sm.exam_type, sm.semester, 
                                               s.roll_number, s.name 
                                        FROM student_marks sm
                                        JOIN students s ON sm.student_id = s.id
                                    ";

                                    $stmt = $pdo->query($sql);
                                    $progress_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (!empty($progress_records)) {
                                        foreach ($progress_records as $row) {
                                            echo "<tr>
                                                <td>" . htmlspecialchars($row['id']) . "</td>
                                                <td>" . htmlspecialchars($row['roll_number']) . "</td>
                                                <td>" . htmlspecialchars($row['name']) . "</td>
                                                <td>" . htmlspecialchars($row['subject']) . "</td>
                                                <td>" . htmlspecialchars($row['marks_obtained']) . "</td>
                                                <td>" . htmlspecialchars($row['total_marks']) . "</td>
                                                <td>" . (!empty($row['exam_type']) ? htmlspecialchars($row['exam_type']) : 'N/A') . "</td>
                                                <td>" . htmlspecialchars($row['semester']) . "</td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center text-danger'>No records found!</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>