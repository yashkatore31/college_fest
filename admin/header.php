<?php 
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../images/favicon.ico">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

    <!-- CSS Links -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-slider.css">
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <link rel="stylesheet" href="../css/layerslider.css">
    <link rel="stylesheet" href="../css/color.css" id="color-change">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/flaticon/flaticon.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- Title -->
    <title>Management Fest 2025 </title>
</head>
<body>

<div id="wrapper">
    <div class="row"> 
        <!-- Header -->
        <header id="header" class="transparent-header-modern fixed-header-bg-white w-100">
            <div class="top-header bg-secondary">
                <div class="container"></div>
            </div>
            <div class="main-nav secondary-nav hover-success-nav py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">
                                <a class="navbar-brand position-relative" href="index.php">
                                    <img class="nav-logo" src="https://www.sangamnercollege.edu.in/images/shikshan-logo.png" alt="Logo" style="width: 125px; height: 56px;">
                                </a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav me-auto">
                                        <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo ($currentPage == 'decode_certificate.php') ? 'active' : ''; ?>" href="decode_certificate.php">Verify Certificates</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo ($currentPage == 'admin_profile.php') ? 'active' : ''; ?>" href="admin_profile.php">Admin Profile</a>
                                        </li>
                                    </ul>

                                    <?php if (isset($_SESSION['admin_id'])): ?>
                                        <a class="btn btn-info ms-2" style="border-radius:30px;" href="logout.php">Logout</a> 
                                    <?php endif; ?>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </header>
    </div>
</div>

<!-- JS Links -->
<script defer src="js/jquery.min.js"></script>
<script defer src="js/bootstrap.min.js"></script>
<script defer src="js/custom.js"></script>

</body>
</html>
