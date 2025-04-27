<?php
session_start();
include 'db_connect.php'; // Database connection

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_msg = $error_msg = "";

// Handle password change request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current password hash from database
    $query = "SELECT password FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $db_password = $row['password'];

        // Verify old password
        if (!password_verify($old_password, $db_password)) {
            $error_msg = "Incorrect old password!";
        } elseif ($new_password !== $confirm_password) {
            $error_msg = "New passwords do not match!";
        } elseif (strlen($new_password) < 8) {
            $error_msg = "Password must be at least 8 characters!";
        } else {
            // Hash new password and update in database
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password = ? WHERE user_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, "si", $hashed_password, $user_id);
            mysqli_stmt_execute($update_stmt);

            $success_msg = "Password updated successfully!";
        }
    } else {
        $error_msg = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; }
        .container { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        h2 { text-align: center; }
        label { font-weight: bold; }
        input { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .message { text-align: center; font-weight: bold; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>

<div class="container">
    <h2>Change Password</h2>
    
    <?php if ($error_msg): ?>
        <p class="message error"><?php echo $error_msg; ?></p>
    <?php endif; ?>
    
    <?php if ($success_msg): ?>
        <p class="message success"><?php echo $success_msg; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Old Password:</label>
        <input type="password" name="old_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Update Password</button>
    </form>

    <a href="profile.php">Back to Profile</a>
</div>

</body>
</html>
