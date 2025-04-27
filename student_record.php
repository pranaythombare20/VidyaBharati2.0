<?php include 'header.php'; ?>
<?php
include 'db_connect.php';

// Redirect if not logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$fields = [
    'roll_number' => 'Roll Number', 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'dob' => 'DOB',
    'address' => 'Address', 'course' => 'Course', 'year' => 'Year',
    'guardian_name' => 'Guardian Name', 'guardian_contact' => 'Guardian Contact',
    'admission_date' => 'Admission Date', 'gender' => 'Gender'
];

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch student record
$query = "SELECT * FROM students WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$record_exists = ($result && mysqli_num_rows($result) > 0);
$row = $record_exists ? mysqli_fetch_assoc($result) : null;

// Handle form submission (only if record doesn't exist)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$record_exists) {
    $data = [];
    foreach ($fields as $key => $label) {
        $data[$key] = mysqli_real_escape_string($conn, $_POST[$key]);
    }
    $query = "INSERT INTO students (id, roll_number, name, email, phone, dob, address, course, year, guardian_name, guardian_contact, admission_date, gender)
              VALUES ('$user_id', '{$data['roll_number']}', '{$data['name']}', '{$data['email']}', '{$data['phone']}', '{$data['dob']}', '{$data['address']}', '{$data['course']}',
                      '{$data['year']}', '{$data['guardian_name']}', '{$data['guardian_contact']}', '{$data['admission_date']}', '{$data['gender']}')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Record submitted successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p class='text-danger text-center'>Error: " . mysqli_error($conn) . "</p>";
    }
}
$role=$_SESSION['role']; // Get the role from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Body Styling */
        body {
            font-family: 'Times New Roman', sans-serif;
            background: linear-gradient(135deg, #fdfbfb, #ebedee);
            animation: gradientAnimation 15s ease infinite;
            background-size: 400% 400%;
            color:white;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container Styling */
        .container {
            margin: 50px auto;
            padding: 10px;
            max-width:fit-content;
            min-width: 1200px;
            border-radius: 15px;
            background:white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        /* Card Styling */
        .card {
            background: linear-gradient(135deg, #43cea2,rgb(24, 90, 157));
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease-in-out;
            color:black;
                }

        .card:hover {
            transform: scale(1.02);
        }

        /* Table Styling */
        table {
            width:100%;
            border-collapse: collapse;
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 10px;
            text-align: center;
           
        }

        th {
            color:black;
            background: linear-gradient(135deg,rgb(67, 207, 162));
            text-transform: uppercase;
      
        }

        td {
            background:;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        tr:hover td {
            border:solid 1px black;
            color:black;
            background:wheat;
           
        }

        /* Button Styling */
        .btn-custom {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(106, 17, 203, 0.5);
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(106, 17, 203, 0.8);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(255, 65, 108, 0.5);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 65, 108, 0.8);
        }

        .btn-back {
            display: inline-block;
            background: linear-gradient(135deg, #43cea2, #185a9d);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(67, 206, 162, 0.5);
            width: 200px;
            margin: 20px auto;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #185a9d, #43cea2);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(67, 206, 162, 0.8);
        }

        /* Form Styling */        

        .form-label {
            font-weight: bold;
            color: #fff;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        }
        hr{
            border: 2px solid white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <hr>
        <?php if ($role == 'student'): ?>
            <?php if ($record_exists): ?>
                <div class="container">
                <h3><b><big>Your Submitted Details</big></b></h3>
            </div>
                <hr>
                <div class="container">
                <table class="table table-bordered">
                    <?php foreach ($fields as $key => $label): ?>
                        <tr>
                            <th style="color:white;"><?= $label ?></th>
                            <td style="color:black;"><?= htmlspecialchars($row[$key]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                    </div>
                <p class="text-warning">You cannot edit your details after submission.</p>
            <?php else: ?>
                <div class="container" style="width:90%;">
               <big><b><p class="text-danger">No record found. Please enter your details below.</p></b></big>
            </div>
            <hr>
                <form method="POST" class="row g-3">
                    <?php foreach ($fields as $key => $label): ?>
                        <div class="col-md-6">
                            <label class="form-label"><?= $label ?></label>
                            <input type="text" name="<?= $key ?>" class="form-control" required>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-custom">Submit</button>
                    </div>
                </form>
            <?php endif; ?>
           
        <?php endif; ?>
        
       
        
                  
        <?php if ($role == 'teacher' || $role == 'admin'): ?>
            <div class="container" style="width:fit-content;">
            <h3 class="text-center mt-4">All Student Records</h3>
            </div>
            <hr>
            <div class="container" style="width:fit-content;">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Guardian</th>
                    <th>Guardian Contact</th>
                    <th>Admission Date</th>
                    <?php if ($role == 'admin') echo "<th>Actions</th>"; ?>
                </tr>
                <?php
                $query = "SELECT * FROM students";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['roll_number'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['dob'] ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['course'] ?></td>
                    <td><?= $row['year'] ?></td>
                    <td><?= $row['guardian_name'] ?></td>
                    <td><?= $row['guardian_contact'] ?></td>
                    <td><?= $row['admission_date'] ?></td>
                    <?php if ($role == 'admin'): ?>
                        <td>
                            <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-custom">Edit</a> |
                            <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        
        <?php endif; ?>
       
    </div>
</div>


<?php include 'footer.php'; ?>
</body>
</html>

