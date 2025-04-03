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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Meta Tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">
    
    <!-- Font & CSS Links -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    
    <title>Contact Us</title>

</head>
<body>
    <?php include('include/header.php'); ?>
    <div id="wrapper">
        <!-- Include Predefined Header -->

        <!-- Page Title Section -->
        <div class="page-title text-center mt-5">
            <h1 class="text-black">Department of BBA(CA) and BBA</h1>
        </div>

        <!-- HOD Contact Cards Section -->
       <div class="container mt-5">
    <div class="row">
        <!-- HOD of BBA(CA) -->
        <div class="col-md-6 mb-4">
            <div class="card" style="background-color: white; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                <div class="card-header" style="background-color: white; border-bottom: 1px solid #ddd;">
                    <h4 style="color: black;">Mr. Khemnar T.T</h4> <!-- Black for the name -->
                    <p style="color: #FF5733;">HOD of BBA(CA)</p> <!-- Red color for the title -->
                </div>
                <div class="card-body" style="color: black;">
                    <p style="color: black;"><b>Phone:</b> +91 9123456789</p> <!-- Set text color to black -->
                    <p style="color: black;"><b>Email:</b> khemnar.tt@college.edu</p> <!-- Set text color to black -->
                </div>
            </div>
        </div>

        <!-- HOD of BBA -->
        <div class="col-md-6 mb-4">
            <div class="card" style="background-color: white; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px;">
                <div class="card-header" style="background-color: white; border-bottom: 1px solid #ddd;">
                    <h4 style="color: black;">Mrs. Kulkarni S.S</h4> <!-- Black for the name -->
                    <p style="color: #FF5733;">HOD of BBA</p> <!-- Red color for the title -->
                </div>
                <div class="card-body" style="color: black;">
                    <p style="color: black;"><b>Phone:</b> +91 9876543210</p> <!-- Set text color to black -->
                    <p style="color: black;"><b>Email:</b> kulkarni.ss@college.edu</p> <!-- Set text color to black -->
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Include Predefined Footer -->
    </div>
    
    <!-- JS Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    <?php include('include/footer.php'); ?>
</body>
</html>
