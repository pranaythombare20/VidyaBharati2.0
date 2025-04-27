<?php
include 'db_connect.php';

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

<style>
<style>
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

    .signup-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      padding: 40px 30px;
      width: 380px;
      animation: fadeIn 1s ease-in-out;
    }

    .signup-container h2 {
      text-align: center;
      color: white;
      margin-bottom: 24px;
    }

    .signup-container input[type="text"],
    .signup-container input[type="email"],
    .signup-container input[type="password"],select {
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

    .signup-container input::placeholder {
      color: #eee;
    }

    .signup-container input[type="submit"] {
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

    .signup-container button:hover {
      background-color: #9a6cff;
      transform: scale(1.03);
    }

    .signup-container p {
      color: white;
      margin-top: 16px;
      text-align: center;
    }

    .signup-container p a {
      color: #fff;
      text-decoration: underline;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
  <div class="signup-container">
<form method="POST">
    <input type="text" name="user_id" required><br>
    <input type="text" name="name" required><br>
    <input type="email" name="email" required><br>
    <input type="password" name="password" required><br>
    Role:
    <select name="role" required>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
        <option value="admin">Admin</option>
    
    </select><br>
    <input type="submit" value="Register">

</form>
</div>