<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StudentSys | Dashboard</title>
  <style>
    /* BASIC RESET */
    * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #4ba9f6, #9ff6c6);
      color: #fff;
    }
    a { text-decoration: none; color: inherit; position: relative; }
    a::after {
      content: "";
      position: absolute;
      width: 0;
      height: 2px;
      left: 0;
      bottom: -4px;
      background-color: #ffc107;
      transition: width 0.3s ease;
    }
    a:hover::after {
      width: 100%;
    }

    /* HEADER */
    header {
        background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      position: fixed;
      top: 0; width: 100%;
      z-index: 999;
    }
    .logo { font-size: 1.5rem; font-weight: bold; color: #ffc107; }
    nav ul {
      display: flex;
      gap: 1.2rem;
      list-style: none;
    }

    /* HERO */
    .hero {
      margin-top: 4rem;
      height: 100vh;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
                  url('https://images.unsplash.com/photo-1584697964154-c87c836a1db8') center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 2rem;
      animation: fadeIn 1.5s ease;
      border-bottom: 4px solid #ffc107;
    }
    .hero h1 { font-size: 3rem; color: #ffc107; animation: slideUp 1s ease; }
    .hero p { font-size: 1.2rem; margin: 1rem 0; animation: fadeIn 2s ease; }
    .hero a {
      background: #ffc107; color: #000; padding: 0.8rem 1.5rem;
      border-radius: 5px; font-weight: bold; transition: 0.3s ease;
    }
    .hero a:hover {
      background: #fff; color: #000;
      transform: scale(1.05);
    }

    /* SECTION BASE */
    section {
      height: 100vh;
      background: linear-gradient(rgba(5, 43, 96, 0.467), rgba(2, 69, 72, 0.7)),
                  url('https://images.unsplash.com/photo-1584697964154-c87c836a1db8') center/cover;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 2rem;
      animation: fadeIn 1.5s ease;
      border-bottom: 4px solid #ffc107;
    }
    section.visible {
      opacity: 1;
      transform: translateY(0);
    }
    section h2 {
      text-align: center;
      color: #ffc107;
      margin-bottom: 2rem;
    }
    section p {
      text-align: center;
      font-size: 1.1rem;
      line-height: 1.6;
      color: #ddd;
    }

    /* DASHBOARD */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 2rem;
    }
    .card {
      background: #222;
      padding: 2rem;
      border-radius: 10px;
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      box-shadow: 0 0 15px rgba(255,193,7,0.1);
      position: relative;
      cursor: pointer;
      background: linear-gradient(to right, #333, #222);
    }
    .card:hover {
      transform: scale(1.03);
      box-shadow: 0 0 20px rgba(255,193,7,0.3);
      background: linear-gradient(to right, #444, #333);
    }
    .card h3 {
      margin-bottom: 0.5rem;
      color: #ffc107;
      font-size: 1.3rem;
    }
    .card .desc {
      font-size: 0.95rem;
      line-height: 1.5;
      color: #aaa;
    }
    .card .details {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease;
      font-size: 0.85rem;
      color: #ccc;
      margin-top: 1rem;
    }
    .card.active .details {
      max-height: 300px;
    }

    
    /* FORMS */
    form {
      max-width: 400px;
      margin: auto;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    input, textarea {
      padding: 0.8rem;
      border: none;
      border-radius: 5px;
      background: #333;
      color: #fff;
      transition: 0.3s;
      box-shadow: 0 0 5px rgba(255,193,7,0.1);
    }
    input:focus, textarea:focus {
      outline: none;
      box-shadow: 0 0 5px #ffc107;
      background: #444;
    }
    input[type="submit"] {
      background: #ffc107;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      border-radius: 5px;
    }
    input[type="submit"]:hover {
      background: #fff;
      color: #000;
      transform: scale(1.05);
    }

    /* TEXT SECTIONS */
    .about p, .contact p {
      max-width: 700px;
      margin: auto;
      text-align: center;
      line-height: 1.6;
      font-size: 1.1rem;
    }

    /* FOOTER */
    footer {
    background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
      text-align: center;
      padding: 1rem;
      color:black;
      border-top: 4px solid #ffc107;
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }
      nav ul {
        flex-direction: column;
        margin-top: 1rem;
      }
    }

    /* KEYFRAMES */
    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }
    @keyframes slideUp {
      0% { transform: translateY(30px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }
    /* Go Up Button */
    .go-up {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #ffc107;
      color: #000;
      border: none;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      font-size: 24px;
      display: none;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .go-up:hover {
      background-color: #ffb300;
      transform: scale(1.1);
    }

    /* Show the button when scrolling */
    .go-up.visible {
      display: flex;
    }
    .about-highlights ul {
  list-style: none;
  padding: 0;
  margin: 20px 0;
}

.about-highlights li {
  font-size: 1.05rem;
  margin-bottom: 12px;
  color: #444;
  display: flex;
  align-items: center;
}

.about-highlights li i {
  color: #ff4e00;
  margin-right: 10px;
  font-size: 1.2rem;
}

.about-vision h3 {
  font-size: 1.3rem;
  margin-top: 25px;
  color: #222;
}

.about-vision p {
  font-size: 1rem;
  color: #555;
  line-height: 1.6;
  margin-top: 8px;
}

/* Optional Stats Section */
.about-stats {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  padding: 60px 20px;
  background: linear-gradient(to right, #43cea2, #185a9d);
  gap: 30px;
  margin-top: 40px;
}

.stat-box {
  background-color: #f5f5f5;
  padding: 30px 40px;
  border-radius: 15px;
  text-align: center;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  transition: transform 0.3s;
  min-width: 180px;
}

.stat-box:hover {
  transform: translateY(-8px);
}

.stat-box h3 {
  font-size: 2.5rem;
  color: #ff4e00;
  margin-bottom: 10px;
}

.stat-box p {
  font-size: 1rem;
  color: #555;
}

  </style>
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="logo">StudentSys</div>
    <nav>
      <ul>
        <li><a href="#hero">Home</a></li>
        <li><a href="#dashboard">Dashboard</a></li>
        <li><a href="#signup">Sign Up</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#feedback">Feedback</a></li>
      </ul>
    </nav>
  </header>

  <!-- HERO -->
  <section class="hero" id="hero">
    <h1>Welcome to StudentSys</h1>
    <p>All-in-One Dashboard for Records, Attendance & Progress</p>
    <a href="#signup">Get Started</a>
  </section>

  <!-- DASHBOARD -->
  <section id="dashboard">
    <h2>Interactive Dashboard</h2>
    <div class="cards">
      <div class="card">
        <h3>Student Records</h3>
        <p class="desc">Manage your personal, academic, and admission info.</p>
        <div class="details">Edit profile, upload documents, view admission status.</div>
      </div>
      <div class="card">
        <h3>Attendance</h3>
        <p class="desc">Track your subject-wise daily and monthly attendance.</p>
        <div class="details">Monitor defaulter status and download reports.</div>
      </div>
      <div class="card">
        <h3>Progress</h3>
        <p class="desc">Visualize academic growth and check subject-wise marks.</p>
        <div class="details">Download report cards, see semester comparisons.</div>
      </div>
    </div>
  </section>

  <!-- SIGN UP -->

  <section id="signup">
  <h2>Sign Up</h2>
    <?php

    
    include 'db_connect.php';
    // REGISTER LOGIC (username, name, email, password, role)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $user_id = $_POST['user_id'];
      $name = $_POST['name'];
      $email = $_POST['email'];
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      $role = $_POST['role'];
      $success = "";
      // Check if user_id already exists
      $check_user = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
      $check_user->bind_param("s", $user_id);
      $check_user->execute();
      $result = $check_user->get_result();
    
      if ($result->num_rows > 0) {
          echo "User ID already exists. Please use a different ID.";
      } else {
          $stmt = $conn->prepare("INSERT INTO users (user_id, name, email, password, role) VALUES (?, ?, ?, ?, ?)");
          $stmt->bind_param("sssss", $user_id, $name, $email, $password, $role);
    
          if ($stmt->execute()) {
              $success = "echo'Registration successful. You can now <a href='login.php'>Login</a>.';";
          } else {
              echo "Error: " . $stmt->error;
          }
      }
    }
    
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $user['role'];
    
                // Redirect based on role
                if ($user['role'] == 'student') {
                    header("Location:student_dashboard.php");
                } elseif ($user['role'] == 'teacher') {
                    header("Location:teacher_dashboard.php");
                } else {
                    header("Location:admin_dashboard.php");
                }
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "User not found.";
        }
    }
    
    
    
    ?>
    
      
    
    
    
      <div class="container" id="container">
        <!-- Login Form -->
        <div class="form-container login-container" style="background:linear-gradient(135deg,rgb(24, 90, 157), #43cea2);">
          <form method="POST">
            <h2>Login</h2>
            <?php if (isset($login_error)) echo "<div class='message error'>$login_error</div>"; ?>
            <input type="hidden" name="action" value="login">
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Login</button>
          </form>
        </div>
    
        
      <br><br>

      <script>
        const container = document.getElementById('container');
        const signUpBtn = document.getElementById('signUp');
        const signInBtn = document.getElementById('signIn');
    
        signUpBtn.addEventListener('click', () => {
          container.classList.add("active");
        });
    
        signInBtn.addEventListener('click', () => {
          container.classList.remove("active");
        });
      </script>
      
    
    

    
  </section>
<section class="about" id="about">
  <div class="about-container">
    <div class="about-image">
      <img src="images/about-studentsys.jpg" alt="About StudentSys">
    </div>
    <div class="about-content">
      <h2 class="section-title">About StudentSys</h2>
      <p class="about-description">
        <strong>StudentSys</strong> is a smart student management system designed to simplify academic life. We bring all your records, attendance, and progress tracking into one powerful platform.
      </p>
      <ul class="about-highlights">
        <li><i class="fa-solid fa-user-graduate"></i> Role-Based Access</li>
        <li><i class="fa-solid fa-clipboard-check"></i> Attendance Automation</li>
        <li><i class="fa-solid fa-chart-line"></i> Real-Time Progress</li>
      </ul>
      <a href="#features" class="about-button">Learn More</a>
    </div>

  <!-- Optional: Stats Section -->
  <div class="about-stats">
    <div class="stat-box">
      <h3>100+</h3>
      <p>Students Tracked</p>
    </div>
    <div class="stat-box">
      <h3>20+</h3>
      <p>Teachers Onboarded</p>
    </div>
    <div class="stat-box">
      <h3>95%</h3>
      <p>User Satisfaction</p>
    </div>
    <div class="stat-box">
      <h3>8+</h3>
      <p>Core Modules</p>
    </div>
  </div>
</section>


  <!-- CONTACT -->
  <section id="contact">
    <h2>Contact Us</h2>
    <p>
      Have questions? Feel free to reach out to our support team for assistance.
    </p>
  </section>

  <!-- FEEDBACK -->
  <section id="feedback">
    <h2>Feedback</h2>
    <form>
      <textarea placeholder="Your feedback" rows="5"></textarea>
      <input type="submit" value="Submit Feedback">
    </form>
  </section>
  
  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 StudentSys | All Rights Reserved</p>
  </footer>

  <!-- Go Up Button -->
  <button class="go-up" onclick="scrollToTop()">↑</button>

  <script>
    // Show the Go Up button when scrolling
    window.onscroll = function() {
      let button = document.querySelector('.go-up');
      if (document.documentElement.scrollTop > 500) {
        button.classList.add('visible');
      } else {
        button.classList.remove('visible');
      }
    };

    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Add section visibility animation when in view
    const sections = document.querySelectorAll('section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.2 });

    sections.forEach(section => observer.observe(section));
  </script>
</body>
</html>
