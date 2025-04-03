<?php
// Start the session
session_start();

// Check if user is logged in, else redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Include the database connection file
include('../config.php');

// Check if an event ID is provided
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Prepare the SQL query to fetch students enrolled in the event
    $query = "
        SELECT s.id AS student_id, s.name, s.email, s.phone, s.department, s.year, s.prn_number, er.registration_timestamp
        FROM event_registrations er
        JOIN students s ON er.student_id = s.id
        WHERE er.event_id = ?
        ORDER BY er.registration_timestamp;
    ";

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Filter duplicates in PHP
    $unique_students = [];
    while ($student = $result->fetch_assoc()) {
        // Create a unique key for each student
        $student_key = $student['student_id'] . '-' . $student['email'];
        
        // If the student isn't already added, add them to the array
        if (!isset($unique_students[$student_key])) {
            $unique_students[$student_key] = $student;
        }
    }

} else {
    echo "Event ID not provided!";
    exit;
}

// Handle CSV download request
if (isset($_GET['download_csv']) && $_GET['download_csv'] == 'true') {
    // Set headers to prompt the download of a CSV file
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="students_list.csv"');
    $output = fopen('php://output', 'w');
    
    // Output the column headings
    fputcsv($output, ['Student ID', 'Name', 'Email', 'Phone', 'Department', 'Year', 'PRN Number', 'Registration Timestamp']);
    
    // Output filtered unique student data
    foreach ($unique_students as $student) {
        fputcsv($output, [
            $student['student_id'],
            $student['name'],
            $student['email'],
            $student['phone'],
            $student['department'],
            $student['year'],
            $student['prn_number'],
            $student['registration_timestamp']
        ]);
    }
    
    // Close file pointer
    fclose($output);
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/layerslider.css">
    <link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<!-- Navbar -->
<header id="header" class="transparent-header-modern fixed-header-bg-white w-100">
            <div class="top-header bg-secondary">
                <div class="container">
                </div>
            </div>
            <div class="main-nav secondary-nav hover-success-nav py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">
                                <a class="navbar-brand position-relative" href="index.php">
                                    <img class="nav-logo" src="https://www.sangamnercollege.edu.in/images/shikshan-logo.png" alt="" style="width: 125px; height: 56px;">
                                </a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                    </ul>
                                    
                                    <!-- Show Logout Button only if the user is logged in -->
                                
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>

<!-- Students List -->
<div class="container my-5">
    <h3>Students Enrolled in Event</h3>
    
    <!-- CSV Download Button --><hr>
    <a href="view_students.php?event_id=<?php echo $_GET['event_id']; ?>&download_csv=true" class="btn btn-success mb-3">Download as CSV</a>
    <br>
    <?php if (count($unique_students) > 0) { ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Member ID</th>
                    <th>Registration Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unique_students as $student) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo htmlspecialchars($student['phone']); ?></td>
                        <td><?php echo htmlspecialchars($student['department']); ?></td>
                        <td><?php echo htmlspecialchars($student['year']); ?></td>
                        <td><?php echo htmlspecialchars($student['prn_number']); ?></td>
                        <td><?php echo htmlspecialchars($student['registration_timestamp']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No students enrolled for this event.</p>
    <?php } ?>
</div>
<?php include("footer.php") ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
