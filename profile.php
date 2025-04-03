<?php
// Start the session
session_start();

// Include the database connection file
require_once('config.php');

// Check if the student is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
// Fetch student details from the database
$student_id = $_SESSION['id']; // Assuming student ID is stored in session
$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

// Process password change
$error = "";
$msg = "";
if (isset($_POST['change_password'])) {
    $old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if old password is correct
    if (password_verify($old_password, $student['password'])) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Hash new password and update in the database
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE students SET password = '$new_password_hashed' WHERE id = '$student_id'";
            if (mysqli_query($conn, $update_query)) {
                $msg = "<p class='alert alert-success'>Password changed successfully!</p>";
            } else {
                $error = "<p class='alert alert-danger'>Failed to change password. Please try again.</p>";
            }
        } else {
            $error = "<p class='alert alert-warning'>New password and confirm password do not match.</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Old password is incorrect.</p>";
    }
}

// Fetch enrolled events
$event_query = "SELECT e.event_name, er.registration_timestamp FROM events e JOIN event_registrations er ON e.event_id = er.event_id WHERE er.student_id = '$student_id'";
$event_result = mysqli_query($conn, $event_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Profile</title>
    <style>
   body {
    background-color: #f7f7f7;
    font-family: Arial, sans-serif;
}

.profile-wrapper {
    max-width: 700px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

h2 {
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

.profile-details {
    margin-top: 30px;
    margin-left: 50px;
    margin-right: 50px;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-details label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.profile-details p {
    margin-bottom: 15px;
    font-size: 16px;
    color: #555;
}

.profile-action {
    text-align: center;
}

.profile-action a {
    font-size: 16px;
    color: #007bff;
    text-decoration: none;
}

.profile-action a:hover {
    text-decoration: underline;
}

.alert {
    margin-top: 15px;
}

.btn-block {
    padding: 12px;
    font-size: 18px;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.profile-image {
    text-align: center;
    margin-bottom: 20px;
}

.profile-image img {
    max-width: 150px;
    border-radius: 50%;
}

.profile-header {
    text-align: center;
    margin-bottom: 20px;
}

.profile-header h3 {
    font-size: 20px;
    color: #333;
}

.profile-header p {
    font-size: 16px;
    color: #555;
}

.profile-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.profile-row label {
    font-weight: bold;
    font-size: 16px;
    color: #333;
}

.profile-row p {
    font-size: 14px;
    color: #555;
    margin-left: 10px;
}

hr {
    border-top: 2px solid #007bff;
    margin-top: 30px;
    margin-bottom: 30px;
}

/* Responsive Design for small devices (mobile phones, less than 576px) */
@media (max-width: 575px) {
    .profile-wrapper {
        padding: 15px;
    }

    h2 {
        font-size: 22px;
    }

    .profile-details {
        margin-left: 15px;
        margin-right: 15px;
        padding: 15px;
    }

    .profile-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .profile-row label {
        font-size: 14px;
    }

    .profile-row p {
        font-size: 12px;
    }

    .btn-block {
        padding: 10px;
        font-size: 16px;
    }

    .btn-primary {
        font-size: 16px;
    }
}

/* Responsive Design for medium devices (tablets, 576px to 768px) */
@media (min-width: 576px) and (max-width: 768px) {
    .profile-wrapper {
        padding: 20px;
    }

    h2 {
        font-size: 24px;
    }

    .profile-details {
        margin-left: 25px;
        margin-right: 25px;
        padding: 20px;
    }

    .profile-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .profile-row label {
        font-size: 15px;
    }

    .profile-row p {
        font-size: 13px;
    }

    .btn-block {
        padding: 12px;
        font-size: 17px;
    }

    .btn-primary {
        font-size: 17px;
    }
}

/* Responsive Design for large devices (desktops, 769px to 1024px) */
@media (min-width: 769px) and (max-width: 1024px) {
    .profile-wrapper {
        padding: 25px;
    }

    h2 {
        font-size: 26px;
    }

    .profile-details {
        margin-left: 30px;
        margin-right: 30px;
        padding: 25px;
    }

    .profile-row {
        flex-direction: row;
        justify-content: space-between;
    }

    .profile-row label {
        font-size: 16px;
    }

    .profile-row p {
        font-size: 14px;
    }

    .btn-block {
        padding: 14px;
        font-size: 18px;
    }

    .btn-primary {
        font-size: 18px;
    }
}

/* Responsive Design for extra-large devices (larger desktops, 1025px and above) */
@media (min-width: 1025px) {
    .profile-wrapper {
        padding: 30px;
    }

    h2 {
        font-size: 28px;
    }

    .profile-details {
        margin-left: 50px;
        margin-right: 50px;
        padding: 30px;
    }

    .profile-row {
        flex-direction: row;
        justify-content: space-between;
    }

    .profile-row label {
        font-size: 17px;
    }

    .profile-row p {
        font-size: 15px;
    }

    .btn-block {
        padding: 16px;
        font-size: 19px;
    }

    .btn-primary {
        font-size: 19px;
    }
}

</style>
</head>
<body>

    <!-- Header Include -->
    <?php include("include/header.php"); ?>

    <!-- Profile Form -->
    <div class="profile-wrapper">
        <h2 class="text-center">Profile</h2>

        <!-- Display error or success messages -->
        <?php echo $error; ?>
        <?php echo $msg; ?>

        <!-- Profile Information -->
       

        <!-- Profile Details -->
        <div class="profile-details">
            <div class="profile-row">
                <label for="name">Full Name</label>
                <p><?php echo $student['name']; ?></p>
            </div>
            <div class="profile-row">
                <label for="email">Email Address</label>
                <p><?php echo $student['email']; ?></p>
            </div>
            <div class="profile-row">
                <label for="phone">Phone Number</label>
                <p><?php echo $student['phone']; ?></p>
            </div>
            <div class="profile-row">
                <label for="department">Department</label>
                <p><?php echo $student['department']; ?></p>
            </div>
            <div class="profile-row">
                <label for="year">Year</label>
                <p><?php echo $student['year']; ?></p>
            </div>
        </div>

        <!-- Enrolled Events -->
         <br>
<h3 class="text-center mt-4">Enrolled Events</h3>
<?php if (mysqli_num_rows($event_result) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($event = mysqli_fetch_assoc($event_result)): ?>
                <tr>
                    <td><?php echo $event['event_name']; ?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($event['registration_timestamp'])); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-primary">No events registered.</p>
<?php endif; ?>

<a href="certificate.php" class="btn btn-info btn-block">Get Certificate</a>

        <!-- Divider Line -->
        <hr>
        <!--  -->
<!-- ----------------------------------------------------------- -->

<!-- ----------------------------------------------------------- -->
        <!-- Change Password Form -->
        <h3 class="text-center">Change Password</h3>
        <form method="POST">
            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Enter your old password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Enter your new password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm your new password" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-info btn-block">Change Password</button>
        </form>

        <!-- Profile Action -->
        <div class="profile-action">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Footer Include -->
    <?php include("include/footer.php"); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>
