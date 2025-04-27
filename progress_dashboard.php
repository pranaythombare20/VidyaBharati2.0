

<?php include 'header.php'; ?>
<?php
include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("❌ Unauthorized access. Please log in.");
}

$pdo = new PDO("mysql:host=localhost;dbname=student_tracking_db", "root", "");  //      // Update with your database credentials
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$error = "";
// Get logged-in user details
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // Ensure 'role' is stored in session

// Base Query
$sql = "SELECT u.user_id, u.name, sm.subject, sm.marks_obtained, sm.total_marks, sm.exam_type, sm.semester 
        FROM users u
        JOIN student_marks sm ON u.user_id = sm.student_id";

// Filter for students only
if ($user_role == 'student') {
    $sql .= " WHERE u.user_id = :user_id";
}

$stmt = $pdo->prepare($sql);

// Bind parameter only for students
if ($user_role == 'student') {
    $stmt->execute([':user_id' => $user_id]);
} else {
    $stmt->execute();
}

// Fetch results
$students = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $students[$row['user_id']]['name'] = $row['name'];
    $students[$row['user_id']]['marks'][] = [
        'subject' => $row['subject'],
        'marks_obtained' => $row['marks_obtained'],
        'total_marks' => $row['total_marks'],
        'exam_type' => $row['exam_type'],
        'semester' => $row['semester']
    ];
}

// Check if any records exist
if (empty($students)) {
    $error = "<br><p class='alert alert-danger'><br><b>❌ No student records found.<br> <br></b></p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Futuristic Glassmorphism */
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease-in-out;
}
.glass-card:hover {
    transform: scale(1.02);
}

/* Animated Background */
body {
                font-family: 'Times New Roman', sans-serif;
                background: linear-gradient(to right,rgb(207, 221, 233),  white);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
                color:white;
                margin: 0;
                padding-top: 0px; /* Leave space for fixed header */
}
@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Neon Glow Effects */
.btn-custom {
    background: #0174BE;
    color: white;
    border-radius: 10px;
    padding: 10px 15px;
    transition: 0.3s ease-in-out;
    box-shadow: 0px 0px 10px rgba(1, 116, 190, 0.8);
}
.btn-custom:hover {
    background: #014F86;
    box-shadow: 0px 0px 15px rgba(1, 116, 190, 1);
}
 
    

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

   
        /* Container Styling */
        .container {
            margin: 50px auto;
            padding: 20px;
            max-width: 1200px;
            border-radius: 15px;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            transform: scale(1.0);
          
        }
    .table{
        background: white;
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        border-radius:10px;
      
    }
    .card {
            background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease-in-out;
            color:black;
                }

     h3 {
       color:white;
     
    }

    /* Table Styling */
    table {
        
        width: 100%;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    th {
        
        
        padding: 12px;
        text-align: center;
        background: linear-gradient(135deg,rgb(24, 90, 157),rgb(67, 207, 162));
        text-transform: uppercase;
        background-size: 400% 400%; 
        animation: gradientAnimation 15s ease infinite;
  
    }

    td {
        color: white;
        text-transform: uppercase;
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
        background: linear-gradient(135deg,rgb(67, 207, 162),rgb(24, 90, 157));
        background-size: 400% 400%; 
        animation: gradientAnimation 15s ease infinite;
       
        
    }

    tr:hover {
        background: #f2f2f2;
    }

    /* Buttons */
    .btn-custom {
        background: #0174BE;
        color: white;
        border-radius: 10px;
        padding: 10px 15px;
        transition: 0.3s ease-in-out;
    }

    .btn-custom:hover {
        background: #014F86;
        transform: scale(1.05);
    }

    .btn-danger {
        background: #ff4d4d;
        border-radius: 10px;
        padding: 10px 15px;
        transition: 0.3s ease-in-out;
    }

    .btn-danger:hover {
        background: #cc0000;
        transform: scale(1.05);
    }

    /* Form Styling */
    .form-label {
        font-weight: bold;
        color:rgb(45, 53, 66);
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #ddd;
        padding: 10px;
        transition: 0.3s ease-in-out;
    }

    .form-control:focus {
        border-color: #0174BE;
        box-shadow: 0 0 8px rgba(1, 116, 190, 0.3);
    } */

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        table {
            font-size: 14px;
        }

        th, td {
            padding: 10px;
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
        .black{
            padding:20px;
            border-radius: 10px;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            transform: scale(1.0);
            color:white;
            font-family:times new roman;
        }
</style>
</head>
<body>

<div class="container" style="background:white; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);"> 
    <div class="container">
        <div class="container" style="background:white; padding:30px; color:black; text-transform: Uppercase;">
            <?php foreach ($students as $student_id => $student): ?>
                <h2><center><b><?php echo htmlspecialchars($student['name']); ?></h2></b></center>     
            </div>
            <div class="container" style="background:white; padding:40px;">
                <table class="table table-bordered">
                    <tr>
                        <th style="color: white;">Subject</th>
                        <th style="color: white;">Marks Obtained</th>
                        <th style="color: white;">Total Marks</th>
                        <th style="color: white;">Exam Type</th>
                        <th style="color: white;">Semester</th>
                    </tr>
                    <?php foreach ($student['marks'] as $mark): ?>
                        <tr>
                            <td style="color:white;"><?php echo htmlspecialchars($mark['subject']); ?></td>
                            <td style="color:white;"><?php echo htmlspecialchars($mark['marks_obtained']); ?></td>
                            <td style="color:white;"><?php echo htmlspecialchars($mark['total_marks']); ?></td>
                            <td style="color:white;"><?php echo htmlspecialchars($mark['exam_type']); ?></td>
                            <td style="color:white;"><?php echo htmlspecialchars($mark['semester']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endforeach; ?>
            <div class="container" style="background:white; padding-bottom:10px;">
                <big><center><h3 style="color:green;"><b>Student Progress Data</h3></b></center></big>
                <?php 
                echo $error; // Display error message if no records found
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
