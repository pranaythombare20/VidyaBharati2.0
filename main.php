
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VidhyaBharati - Student Record Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
         body {
        font-family: 'times new roman', sans-serif;
        background: linear-gradient(135deg, #001f4d, #66ccff);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        color: #fff;
        margin: 0;
        padding-top: 80px; /* Leave space for fixed header */
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
        header {
            background: linear-gradient(135deg,rgb(129, 140, 158), #66ccff);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
            color: black;
            padding: 15px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            margin-left: 20px;
        }
        .dashboard-card {
        background: #fff;
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
        .dashboard-card {
            transition: 0.3s;
            cursor: pointer;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
            background-color: #0174BE;
            color: white;
        }
        body {
            padding-top: 70px; /* To prevent content from being hidden under fixed navbar */
          
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            height:60px;
            z-index: 1000;
            margin-top:0;
           
            
        }
        a{
            font-family:times new roman;
        }
     
        .nav-item:hover{
            background-color:rgb(153, 164, 172);
            transform: scale(1.05);
            color:black;
            border-radius:10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"><big><b>VidyaBharati</b></big></div>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="VidhyaBharati.html">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="contactus.html">Sign Up</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="signup.html">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="about.html">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="feedback.html">Feedback</a></li>
            </ul>
        </nav>
    </header>
    <center>
    <section class="container mt-5 pt-5">
        <h2 class="text-primary">Welcome to VidyaBharati</h1>
        <p class="lead">Your Smart Student Record Management System</p>
        <a href="login.html" class="btn btn-primary btn-lg">Get Started</a>
    </section>
    </center>
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="dashboard-card bg-light" onclick="location.href='student_records.html'">
                    <h5>Student Info Management</h5>
                    <p>Manage student records efficiently.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card bg-light" onclick="location.href='fee_tracking.html'">
                    <h5>Fee Tracking</h5>
                    <p>Track and manage student fee payments.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card bg-light" onclick="location.href='admissions.html'">
                    <h5>Admission Records</h5>
                    <p>Handle student admissions seamlessly.</p>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="dashboard-card bg-light" onclick="location.href='ai_search.html'">
                    <h5>AI-powered Search</h5>
                    <p>Find records instantly with AI search.</p>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="dashboard-card bg-light" onclick="location.href='progress_tracking.html'">
                    <h5>Progress Tracking</h5>
                    <p>Students can track their academic progress.</p>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="dashboard-card bg-light" onclick="location.href='real_time_data.html'">
                    <h5>Real-time Data Updates</h5>
                    <p>Get seamless real-time updates.</p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
