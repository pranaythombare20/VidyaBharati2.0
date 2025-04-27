<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['toggle_edit'])) {
    $student_id = $_POST['student_id'];
    $new_status = $_POST['status'];

    $query = "UPDATE students SET is_editable='$new_status' WHERE id='$student_id'";
    mysqli_query($conn, $query);
    echo "<script>alert('Edit permission updated!'); window.location='admin_dashboard.php';</script>";
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Manage Students</title>
</head>
<body>
    <h2>Admin - Manage Student Records</h2>
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Edit Permission</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['is_editable'] == 1 ? 'Editable' : 'Locked' ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="student_id" value="<?= $row['id'] ?>">
                    <select name="status">
                        <option value="1" <?= $row['is_editable'] == 1 ? 'selected' : '' ?>>Allow Edit</option>
                        <option value="0" <?= $row['is_editable'] == 0 ? 'selected' : '' ?>>Lock Edit</option>
                    </select>
                    <button type="submit" name="toggle_edit">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
