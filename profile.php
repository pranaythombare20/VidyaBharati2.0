<?php
session_start();
include 'db_connect.php'; // Database connection

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Logged-in user ID

// Fetch user profile details from database
$query = "SELECT name, email, role FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $email = $row['email'];
    $role = ucfirst($row['role']); // Capitalize role for display
} else {
    die("Error fetching profile: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; }
        .container { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h2 { text-align: center; }
        label { font-weight: bold; }
        input { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; }
        .readonly { background-color: #f5f5f5; cursor: not-allowed; }
        .back-btn { display: block; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Profile Settings</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="readonly" readonly>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="readonly" readonly>

        <label>Role:</label>
        <input type="text" name="role" value="<?php echo htmlspecialchars($role); ?>" class="readonly" readonly>

        <a href="<?php echo strtolower($role); ?>_password.php" class="back-btn">Change Password</a>

        <a href="<?php echo strtolower($role); ?>_dashboard.php" class="back-btn">Go Back</a>
    </form>
</div>

</body>
</html>
