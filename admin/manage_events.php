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

// Add new event (if form is submitted)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $event_name = $_POST['event_name'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $image_link = $_POST['image_link'];
    $description = $_POST['description'];

    // Insert event into the database
    $query = "INSERT INTO events (event_name, location, event_date, event_time, image_link, description) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $event_name, $location, $event_date, $event_time, $image_link, $description);
    if ($stmt->execute()) {
        $message = "Event added successfully!";
    } else {
        $message = "Error adding event.";
    }
}

// Get all events from the database
$query = "SELECT * FROM events";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<?php include('header.php'); ?>

<!-- Event Management -->
<div class="container my-5">

    <!-- Display message -->
    <?php if (isset($message)) { ?>
        <div class="alert alert-info" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <h1 class="text-dark fw-bold">Add New Event</h1>

    <form method="POST" action="manage_events.php">
        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="event_name" name="event_name" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" class="form-control" id="event_date" name="event_date" required>
        </div>
        <div class="mb-3">
            <label for="event_time" class="form-label">Event Time</label>
            <input type="time" class="form-control" id="event_time" name="event_time" required>
        </div>
        <div class="mb-3">
            <label for="image_link" class="form-label">Image Link</label>
            <input type="url" class="form-control" id="image_link" name="image_link" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <button type="submit" name="add_event" class="btn btn-info" style="border-radius:5px;">Add Event</button>
    </form>

    <hr>

    <!-- Display Events Table -->
    <h3 class="my-4">Manage Events</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Location</th>
                <th>Event Date</th>
                <th>Event Time</th>
                <th>Image Link</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($event = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $event['event_name']; ?></td>
                    <td><?php echo $event['location']; ?></td>
                    <td><?php echo $event['event_date']; ?></td>
                    <td><?php echo $event['event_time']; ?></td>
                    <td class="text-center align-middle">
    <img src="<?php echo $event['image_link']; ?>" alt="Event Image" class="img-thumbnail" style="width: 360px; height: 75px; object-fit: cover;">
</td>

                    <td><?php echo $event['description']; ?></td>
                    <td style="display:flex; gap:1px;">
                        <a href="edit_event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_event.php?id=<?php echo $event['event_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        <a href="view_students.php?event_id=<?php echo $event['event_id']; ?>" class="btn btn-info btn-sm">students</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
