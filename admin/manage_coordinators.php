
<?php session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include the database connection file
include('db_connection.php');

// Check if form is submitted for creating a new coordinator
if (isset($_POST['submit'])) {
    $cd_username = $_POST['cd_username'];
    $cd_password = $_POST['cd_password'];

    // Check if a coordinator with the same username already exists
    $check_sql = "SELECT * FROM coordinators WHERE cd_username = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "s", $cd_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username already exists! Please choose another username.');</script>";
    } else {
        // Insert the new coordinator into the database
        $sql = "INSERT INTO coordinators (cd_username, cd_password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $cd_username, $cd_password);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Coordinator added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding coordinator: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Fetch all coordinators
$sql = "SELECT * FROM coordinators";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching coordinators: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coordinators</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        
        h2, h3 {
            text-align: center;
         
        }
        .table {
            background-color: white;
        }
        .btn {
           
        }
     
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

       
        form {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<div class="container">
    <h2 class="text-black mb-4">Manage Coordinators</h2>

    <!-- Form for adding a new coordinator -->
    <h4 class="text-black text-center ">Create New Coordinator</h4>
    <form method="POST" action="">
        <abel>Username</abel><input type="text" name="cd_username" placeholder="Username" required>
        <abel>password</abel>
        <input type="password" name="cd_password" placeholder="Password" required>
        <input type="submit" name="submit" value="Add Coordinator" class="btn btn-info">
    </form>

    <!-- Coordinators Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th> <!-- Added column for password -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($coordinator = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $coordinator['cd_id']; ?></td>
                    <td><?php echo $coordinator['cd_username']; ?></td>
                    <td>
    <?php echo $coordinator['cd_password']; ?>
</td>

                    <td>
                        <a href="assign_event.php?id=<?php echo $coordinator['cd_id']; ?>" class="btn btn-primary btn-sm">Assign Events</a>
                        <a href="edit_coordinator.php?id=<?php echo $coordinator['cd_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_coordinator.php?id=<?php echo $coordinator['cd_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap and Icon Library -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

<script>
    // Function to toggle password visibility
    function togglePassword(id) {
        const passwordSpan = document.getElementById('password-' + id);
        const toggleButton = document.getElementById('toggle-' + id);

        if (passwordSpan.style.display === 'none') {
            // Show password
            passwordSpan.style.display = 'inline';
            toggleButton.innerHTML = '<i class="bi bi-eye"></i> Hide';
        } else {
            // Hide password
            passwordSpan.style.display = 'none';
            toggleButton.innerHTML = '<i class="bi bi-eye-slash"></i> Show';
        }
    }
</script>

</body>
</html>
