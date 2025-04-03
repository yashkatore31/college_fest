<?php
// Start the session
session_start();

// Include the database connection file (adjust with your actual connection details)
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];

    // Hash the input password
    $hashed_password = md5($password);

    // Check if the username and password are correct
    $query = "SELECT * FROM admins WHERE admin_username = ? AND admin_password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a match is found, start a session and redirect to the admin panel
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_username'] = $admin['admin_username'];
        header("Location: index.php");
        exit;
    } else {
        // If login fails
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    
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
<?php include('header.php'); ?>
<div class="login-wrapper">
        <h2 class="text-center">admin Login</h2>
        <!-- Display error or success messages -->
        <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php } ?>

       
<form method="POST" action="login.php">
        <div class="form-group">
            <label for="admin_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="admin_username" name="admin_username" required>
        </div>
        <div class="mb-3">
            <label for="admin_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="admin_password" name="admin_password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- ------------------ -->

