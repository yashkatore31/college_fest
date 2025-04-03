<?php
// footer.php
?>
<style>
    /* Footer Styling */
    .footer {
        background-color: #fff; /* White background */
        padding: 20px 0; /* Padding for top and bottom */
        text-align: center; /* Center align content */
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1); /* Light shadow for separation */
        position: relative; /* Ensure footer doesn't float to bottom */
        width: 100%;
    }

    .footer-container {
        max-width: 1200px; /* Limit the width */
        margin: 0 auto; /* Center the container */
        padding: 0 15px; /* Padding for mobile responsiveness */
    }

    .footer-content {
        font-family: Arial, sans-serif; /* Clean font */
        color: #333; /* Dark text color */
    }

    .footer-logo-text {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px; /* Space between logo-text and footer text */
        flex-wrap: wrap; /* Allow content to wrap on small screens */
    }

    .footer-logo {
        width: 50px; /* Set logo width */
        height: auto;
        margin-right: 10px; /* Space between logo and college name */
    }

    .college-name {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333; /* Dark text for the college name */
        text-align: center;
        margin-top: 10px;
    }

    .management-fest {
        font-size: 1.1rem;
        font-weight: bold;
        color: red; /* Red color for the Management Fest title */
        margin-bottom: 10px; /* Space below the Management Fest title */
        text-align: center;
    }

    .department-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #007bff; /* Blue color for department title */
        margin-bottom: 10px; /* Space below the department title */
        text-align: center;
    }

    .footer-text {
        margin: 0;
        font-size: 0.9rem; /* Slightly smaller text */
        color: #555; /* Lighter text for subtext */
        text-align: center;
    }

    .footer-text a {
        color: #007bff; /* Link color */
        text-decoration: none; /* Remove underline */
    }

    .footer-text a:hover {
        text-decoration: underline; /* Underline on hover */
    }

    /* Media queries for responsiveness */
    @media (max-width: 768px) {
        .footer-logo {
            width: 40px; /* Smaller logo size on mobile */
        }

        .college-name {
            font-size: 1rem; /* Smaller font size on mobile */
            text-align: center;
        }

        .footer-text {
            font-size: 0.8rem; /* Smaller font size on mobile */
        }

        .footer-logo-text {
            flex-direction: column; /* Stack logo and text vertically on small screens */
        }

        .footer-logo {
            margin-bottom: 10px; /* Space between logo and text on small screens */
        }
    }

    @media (max-width: 480px) {
        .footer-logo {
            width: 35px; /* Further reduce logo size on very small screens */
        }

        .college-name {
            font-size: 0.9rem; /* Further reduce college name size */
        }

        .footer-text {
            font-size: 0.7rem; /* Even smaller text on very small screens */
        }
    }
</style>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-logo-text">
                <img src="https://www.sangamnercollege.edu.in/images/shikshan-logo.png" alt="College Logo" class="footer-logo">
                <span class="college-name"><h4>S.N Arts D.J.M Commerce & B.N.S Science College, Sangamner</h4> </span>
            </div>
            <!-- <p class="management-fest">Management Fest</p> New title added here in red color -->
            <p class="department-title"><h3>Department of BBA (CA)  and BBA</h3></p> <!-- Department title -->
            <p class="footer-text">© 2025 Your Website. All rights reserved.</p>
            <!-- <p class="footer-text"><h3>Designed by</h3> -->
        <h4>Follow us on...</h4>
            <div class="social-media-links" style="display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 15px; padding: 20px;">
    <!-- Facebook Link -->
    <a href="https://www.facebook.com/profile.php?id=100090020553082&mibextid=ZbWKwL" target="_blank" style="width: 50px; height: auto; transition: transform 0.3s ease;">
        <img src="../images/facebook.png" alt="Facebook" style="width: 100%; height: auto;">
    </a>

    <!-- Instagram Link -->
    <a href="https://www.instagram.com/department_of_business_admini?igsh=cTB4N2o1ZTJuOTN3" target="_blank" style="width: 50px; height: auto; transition: transform 0.3s ease;">
        <img src="../images/instagram.png" alt="Instagram" style="width: 100%; height: auto;">
    </a>

    <!-- YouTube Link -->
    <a href="https://youtube.com/@sangamnercollegeofficial5318?si=W1wxMlsT7eswokIA" target="_blank" style="width: 50px; height: auto; transition: transform 0.3s ease;">
        <img src="../images/youtube.png" alt="YouTube" style="width: 100%; height: auto;">
    </a>
</div>

        </div>
    </div>
</footer>
<script>
    // Mobile responsiveness for icon sizes
    const icons = document.querySelectorAll('.social-media-links a img');
    
    // Adjust icon size for smaller screens
    if (window.innerWidth <= 768) {
        icons.forEach(icon => {
            icon.style.width = "40px";
        });
    }

    // Stack icons on very small screens (mobile)
    if (window.innerWidth <= 480) {
        document.querySelector('.social-media-links').style.flexDirection = 'column';
        document.querySelector('.social-media-links').style.alignItems = 'center';
    }

    // Hover effect
    icons.forEach(icon => {
        icon.addEventListener('mouseover', () => {
            icon.style.transform = "scale(1.1)";
        });
        icon.addEventListener('mouseout', () => {
            icon.style.transform = "scale(1)";
        });
    });
</script>
<!-- Optional: Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
