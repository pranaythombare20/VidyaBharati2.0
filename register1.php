<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "student_tracking_db");

if ($mysqli->connect_error) {
    die("Failed to connect: " . $mysqli->connect_error);
}

// Registration Handling
$regMsg = $loginMsg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $user_id = $mysqli->real_escape_string($_POST['user_id']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $check = $mysqli->query("SELECT * FROM users WHERE user_id = '$user_id'");
    if ($check->num_rows > 0) {
        $regMsg = "User ID already exists.";
    } else {
        $mysqli->query("INSERT INTO users (user_id, username, password, role) VALUES ('$user_id', '$username', '$password', '$role')");
        $regMsg = "Registration successful!";
    }
}

// Login Handling
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $user_id = $mysqli->real_escape_string($_POST['user_id']);
    $password = $_POST['password'];

    $res = $mysqli->query("SELECT * FROM users WHERE user_id = '$user_id'");
    if ($res->num_rows == 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            header("Location: {$user['role']}_dashboard.php");
            exit();
        } else {
            $loginMsg = "Incorrect password.";
        }
    } else {
        $loginMsg = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Grilli-Inspired Login & Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Roboto&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }
    body {
      background: #111;
      color: #fff;
      display: flex; justify-content: center; align-items: center;
      height: 100vh;
      background-image: url('https://grilli.qodeinteractive.com/wp-content/uploads/2021/10/home-1-slider-img-1.jpg');
      background-size: cover;
      background-position: center;
      backdrop-filter: blur(5px);
    }
    .container {
      background: rgba(0,0,0,0.7);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(255, 255, 255, 0.1);
      max-width: 420px;
      width: 100%;
    }
    h2 {
      font-family: 'Playfair Display', serif;
      text-align: center;
      margin-bottom: 25px;
      font-size: 28px;
      color: #e9b44c;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    input, select {
      padding: 10px;
      border: none;
      border-radius: 5px;
      background: #222;
      color: #fff;
      outline: none;
    }
    button {
      padding: 10px;
      background: #e9b44c;
      border: none;
      border-radius: 5px;
      color: #111;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover {
      background: #fff;
      color: #111;
    }
    .toggle-link {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
    }
    .toggle-link a {
      color: #e9b44c;
      text-decoration: none;
    }
    .message {
      text-align: center;
      color: #f77;
      margin-top: -10px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<div class="container" id="login-box">
  <h2>Login</h2>
  <form method="POST">
    <input type="text" name="user_id" placeholder="User ID" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit" name="login">Login</button>
    <div class="message"><?php echo $loginMsg; ?></div>
  </form>
  <div class="toggle-link">Don't have an account? <a href="#" onclick="toggleForms()">Register</a></div>
</div>

<div class="container" id="register-box" style="display: none;">
  <h2>Register</h2>
  <form method="POST">
    <input type="text" name="user_id" placeholder="User ID" required />
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <select name="role" required>
      <option value="">Select Role</option>
      <option value="student">Student</option>
      <option value="teacher">Teacher</option>
      <option value="admin">Admin</option>
    </select>
    <button type="submit" name="register">Register</button>
    <div class="message"><?php echo $regMsg; ?></div>
  </form>
  <div class="toggle-link">Already have an account? <a href="#" onclick="toggleForms()">Login</a></div>
</div>

<script>
  function toggleForms() {
    const loginBox = document.getElementById('login-box');
    const registerBox = document.getElementById('register-box');
    loginBox.style.display = loginBox.style.display === "none" ? "block" : "none";
    registerBox.style.display = registerBox.style.display === "none" ? "block" : "none";
  }
</script>
</body>
</html>
