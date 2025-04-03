<?php
// Include the database connection file
include('db_connection.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $cd_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the coordinator's data
    $sql = "SELECT * FROM coordinators WHERE cd_id = '$cd_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Coordinator not found!'); window.location.href='manage_coordinators.php';</script>";
        exit;
    }

    $coordinator = mysqli_fetch_assoc($result);
}

// Handle form submission for updating coordinator details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cd_username = mysqli_real_escape_string($conn, $_POST['cd_username']);
    $cd_password = mysqli_real_escape_string($conn, $_POST['cd_password']);

    // Update coordinator details
    $sql_update = "UPDATE coordinators SET cd_username = '$cd_username', cd_password = '$cd_password' WHERE cd_id = '$cd_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Coordinator updated successfully!'); window.location.href='manage_coordinators.php';</script>";
    } else {
        echo "<script>alert('Error updating coordinator: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Coordinator</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<?php include('header.php'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
    <h4 class="text-center mb-3">Edit Coordinator</h4>
        <div class="col-md-6">
            <div class="card shadow-lg">
                
                <div class="card-body">
                    <!-- Form for editing coordinator details -->
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="cd_username" class="form-control" value="<?php echo $coordinator['cd_username']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="cd_password" class="form-control" placeholder="Enter New Password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="update" class="btn btn-info">Update Coordinator</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="manage_coordinators.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (For interactive components like alerts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
