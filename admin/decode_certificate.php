<?php
require 'db_connection.php';
session_start();

// Ensure the admin is logged in


// Initialize variables
$certificate_id = $decoded_data = "";
$error = "";

// When the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['certificate_id'])) {
        $error = "Please enter a Certificate ID.";
    } else {
        $certificate_id = trim($_POST['certificate_id']);

        // Validate certificate ID format using regex
        $pattern = "/^CERT-(\d+)-(\d+)-(\d{8})-([A-F0-9]{6})$/";
        if (!preg_match($pattern, $certificate_id, $matches)) {
            $error = "Invalid Certificate ID format.";
        } else {
            // Extract components
            $student_id = $matches[1];  // Student ID
            $event_id = $matches[2];    // Event ID
            $issue_date = $matches[3];  // Issue Date (YYYYMMDD)

            // Convert date format to YYYY-MM-DD
            $issue_date_formatted = substr($issue_date, 0, 4) . '-' . substr($issue_date, 4, 2) . '-' . substr($issue_date, 6, 2);

            // Fetch Student and Event details from the database
            $query = "SELECT s.name AS student_name, e.event_name 
                      FROM students s
                      JOIN events e ON e.event_id = ?
                      WHERE s.id = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $event_id, $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!$row) {
                $error = "No matching certificate found.";
            } else {
                // Extract student and event names
                $student_name = $row['student_name'];
                $event_name = $row['event_name'];

                // Prepare output
                $decoded_data = "
                <table class='table table-bordered mt-3'>
                    <tr><th>Certificate ID</th><td>{$certificate_id}</td></tr>
                    <tr><th>Student ID</th><td>{$student_id}</td></tr>
                    <tr><th>Student Name</th><td>{$student_name}</td></tr>
                    <tr><th>Event ID</th><td>{$event_id}</td></tr>
                    <tr><th>Event Name</th><td>{$event_name}</td></tr>
                    <tr><th>Issue Date</th><td>{$issue_date_formatted}</td></tr>
                </table>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    
<?php include('header.php')?>
<div class="container mt-4">
    <h2 class="mt-10 mb-4">Verify Certificate</h2>
    <form method="post">
        <div class="mb-3">
            <label for="certificate_id" class="form-label">Enter Certificate ID:</label>
            <input type="text" id="certificate_id" name="certificate_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-info">Verify</button>
    </form>

    <?php if ($error): ?>
        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($decoded_data): ?>
        <?php echo $decoded_data; ?>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
