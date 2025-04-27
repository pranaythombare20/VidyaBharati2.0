<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_tracking_db";

// Using the procedural style
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
