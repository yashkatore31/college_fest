<?php
// Include the database connection file
include('db_connection.php');

// Check if the event ID is passed in the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Prepare the SQL statement to delete the event
    $sql = "DELETE FROM events WHERE event_id = $event_id";

    // Execute the query and check for success
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Event deleted successfully!');</script>";
        echo "<script>window.location.href = 'manage_events.php';</script>"; // Redirect to the events management page
    } else {
        echo "<script>alert('Error deleting event: " . mysqli_error($conn) . "');</script>";
    }
} else {
    echo "<script>alert('Event ID not specified!');</script>";
    echo "<script>window.location.href = 'manage_events.php';</script>"; // Redirect if no event ID is passed
}

?>
