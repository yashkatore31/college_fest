<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>
<div class="container mt-4">
<div class="container mt-3 mb-5">
    <h2 class="text-dark fw-bold text-center">Welcome to the Admin Panel</h2>
</div>

    <div class="row display-flex">
        <?php 
        $modules = [
            ["Manage Events", "Create, edit, and delete events.", "manage_events.php"],
            ["Manage Students", "View and manage registered students.", "manage_students.php"],
            ["Manage Coordinators", "Assign and manage coordinators.", "manage_coordinators.php"],

        ];
        
        foreach ($modules as $module) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title text-black"><?php echo $module[0]; ?></h4>
                        <p class="card-text"><?php echo $module[1]; ?></p>
                        <a href="<?php echo $module[2]; ?>" class="btn btn-info" style="border-radius:5px;">Go to <?php echo explode(' ', $module[0])[1]; ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
