<?php
session_start();
include("config.php");

$error = "";
$msg = "";

// Function to validate PRN number from valid_member_id.txt
function isValidPrnNumber($prn_number) {
    $file_path = 'data/valid_member_id.txt';
    
    // Check if file exists and is readable
    if (!file_exists($file_path)) {
        return false; // File doesn't exist
    }

    // Read file contents into an array
    $valid_ids = file($file_path, FILE_IGNORE_NEW_LINES);
    return in_array($prn_number, $valid_ids);
}

// Process the form submission
if (isset($_POST['register'])) {
    // Collect input data and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $prn_number = mysqli_real_escape_string($conn, $_POST['prn_number']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Validate the PRN number
    if (!isValidPrnNumber($prn_number)) {
        $error = "<p class='alert alert-warning'>Invalid PRN Number. Please try again.</p>";
    } else {
        // Check if the PRN number already exists in the database using prepared statement
        $stmt_check_prn = $conn->prepare("SELECT * FROM students WHERE prn_number = ? LIMIT 1");
        $stmt_check_prn->bind_param("s", $prn_number); // 's' denotes a string
        $stmt_check_prn->execute();
        $result_prn = $stmt_check_prn->get_result();

        if ($result_prn->num_rows > 0) {
            $error = "<p class='alert alert-warning'>This PRN Number is already registered. Please use a different PRN.</p>";
        } else {
            // Check if the email already exists in the database using prepared statement
            $stmt_check_email = $conn->prepare("SELECT * FROM students WHERE email = ? LIMIT 1");
            $stmt_check_email->bind_param("s", $email); // 's' denotes a string
            $stmt_check_email->execute();
            $result_email = $stmt_check_email->get_result();

            if ($result_email->num_rows > 0) {
                $error = "<p class='alert alert-warning'>Email already registered. Please use a different email.</p>";
            } else {
                // Insert the student data into the database using prepared statement
                $stmt_insert = $conn->prepare("INSERT INTO students (name, email, phone, department, year, prn_number, password, created_at) 
                                              VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt_insert->bind_param("sssssss", $name, $email, $phone, $department, $year, $prn_number, $password);
                $result_insert = $stmt_insert->execute();

                if ($result_insert) {
                    $msg = "<p class='alert alert-success'>Registration successful! You can now <a href='login.php'>Login</a>.</p>";
                } else {
                    $error = "<p class='alert alert-danger'>Registration failed. Please try again.</p>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Register</title>

    <style>
        body {
            background-color: #f7f7f7;
        }

        .register-wrapper {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
        }

        .alert {
            margin-top: 15px;
        }

        .btn-block {
            padding: 12px;
            font-size: 18px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>
<body>

    <!-- Header Include -->
    <?php include("include/header.php"); ?>

    <!-- Registration Form -->
    <div class="register-wrapper">
        <h2 class="text-center">Student Registration</h2>
        <!-- Display error or success messages -->
        <?php echo $error; ?>
        <?php echo $msg; ?>

        <form method="POST">
            <!-- Removed Student ID Field -->
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <select name="department" class="form-control" id="department" required>
                    <option value="BBA(CA)">BBA(CA)</option>
                    <option value="BBA">BBA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <select name="year" class="form-control" id="year" required>
                    <!-- Dynamic options will be loaded here -->
                </select>
            </div>
            <div class="form-group">
                <label for="prn_number">ID No</label>
                <input type="text" name="prn_number" class="form-control" id="prn_number" placeholder="Enter your ID number" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
        </form>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <!-- Footer Include -->
    <?php include("include/footer.php"); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        // Dynamically load the year options based on department selection
        document.getElementById('department').addEventListener('change', function() {
            var department = this.value;
            var yearSelect = document.getElementById('year');
            yearSelect.innerHTML = ''; // Clear existing options

            if (department === 'BBA(CA)') {
                var years = ['FYBBA(CA)', 'SYBBA(CA)', 'TYBBA(CA)'];
            } else {
                var years = ['FYBBA', 'SYBBA', 'TYBBA'];
            }

            // Populate year options dynamically
            years.forEach(function(year) {
                var option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            });
        });

        // Trigger the change event to load initial year options
        document.getElementById('department').dispatchEvent(new Event('change'));
    </script>

</body>
</html>
