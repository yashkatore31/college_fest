<?php
// Start session
session_start();

// Include the database connection file
include('db_connection.php');

// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch students data from the database
$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);

// Handle student deletion
if (isset($_GET['delete_id'])) {
    $student_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM students WHERE id = $student_id";
    mysqli_query($conn, $delete_query);
    header('Location: manage_students.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <!-- Include Bootstrap for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
     <!-- Navbar -->
<?php include('header.php'); ?>


    <div class="container mt-4">
        <h2 class="text-dark mt-4">Manage Students</h2>
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td>
                            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="manage_students.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
