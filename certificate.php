<?php
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['id'];
$query = "SELECT er.event_id, e.event_name 
          FROM event_registrations er
          JOIN events e ON er.event_id = e.event_id
          WHERE er.student_id = ? AND er.certificate_status = 'approved';";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
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
        min-width: 500px; /* Adjust this value as needed */
    }

    h2 {
        font-size: 28px;
    }
}

</style>
</head>
<body>

    <!-- Header Include -->
    <?php include("include/header.php"); ?>

    <!-- Profile Form -->
    <div class="profile-wrapper">
    <h3 class="text-center mt-4">Your Certificates</h3>
<?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                        <td>
                            <a href="generate_certificate.php?event_id=<?php echo urlencode($row['event_id']); ?>" 
                               class="download-btn" target="_blank">Download</a>
                        </td>
                    </tr>
                <?php } ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center text-primary">No Certificates Found</p>
<?php endif; ?>
        </div>

        <?php include('include/footer.php'); ?>
</body>
</html>
