<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include('config.php');

// Get event ID from URL
if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    
    // Fetch event details
    $query = "SELECT * FROM events WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    
    if (!$event) {
        echo "Event not found.";
        exit();
    }
} else {
    echo "Invalid event.";
    exit();
}

// Handle event registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['id'];

    // Check if already registered
    $check_query = "SELECT * FROM event_registrations WHERE event_id = ? AND student_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('ii', $event_id, $student_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Already registered, show alert and redirect
        echo "<script>alert('You are already registered for this event. Redirecting to homepage...'); window.location.href = 'index.php';</script>";
        exit();
    } else {
        // Register the student for the event
        $register_query = "INSERT INTO event_registrations (event_id, student_id) VALUES (?, ?)";
        $stmt = $conn->prepare($register_query);
        $stmt->bind_param('ii', $event_id, $student_id);
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Redirecting to homepage...'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Responsive Card */
        .card {
            max-width: 100%;  /* Ensure the card takes full width on small screens */
            margin: 0 auto;
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .card img {
            width: 100%; /* Make the image fill the card's width */
            height: auto; /* Maintain aspect ratio */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-body {
            padding: 20px; /* Adjust padding for better spacing */
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 30px;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .card {
                margin-top: 20px;
                padding: 15px;
            }
            .card-body {
                padding: 15px;
            }
            .card-title {
                font-size: 1.25rem;
            }
            .card-text {
                font-size: 0.9rem;
            }
        }

        /* Specific style for iPhone XR screen size */
        @media (max-width: 414px) {
            .card {
                margin-top: 10px;
                padding: 10px;
            }
            .card-title {
                font-size: 1.2rem;
            }
            .card-text {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include('include/header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Join Event</h1>
        <div class="card">
            <img src="<?php echo htmlspecialchars($event['image_link'], ENT_QUOTES, 'UTF-8'); ?>" 
                 alt="Event Image" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($event['event_name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($event['location'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="card-text"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($event['event_date'])); ?></p>
                <p class="card-text"><strong>Time:</strong> <?php echo date('g:i A', strtotime($event['event_time'])); ?></p>
                <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                <form method="POST">
                    <button type="submit" class="btn btn-primary">Confirm Registration</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('include/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
