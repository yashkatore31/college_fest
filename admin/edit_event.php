<?php
// Start the session
session_start();

// Check if user is logged in, else redirect to login page
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection file
include('db_connection.php');

// Get the event ID from the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Fetch event data from the database
    $query = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Event data found, fetch it
        $event = $result->fetch_assoc();
    } else {
        // If event not found, redirect to manage events page
        header("Location: manage_events.php");
        exit;
    }
} else {
    // Redirect if event ID is not provided
    header("Location: manage_events.php");
    exit;
}

// Update event (if form is submitted)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $event_name = $_POST['event_name'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $image_link = $_POST['image_link'];
    $description = $_POST['description'];

    // Update event details in the database
    $query = "UPDATE events SET event_name = ?, location = ?, event_date = ?, event_time = ?, image_link = ?, description = ? WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $event_name, $location, $event_date, $event_time, $image_link, $description, $event_id);

    if ($stmt->execute()) {
        $message = "Event updated successfully!";
    } else {
        $message = "Error updating event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<?php include('header.php'); ?>

<!-- Edit Event Form -->
<div class="container mb-5">
    <h3>Edit Event</h3>

    <!-- Display message -->
    <?php if (isset($message)) { ?>
        <div class="alert alert-info" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <!-- Edit Event Form -->
    <form method="POST" action="edit_event.php?id=<?php echo $event['event_id']; ?>">
        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo $event['location']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="event_time" class="form-label">Event Time</label>
            <input type="time" class="form-control" id="event_time" name="event_time" value="<?php echo $event['event_time']; ?>" required>
        </div>
        <div class="mb-3">
    <label for="image_link" class="form-label">Image Link</label>
    <input type="url" class="form-control" id="image_link" name="image_link" value="<?php echo $event['image_link']; ?>" placeholder="http://example.com" />
</div>

        <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $event['description']; ?></textarea>
        </div>
        <button type="submit" name="update_event" class="btn btn-info" style="border-radius:5px;">Update Event</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
