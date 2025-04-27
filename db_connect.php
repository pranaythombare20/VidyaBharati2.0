
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_tracking_db";

try {
    // Create a new PDO instance
    $conn = new PDO("mysql:host=127.0.0.1;dbname=$database", $username, $password);


    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!-- error:
Connection failed: could not find driver -->