
<?php
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
?>

    <body>
        
    </body>
<form method="POST">
     <input type="email" name="email" placeholder="Enter Email" required><br>
        <input type="password" name="password" placeholder="Enter Password" required><br>
    <input type="submit" value="Login">
    <p><h5>Don't have an account? <a href="register.php">Sign up here</h5></a></p>
</form>
<?php include 'footer.php'; ?>