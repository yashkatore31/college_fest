<?php
session_start();
include("../config.php");

// Check if the coordinator is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];

// Fetch coordinator's ID based on the username
$stmt = $conn->prepare("SELECT cd_id FROM coordinators WHERE cd_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($coordinator_id);
$stmt->fetch();
$stmt->close();

// Fetch events associated with the coordinator
$stmt = $conn->prepare("SELECT e.event_id, e.event_name, e.event_date, e.location, e.image_link 
                        FROM events e
                        JOIN event_coordinators ec ON e.event_id = ec.event_id
                        WHERE ec.coordinator_id = ?");
$stmt->bind_param("i", $coordinator_id);
$stmt->execute();
$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coordinator Panel</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .panel-wrapper {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-title, .card-text {
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Number of lines before truncation */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            .panel-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <div class="panel-wrapper">
        <h2 class="text-center">Welcome, <?php echo htmlspecialchars($username); ?></h2>
        <p class="text-center">Here are the events you can access:</p>

        <?php if (count($events) > 0): ?>
            <div class="row">
                <?php foreach ($events as $event): ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($event['image_link']); ?>" class="card-img-top" alt="Event Image">
                            <div class="card-body">
                                <h5 class="card-title"> <?php echo htmlspecialchars($event['event_name']); ?> </h5>
                                <p class="card-text"> Date: <?php echo htmlspecialchars($event['event_date']); ?> </p>
                                <p class="card-text"> Venue: <?php echo htmlspecialchars($event['location']); ?> </p>
                                <a href="view_students.php?event_id=<?php echo htmlspecialchars($event['event_id']); ?>" class="btn btn-primary">View Enrolled Students</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-warning">No events found.</p>
        <?php endif; ?>
    </div>

    <?php include("footer.php"); ?>

    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
