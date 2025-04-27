
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
}


// Handle login form submission
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
                header("Location: student_dashboard.php");
                exit();
            } elseif ($user['role'] == 'teacher') {
                header("Location: teacher_dashboard.php");
                exit();
            } else {
                header("Location: admin_dashboard.php");
                exit();
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "User not found.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
/* Basic Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #6e8efb, #a777e3);
}

/* Login Card Container */
.login-container {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
  padding: 40px 30px;
  width: 350px;
  animation: fadeIn 1s ease-in-out;
}

.login-container h2 {
  text-align: center;
  color: white;
  margin-bottom: 24px;
}

/* Form Styling */
.login-container input[type="email"]
{
  width: 100%;
  padding: 12px 15px;
  margin: 10px 0;
  border: none;
  outline: none;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.2);
  color: white;
  font-size: 16px;
}
.login-container input[type="password"] {
  width: 100%;
  padding: 12px 15px;
  margin: 10px 0;
  border: none;
  outline: none;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.2);
  color: white;
  font-size: 16px;
}

.login-container input::placeholder {
  color: #eee;
}

.login-container input[type="submit"] {
  width: 100%;
  padding: 12px;
  margin-top: 16px;
  background-color: #7f5af0;
  border: none;
  border-radius: 10px;
  color: white;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
}

.login-container button:hover {
  background-color: #9a6cff;
  transform: scale(1.03);
}

/* Animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

</head>
<body>
<div class="login-container">
    <form method="POST">
        <h2>Login</h2>

        <?php 
        // Show error messages if any
        if (isset($error)) {
            echo "<p class='error-message'>$error</p>";
        }
        ?>

        <input type="email" name="email" placeholder="Enter Email" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
        <input type="submit" value="Login">
        <br>
        <br>
        <center>  <p><h5>Don't have an account? <a href="register.php">Sign up here</a></h5></p></center>
       
    </form>
    </div>
</body>
</html>
