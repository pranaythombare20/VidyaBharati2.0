<?php
include 'db_connect.php'; // Include database connection

$message = "";

// Fetch progress records with student roll numbers
$progress_records = $conn->query("
    SELECT sm.id, sm.subject, s.roll_number, s.name 
    FROM student_marks sm
    JOIN students s ON sm.student_id = s.id
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['progress_id']) && !empty($_POST['progress_id'])) {
        $progress_id = $_POST['progress_id'];

        // Check if the record exists before deleting
        $stmt = $conn->prepare("SELECT id FROM student_marks WHERE id = ?");
        $stmt->bind_param("i", $progress_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Record exists, proceed with deletion
            $stmt = $conn->prepare("DELETE FROM student_marks WHERE id = ?");
            $stmt->bind_param("i", $progress_id);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Progress record deleted successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error deleting record: " . $stmt->error . "</div>";
            }
        } else {
            $message = "<div class='alert alert-warning'>No such record found!</div>";
        }

        $stmt->close();
    } else {
        $message = "<div class='alert alert-danger'>Invalid request.</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student Progress</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Delete Student Progress</h2>

        <!-- Display messages -->
        <?php echo $message; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Search Progress Record</label>
                <input type="text" id="search" class="form-control" placeholder="Search by Progress ID, Roll No, Name, or Subject">
            </div>

            <div class="mb-3">
                <label class="form-label">Select Progress Record</label>
                <select name="progress_id" id="progress-select" class="form-control" required>
                    <option value="">-- Select Progress Record --</option>
                    <?php while ($row = $progress_records->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" data-search="<?= strtolower($row['id'] . ' ' . $row['roll_number'] . ' ' . $row['name'] . ' ' . $row['subject']) ?>">
                            <?= "Progress ID: " . $row['id'] . " | Roll No: " . $row['roll_number'] . " | Name: " . $row['name'] . " | Subject: " . $row['subject'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-danger">Delete Progress</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#progress-select option").each(function() {
                    var text = $(this).data("search");
                    if (text.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
