<?php
require 'db_connection.php';
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Access Denied");
}

// Fetch pending certificates
$query = "SELECT c.certificate_id, s.name AS student_name, e.event_name, c.issue_date, c.approved 
          FROM certificates c
          JOIN students s ON c.student_id = s.id
          JOIN events e ON c.event_id = e.event_id
          WHERE c.approved = 0";  // Show only pending certificates
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Certificates</title>
</head>
<body>
    <h2>Pending Certificates</h2>
    <table border="1">
        <tr>
            <th>Certificate ID</th>
            <th>Student Name</th>
            <th>Event</th>
            <th>Issue Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['certificate_id']; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['event_name']; ?></td>
                <td><?php echo $row['issue_date']; ?></td>
                <td>
                    <form action="approve_certificate.php" method="POST">
                        <input type="hidden" name="certificate_id" value="<?php echo $row['certificate_id']; ?>">
                        <button type="submit">Approve</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
