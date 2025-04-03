<?php
// admin_profile.php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_username'])) {
    header('Location: login.php');
    exit();
}

// Get the admin details
$admin_username = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .content h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .content h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            font-size: 16px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>
    <div class="container content">
        <h1>Admin Profile</h1>
        <h2>Welcome, <?php echo htmlspecialchars($admin_username); ?>!</h2>
        <p>You can update your profile details here.</p>

        <form action="update_profile.php" method="POST">
            <div class="mb-3">
                <label for="admin_username" class="form-label">Username</label>
                <input type="text" class="form-control" id="admin_username" name="admin_username" value="<?php echo htmlspecialchars($admin_username); ?>" required>
            </div>

            <div class="mb-3">
                <label for="admin_password" class="form-label">Password</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>

            <button type="submit" class="btn btn-info">Update Profile</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
