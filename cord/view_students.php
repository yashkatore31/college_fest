<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../config.php');

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    if (isset($_POST['update_status'])) {
        $student_id = $_POST['student_id'];
        $status = $_POST['status'];
        
        $updateQuery = "UPDATE event_registrations SET certificate_status = ? WHERE event_id = ? AND student_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sii", $status, $event_id, $student_id);
        $stmt->execute();
    }

    if (isset($_GET['download_csv'])) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="students_event_' . $event_id . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Student ID', 'Name', 'Email', 'Phone', 'Department', 'Year', 'PRN Number', 'Registration Timestamp', 'Certificate Status']);

        $query = "
            SELECT s.id AS student_id, s.name, s.email, s.phone, s.department, s.year, s.prn_number, er.registration_timestamp, er.certificate_status
            FROM event_registrations er
            JOIN students s ON er.student_id = s.id
            WHERE er.event_id = ?
            ORDER BY er.registration_timestamp;
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }

    $query = "
        SELECT s.id AS student_id, s.name, s.email, s.phone, s.department, s.year, s.prn_number, er.registration_timestamp, er.certificate_status
        FROM event_registrations er
        JOIN students s ON er.student_id = s.id
        WHERE er.event_id = ?
        ORDER BY er.registration_timestamp;
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Event ID not provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students Enrolled</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("header.php"); ?>
<div class="container my-5">
    <h2>Students Enrolled in Event</h2>
    <a href="view_students.php?event_id=<?php echo $_GET['event_id']; ?>&download_csv=true" class="btn btn-secondary my-3">Download as CSV</a>
    <a href="index.php" class="btn btn-info my-3">Go to Dashboard</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Year</th>
                <th>PRN Number</th>
                <th>Registration Timestamp</th>
                <th>Certificate Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($student = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td><?php echo htmlspecialchars($student['phone']); ?></td>
                    <td><?php echo htmlspecialchars($student['department']); ?></td>
                    <td><?php echo htmlspecialchars($student['year']); ?></td>
                    <td><?php echo htmlspecialchars($student['prn_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['registration_timestamp']); ?></td>
                    <td><?php echo ucfirst($student['certificate_status']); ?></td>
                    <td style="display: flex; gap: 3px;">
                        <?php if ($student['certificate_status'] == 'approved') { ?>
                            <form method="POST">
                                <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" name="update_status" class="btn btn-secondary btn-sm">Reject</button>
                            </form>
                        <?php } elseif ($student['certificate_status'] == 'rejected') { ?>
                            <form method="POST">
                                <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" name="update_status" class="btn btn-info btn-sm">Approve</button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?php include ('../include/footer.php') ?>
</body>
</html>
