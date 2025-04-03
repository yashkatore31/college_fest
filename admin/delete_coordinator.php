<?php
// Include the database connection file
include('db_connection.php');

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $cd_id = $_GET['id'];

    // SQL query to delete the coordinator based on the ID
    $sql = "DELETE FROM coordinators WHERE cd_id = '$cd_id'";

    if (mysqli_query($conn, $sql)) {
        // Redirect back to the manage_coordinators.php page after successful deletion
        echo "<script>alert('Coordinator deleted successfully!'); window.location.href = 'manage_coordinators.php';</script>";
    } else {
        // Display error if the deletion fails
        echo "<script>alert('Error deleting coordinator: " . mysqli_error($conn) . "');</script>";
    }
} else {
    // If no ID is passed, show an error
    echo "<script>alert('Invalid request. No coordinator ID found.'); window.location.href = 'manage_coordinators.php';</script>";
}
?>
