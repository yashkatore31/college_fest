<?php
include('db_connection.php');

// Get coordinator ID from URL
$coordinator_id = $_GET['id'];

// Fetch all events
$events_query = "SELECT * FROM events";
$events_result = mysqli_query($conn, $events_query);

// Check if the query succeeded
if (!$events_result) {
    die("Error fetching events: " . mysqli_error($conn));
}

// Fetch currently assigned events
$assigned_query = "SELECT event_id FROM event_coordinators WHERE coordinator_id = ?";
$stmt = mysqli_prepare($conn, $assigned_query);
if (!$stmt) {
    die("Error preparing query: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $coordinator_id);
mysqli_stmt_execute($stmt);
$assigned_result = mysqli_stmt_get_result($stmt);

$assigned_events = [];
if ($assigned_result) {
    while ($row = mysqli_fetch_assoc($assigned_result)) {
        $assigned_events[] = $row['event_id'];
    }
}

// Handle form submission
if (isset($_POST['assign'])) {
    $selected_events = $_POST['events'];

    // Clear existing assignments
    $delete_query = "DELETE FROM event_coordinators WHERE coordinator_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    if (!$stmt) {
        die("Error preparing delete query: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $coordinator_id);
    mysqli_stmt_execute($stmt);

    // Insert new assignments
    foreach ($selected_events as $event_id) {
        $insert_query = "INSERT INTO event_coordinators (coordinator_id, event_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        if (!$stmt) {
            die("Error preparing insert query: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, "ii", $coordinator_id, $event_id);
        mysqli_stmt_execute($stmt);
    }

    echo "<script>alert('Events assigned successfully!'); window.location.href = 'manage_coordinators.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
        .box {
            justify:box;
            max-width:700px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
       
    </style>
</head>
<body>
<?php include('header.php'); ?>
<div class="d-flex justify-content-center align-items-center">
    <div class="box">
        <h2>Assign Events to Coordinator</h2>
        <form method="POST">
            <label>Select Events:</label><br>
            <?php if (mysqli_num_rows($events_result) > 0): ?>
                <?php while ($event = mysqli_fetch_assoc($events_result)): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="events[]" value="<?php echo $event['event_id']; ?>" 
                        <?php echo in_array($event['event_id'], $assigned_events) ? 'checked' : ''; ?>>
                        <label class="form-check-label"><?php echo $event['event_name']; ?></label>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No events available to assign.</p>
            <?php endif; ?>
            <input type="submit" name="assign" value="Assign Events" class="btn btn-primary mt-3">
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
