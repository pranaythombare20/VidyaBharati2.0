<?php
session_start(); // ✅ Add this at the top to enable session handling
include 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: try.php");
    exit();
}


$role=$_SESSION['role']; // Get the role from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            padding-top: 70px; /* Prevent content from being hidden under the fixed navbar */
            font-family: 'Times New Roman', sans-serif;
            }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            z-index: 1000;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        
        }
        .navbar:hover {
            background: linear-gradient(135deg, #185a9d, #43cea2);
            transform: scale(1.0);
            box-shadow: 0 6px 15px rgba(67, 206, 162, 0.8);
        }
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .navbar-brand:hover {
            color: #f0f0f0;
        }

        .nav-link {
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .nav-link:hover {
            color: #66ccff;
            transform: scale(1.1);
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%28155, 155, 155, 1%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .container {
            margin-top: 20px;
        }
        a{
            text-decoration: none;
            color: white;
            padding:10px;
            align: center;
        }
        .btn-back{
            align-content: center;
            padding-top: 10px;
           margin-top:20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" style="color:white"><b><big>VidyaBharati</big></a></b>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <b><ul class="navbar-nav ms-auto">
                <li class="nav-item">
                <?php if ($role == 'student'): ?>
            <a href="student_dashboard.php" class="nav-link" style="color:white">Dashboard</a>
        <?php endif; ?>
                <?php if ($role == 'admin'): ?>
            <a href="admin_dashboard.php" class="nav-link" style="color:white">Dashboard</a>
        <?php endif; ?>
        
        <?php if ($role == 'teacher'): ?>
        <a href="teacher_dashboard.php" class="nav-link" style="color:white">Dashboard</a>
        <?php endif; ?></b>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color:white"><b>Logout</b></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>
<div class="container mt-4" style=" border-radius:10px; padding:20px; color:white; text-align: center; background: linear-gradient(135deg, #185a9d, #43cea2);">
    <h2 style="color:white;"><b><big>Welcome to the Student Management System</big></b></h2>
</div>

</body>
</html>
