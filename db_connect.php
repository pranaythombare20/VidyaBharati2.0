<?php
$servername = "127.0.0.1"; // Use 127.0.0.1 instead of localhost
$username = "root";
$password = "";
$database = "student_tracking_db";
$port = "3307"; // Replace with your desired port number

try {
    // Create a new PDO instance with the custom port
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>