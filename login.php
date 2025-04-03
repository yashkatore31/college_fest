<?php
session_start();
include("config.php");

$error = "";
$msg = "";

// Redirect logged-in users away from login page
if (isset($_SESSION['id'])) {
    header("Location: index.php");  // Redirect to home page if already logged in
    exit();
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    // Collect and sanitize input data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate input fields
    if (!empty($email) && !empty($password)) {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM students WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);  // "s" for string
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Check if the password matches using password_verify
            if (password_verify($password, $row['password'])) {
                // Password is correct, start a session
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['department'] = $row['department'];
                $_SESSION['year'] = $row['year'];
                $_SESSION['prn_number'] = $row['prn_number'];

                // Redirect to the dashboard or home page
                header("Location: index.php");
                exit();  // Ensure no further code is executed after the redirect
            } else {
                $error = "<p class='alert alert-danger'>Incorrect password. Please try again.</p>";
            }
        } else {
            $error = "<p class='alert alert-danger'>No user found with that email. Please check and try again.</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        $error = "<p class='alert alert-warning'>Please enter both email and password.</p>";
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
    <title>Login</title>
    
    <style>
        body {
            background-color: #f7f7f7;
        }

        .login-wrapper {
            max-width: 1000px;
            margin: 50px auto;
            background: #fff;
            padding: 60px;
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

    <!-- Login Form -->
    <div class="login-wrapper">
        <h2 class="text-center">Student Login</h2>
        <!-- Display error or success messages -->
        <?php echo $error; ?>
        <?php echo $msg; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <!-- Footer Include -->
    <?php include("include/footer.php"); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
