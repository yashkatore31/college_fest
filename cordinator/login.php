<?php
session_start();
include("../config.php");

$error = "";
$msg = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
$password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "<p class='alert alert-warning'>Please fill in both fields.</p>";
    } else {
        // Check the database for the user
        $stmt = $conn->prepare("SELECT * FROM coordinators WHERE cd_username = ? AND cd_password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Successful login
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "<p class='alert alert-danger'>Invalid username or password.</p>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Coordinator Login</title>
    
    <style>
        body {
            background-color: #f7f7f7;
        }

        .login-wrapper {
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
    <?php include("header.php"); ?>

    <!-- Login Form -->
    <div class="login-wrapper">
        <h2 class="text-center">Coordinator Login</h2>
        <!-- Display error or success messages -->
        <?php echo $error; ?>
        <?php echo $msg; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>

    <!-- Footer Include -->
    <?php include("footer.php"); ?>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>
</html>
