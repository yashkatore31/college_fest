<?php
session_start();

// Database connection
include('config.php');

// Fetch events from the database
$query = "SELECT * FROM events";
$result = mysqli_query($conn, $query);

// Check if the student is logged in
$student_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add Bootstrap link -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet"> <!-- Custom font -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Card Styling */
        .event-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .event-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .event-card-body {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .event-title {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
        }

        .event-details {
            font-size: 0.9rem;
            color: #555;
            text-align: center;
        }

        .btn-participate {
            display: block;
            background-color: #007bff;
            border: none;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 30px;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-participate:hover {
            background-color: #0056b3;
        }

        /* Ensure Cards are Uniform in Grid */
        .card-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .btn-participate {
                font-size: 0.9rem;
                padding: 8px;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.8rem;
            }

            .btn-participate {
                font-size: 0.85rem;
                padding: 6px;
            }
        }
        html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

.wrapper {
    flex: 1;
}

.footer {
    background-color: #f8f9fa;
    padding: 15px 0;
    text-align: center;
    width: 100%;
}

    </style>
</head>
<body>

    <!-- Header -->
    <?php include('include/header.php'); ?>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Title -->
        <h3 class="single-down-line text-center ">Management Fest 2025</h3>
        <h5 class="text-center" style="color: red;">Explore Our Exciting Events</h5>
<hr>


        <!-- Event Cards Section -->
        <div class="card-wrapper">
            <?php
            // Loop through the events and display them as cards
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="event-card">
                        <img src="<?php echo $row['image_link']; ?>" alt="Event Image">
                        <div class="event-card-body">
                            <h5 class="event-title"><?php echo $row['event_name']; ?></h5>
                            <p class="event-details"><strong>Location:</strong> <?php echo $row['location']; ?></p>
                            <p class="event-details"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($row['event_date'])); ?></p>
                            <p class="event-details"><strong>Time:</strong> <?php echo date('g:i A', strtotime($row['event_time'])); ?></p>
                            <a href="<?php echo $student_id ? 'join_event.php?event_id=' . $row['event_id'] : 'login.php'; ?>" 
                               class="btn-participate">
                               Participate
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No events found.</p>";
            }
            ?>
        </div>
    </div>
<br>
    <!-- Footer -->
    <?php include('include/footer.php'); ?>

    <script src="path/to/bootstrap.bundle.js"></script> <!-- Add Bootstrap JS link -->
</body>
</html>
