<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit();
}

// Database connection
include('db_connection.php');

// Get the admin's current username from the session
$admin_username = $_SESSION['admin_username'];

// Initialize variables for success and error messages
$success_message = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated values from the form
    $new_username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $new_password = mysqli_real_escape_string($conn, $_POST['admin_password']);

    // Hash the password using MD5
    $hashed_password = md5($new_password);

    // SQL query to update the admin details
    $query = "UPDATE admins SET admin_username = '$new_username', admin_password = '$hashed_password' WHERE admin_username = '$admin_username'";

    if (mysqli_query($conn, $query)) {
        // If the update is successful, update the session username and set success message
        $_SESSION['admin_username'] = $new_username;
        $success_message = "Profile updated successfully!";
        header('Location: update_profile.php?status=success'); // Redirect to show the alert
        exit();
    } else {
        // If the update fails, set error message
        $error_message = "Error updating profile: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        #navbar {
            background-color: #333;
            overflow: hidden;
        }
        #navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        #navbar li {
            display: inline;
        }
        #navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
        }
        #navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .content {
            padding: 30px;
            background-color: #fff;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .content h1 {
            margin-bottom: 20px;
        }
        .content label {
            font-size: 16px;
            margin-bottom: 8px;
            display: inline-block;
        }
        .content input[type="text"], .content input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .content button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .content button:hover {
            background-color: #45a049;
        }
        .alert {
            color: red;
            margin-bottom: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div id="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="admin_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Update Admin Profile</h1>
        <p>Update your username and password.</p>

        <?php if ($error_message): ?>
            <div class="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="update_profile.php" method="POST">
            <label for="admin_username">Username</label>
            <input type="text" id="admin_username" name="admin_username" value="<?php echo htmlspecialchars($admin_username); ?>" required>

            <label for="admin_password">Password</label>
            <input type="password" id="admin_password" name="admin_password" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <script type="text/javascript">
            alert('Profile updated successfully!');
        </script>
    <?php endif; ?>

</body>
</html>
