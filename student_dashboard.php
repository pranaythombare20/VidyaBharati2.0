<?php include 'header.php'; ?>
<?php include 'db_connect.php'; ?>
<style>
    /* Global Styles */
    body {
        font-family: 'Times New Roman', sans-serif;
        background: linear-gradient(to right,rgb(207, 221, 233),  white);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        color:black;
        margin: 0;
        padding-top: 80px; /* Leave space for fixed header */
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .container {
            margin: 50px auto;
            padding: 40px;
            padding-bottom: 100px;
            max-width: 1200px;
            border-radius: 15px;
            background:white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

    h2{
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
    h5,p{
        color:white;
    }

    /* Dashboard Cards */
    .dashboard-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-top: 40px;
    }

    .dashboard-card {
        background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
        border-radius: 15px;
        width: 350px;
        height: 250px;
        padding: 30px 20px;
        text-align: left;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        color: #001f4d;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .dashboard-card i {
        font-size: 50px;
        margin-right: 20px;
        color: #0174BE;
        background: rgba(1, 116, 190, 0.1);
        padding: 15px;
        border-radius: 50%;
    }

    .dashboard-card .card-content {
        flex: 1;
        
    }

    .dashboard-card .card-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .dashboard-card .card-text {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .dashboard-card a.btn {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        font-size: 16px;
        padding: 10px 18px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: absolute;
        right: 20px;
        bottom: 20px;
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
</style>

<div class="container text-center">
    <h2><b>Welcome, <?php echo htmlspecialchars($_SESSION['user_id']); ?>!</h2></b>
    <p style="color:black;">Manage your details, attendance, and progress here.</p>

    <div class="dashboard-row">
        <!-- Student Records Card -->
        <div class="dashboard-card">
            <i class="fa fa-graduation-cap" style="background-color:white;">👤</i>
            <div class="card-content">
                <b><h5 class="card-title">Student Records</h5></b>
                <p class="card-text">Update your personal details.</p>
            </div>
            <a href="student_record.php" class="btn btn-primary">Manage</a>
        </div>

        <!-- Attendance Card -->
        <div class="dashboard-card">
            <i class="fa fa-user-check"  style="background-color:white;">📅</i>
            <div class="card-content">
                <h5 class="card-title">Attendance</h5>
                <p class="card-text">Check your attendance records.</p>
            </div>
            <a href="monthly_attendance.php" class="btn btn-success">View</a>
        </div>

        <!-- Progress Card -->
        <div class="dashboard-card">
            <i class="fa fa-chart-line"  style="background-color:white;">📊</i>
            <div class="card-content">
                <h5 class="card-title">Progress</h5>
                <p class="card-text">Track your academic performance.</p>
            </div>
            <a href="progress_dashboard.php" class="btn btn-success">View</a>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>
