<?php
session_start();

include 'db_connect.php';

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
   
    $stmt->close();
   
}

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



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login & Registration</title>
  <style>
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg,rgb(32, 173, 126),rgb(25, 94, 162));
      margin-top: 50px;
      display:block;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    .container {
  
      margin:auto;
      width: 900px;
      height: 550px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 15px 25px rgba(47, 46, 46, 0.5);
      backdrop-filter: blur(10px);
    }

    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      width: 50%;
      padding: 50px;
      transition: all 0.6s ease-in-out;
    }

    .login-container {
      left: 0;
      z-index: 2;
    }

    .register-container {
      left: 0;
      opacity: 0;
      z-index: 1;
    }

    .container.active .register-container {
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
      animation: show 0.6s;
    }

    .container.active .login-container {
      transform: translateX(100%);
      opacity: 0;
      z-index: 1;
    }

    @keyframes show {
      0% {
        opacity: 0;
        transform: scale(0.95);
      }
      100% {
        opacity: 1;
        transform: scale(1);
      }
    }

    form {
      display: flex;
      flex-direction: column;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #fff;
    }

    input,
    select {
      padding: 12px;
      margin: 8px 0;
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 14px;
    }

    input::placeholder {
      color: #ccc;
    }

    button {
      margin-top: 20px;
      padding: 12px;
      border: none;
      background: linear-gradient(135deg, #43cea2, #185a9d);
      color: white;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: linear-gradient(135deg, #185a9d, #43cea2);
    }

    .toggle-panel {
      position: absolute;
      right: 0;
      width: 50%;
      height: 100%;
      background: linear-gradient(to right, #43cea2, #185a9d);
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      transition: transform 0.6s ease-in-out;
    }

    .toggle-panel h1 {
      font-size: 28px;
      margin-bottom: 20px;
    }

    .toggle-panel p {
      font-size: 16px;
      margin-bottom: 30px;
    }

    .toggle-panel button {
      background: white;
      color: #185a9d;
      border: 1px solid white;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .toggle-panel button:hover {
      background: #f0f0f0;
    }

    .container.active .toggle-panel {
      transform: translateX(-100%);
    }

    .message {
      margin: 10px 0;
      text-align: center;
      font-weight: bold;
    }

    .error {
      color: #ff4b2b;
    }

    .success {
      color: #43cea2;
    }
        /* Header & Navigation */
        header {
     background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
        color:black;
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.15);
      backdrop-filter: blur(8px);
      border-bottom:solid 5px rgba(255, 255, 255, 0.518);
    }
    
    .logo {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8rem;
      font-weight: 600;
      letter-spacing: 1px;
      color: var(--white);
    }
    
    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    
    nav ul li {
      transition: color var(--transition-speed);
    }
    
    nav ul li a {
      padding: 8px 12px;
      border-radius: 4px;
      color: var(--accent-color);
      font-weight: 500;
    }
    
    nav ul li a:hover,
    nav ul li a.active {
      background: var(--accent-color);
      color: var(--white);
    }
    
    .hamburger {
      display: none;
      font-size: 1.8rem;
      cursor: pointer;
      color: var(--white);
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

<div style="margin-left:310px;"><a href="try2.html" class="btn-back">⬅ Back to Home</a></div>

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

    <!-- Registration Form -->
    <div class="form-container register-container" style="background:linear-gradient(135deg,rgb(24, 90, 157), #43cea2);">
      <form method="POST">
        <h2>Register</h2>
        <?php
        if (isset($register_success)) echo "<div class='message success'>$register_success</div>";
        if (isset($register_error)) echo "<div class='message error'>$register_error</div>";
        ?>
        <input type="hidden" name="action" value="register">
        <input type="text" name="user_id" placeholder="Username" required />
        <input type="text" name="name" placeholder="Full Name" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <select name="role" required>
          <option value="" disabled selected>Select Role</option>
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
          <option value="admin">Admin</option>
        </select>
        <button type="submit">Register</button>
      </form>
    </div>

    <!-- Toggle Panel -->
    <div class="toggle-panel" id="togglePanel">
      <div>
        <h1>Welcome Back!</h1>
        <p>If you already have an account, login here.</p>
        <button id="signIn">Sign In</button>
        <br>
        <br>
        <br>
        <hr style="border: 2px solid  rgba(255, 255, 255, 0.2); width: 110%; margin: 20px auto;" />  
        <br>
        <br>
      
        <h1>New Here?</h1>
        <p>Register now to access your dashboard.</p>
        <button id="signUp">Sign Up</button>
      </div>
      
    </div>
    
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
  
</body>

</html>
