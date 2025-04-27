<?php include 'header.php'; ?>
<style>

@keyframes gradientAnimation {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Container */
.container {
    margin-top: 50px;
    padding-bottom: 50px;
}

/* Dashboard Cards */
.dashboard-card {
    background: #fff;
    border-radius: 15px;
    height:150px;
    width: 100%; /* Full width */
    max-width: 1500px; /* Limit max size */
    margin: 20px auto; /* Centered */
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between; /* Align button to right */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    color: #001f4d;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

/* Icon Styles */
.dashboard-card i {
    font-size: 50px;
    color: #0174BE;
    background: rgba(1, 116, 190, 0.1);
    padding: 15px;
    border-radius: 50%;
}

/* Card Content */
.card-content {
    flex-grow: 1;
    padding-left: 20px;
}

.card-title {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 5px;
}

.card-text {
    font-size: 16px;
    margin-bottom: 10px;
}

/* Align Button to Right */
.card-action {
    margin-left: auto;
}

/* Button Styling */
.dashboard-card a.btn {
    font-size: 16px;
    padding: 10px 18px;
    border-radius: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    width:200px;
}

/* Responsive Layout */
@media (max-width: 768px) {
    .dashboard-card {
        flex-direction: column;
        text-align: center;
    }
    .card-action {
        margin-left: 0;
        margin-top: 10px;
    }
  
} */
/*teacher css */
 
    /*here student dashboard css used  */
        /* Global Styles */
        body {
        font-family: 'Times New Roman', sans-serif;
        background: linear-gradient(to right,rgb(207, 221, 233),  white);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
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
        gap: 0px;
        margin-top: 40px;
    }

    .dashboard-card {
        background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
        border-radius: 15px;
        width: 450px;
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
        flex:1;
        padding:10px;
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
</style>
<br>

<!-- Admin Dashboard Cards -->
<div class="container">
<center><b>
<h2 style="color:black; font-family= times new roman"><big><b>Admin Dashboard</big></b></h2>
<p style="color:black;"><big>Manage users , Attendance  and Progress.</big></p>
</b>
</center>
<div class="dashboard-row">

    <div class="dashboard-card">
        <i class="fas fa-user-cog" style="background:white;">👤</i>
        <div class="card-content">
            <h5 class="card-title">Student Record</h5>
            <p class="card-text">Add or remove students Records</p>
        </div>
        <div class="card-action">
            <a href="student_record.php" class="btn btn-primary">Manage</a>
        </div>
    </div>

    <div class="dashboard-card">
        <i class="fas fa-calendar-check" style="background:white;">📅</i>
        <div class="card-body">
            <h5 class="card-title">Manage Attendance</h5>
            <p class="card-text">Manage student attendance records.</p>
        </div>
        <div class="card-action">
            <a href="monthly_attendance2.php" class="btn btn-primary">Modify</a>
        </div>
    </div>
<div>
</div>
</div>
<div class="dashboard-row">

    <div class="dashboard-card">
        <i class="fas fa-lock-open" style="background:white;">⚙️</i>
        <div class="card-content">
            <h5 class="card-title">Manage User</h5>
            <p class="card-text">To Manage User</p>
        </div>
        <div class="card-action">
            <a href="admin_allow_form.php" class="btn btn-primary">Manage</a>
        </div>
    </div>

    <div class="dashboard-card">
        <i class="fas fa-chart-line" style="background:white;">📊</i>
        <div class="card-body">
            <h5 class="card-title">Generate Reports</h5>
            <p class="card-text">Export progress reports.</p>
        </div>
        <div class="card-action">
            <a href="teacher_progress.php" class="btn btn-primary">Generate</a>
        </div>
    </div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

