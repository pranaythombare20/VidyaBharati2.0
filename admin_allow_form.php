<?php include 'header.php'; ?>
<?php

include 'db_connect.php'; // Ensure $pdo is initialized in db_connect.php

$pdo = new PDO("mysql:host=localhost;dbname=student_tracking_db", "root", "");  //      // Update with your database credentials
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Check admin login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete user
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $delete_query = "DELETE FROM users WHERE user_id = :user_id";
    $stmt_delete = $pdo->prepare($delete_query);

    if ($stmt_delete->execute([':user_id' => $user_id])) {
        echo "<script>alert('User deleted successfully!'); window.location='admin_allow_form.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location='admin_allow_form.php';</script>";
    }
}

// Fetch all users
$users_query = "SELECT * FROM users";
$stmt_users = $pdo->query($users_query);
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        header .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 1rem;
        }

        header nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header nav a:hover {
            color: #ffc107;
        }

        h2 {
            text-align: center;
            margin: 2rem 0;
            color: #1e3c72;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem auto;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #1e3c72;
            color: #fff;
            text-transform: uppercase;
        }

        tr:hover {
            background: #f1f1f1;
        }

        form {
            display: inline;
        }

        button {
            padding: 0.5rem 1rem;
            border: none;
            background-color: #e74c3c;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #c0392b;
        }

        footer {
            background: #1e3c72;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<br>
<center><h1 style="color:darkblue;">Manage Users</h1></center>
<div class="container">
<table>
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['user_id']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['role']) ?></td>
        <td>
            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']) ?>">
                <button type="submit" name="delete_user">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</div>

</body>
</html>
<?php include 'footer.php'; ?>