<?php
// Start the session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Include the database connection file
require_once('config.php');

// Check if the student is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Container for the About Us content */
        .about-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        /* Header for the About section */
        .about-container h1 {
            font-size: 32px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Section Text */
        .about-container p {
            font-size: 18px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .about-container .vision-mission {
            background-color: #e7f7e4;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
        }

        .about-container .vision-mission h2 {
            font-size: 28px;
            color: #28a745;
            text-align: center;
            margin-bottom: 10px;
        }

        .about-container .vision-mission p {
            text-align: center;
            font-size: 18px;
        }

        /* Mobile Styling */
        @media (max-width: 768px) {
            .about-container {
                padding: 15px;
                margin: 0;
                max-width: 100%;
            }

            .about-container h1 {
                font-size: 28px;
            }

            .about-container p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<?php include("include/header.php"); ?>

<div class="about-container">
    <!-- Vision and Mission Banner -->
    <div class="alert alert-success vision-mission" style="min-height: 340px">
        <h2>VISION STATEMENT</h2>
        <p>“Spread Knowledge unto the last”</p>

        <h2>MISSION STATEMENT</h2>
        <p>We aim to make local excellence globally competitive by employing innovative and skill-based educational programmes for the students from diverse cultural backgrounds. We strive to boost the self-confidence of our students through their spiritual, moral, intellectual, social, emotional, and physical development by offering value-based education.</p>
        <p>With our efforts to create eco-consciousness and social awareness amongst our stakeholders, we endeavor to make the institute a quality learning place with a conducive atmosphere.</p>
    </div>

    <!-- About the College Section -->
    <!-- <div class="about-container">
        <h1>ABOUT THE COLLEGE</h1>

        <p>The Shikshan Prasarak Sanstha was established in 1961 with a mission to make higher education available to the students from rural background like Sangamner and its vicinity. Since its inception, the college has been following its vision “SPREAD KNOWLEDGE UNTO THE LAST” by taking the educational needs of the rural masses into account. In the year 2020, the college was conferred AUTONOMOUS status by University Grants Commission, New Delhi.</p>

        <p>In imparting higher education to its students, the college has always taken care that its efforts remain focused on the upliftment of socio-economically and culturally deprived rural youth from Sangamner and its vicinity.</p>

        <p>Presently, around 6000 students are pursuing their higher education in different streams on a huge lush green and eco-friendly campus of 50 acres.</p>

        <p>The Sanstha, which was founded on a dry, barren land sixty years ago, has transformed into the fertile land of knowledge and a centre striving for excellence in Higher Education under the visionary leadership of the former Principal Late M.V. Kaundinya and the torchbearer management founders. Former Chairman of Shikshan Prasarak Sanstha Late Shri. S. G. Joshi and Late Shri. Omkarnathaji Malpani laid down a sound and value-based academic foundation.</p>

        <p>Since 2006, under the stalwart leadership of honourable Dr. Sanjay Malpani, Chairman, Shikshan Prasarak Sanstha, our college has been setting and achieving high goals to meet global standards.</p>

        <p>Being motivated by the dictum “Think globally, act locally", we have made it our guiding principle. Though we act locally, we aspire to think globally. We not only endeavour to impart the basics of education by offering traditional education but we also take special efforts to empower the aspiring youth academically by offering vocational courses in Computer Applications to the students of Arts & Commerce. The courses like B.B.A., B.B.A (CA), and B.C.A. were started with the same purpose.</p>

        <p>The college is known for executing innovative programmes such as restructuring of the courses at the undergraduate level and innumerable skill-based and job-oriented activities. The college runs several skills-based courses supported by University Grants Commission (9 BVoc and 2 MVoc courses) and Pradhan Mantri Kaushal Vikas Yojana (PMKVY).</p>

        <p>10 Ph.D. Research Centres (Marathi, Hindi, English, Sanskrit, Economics, Politics, Commerce, Chemistry, Physics & Zoology) keep upgrading the research culture among the students.</p>

        <p>We have dedicated and well-qualified teachers in all faculties. Most of them have the qualification of M.Phil. and/or Ph.D. at their credit. A large number of teachers are working on Minor Research Projects and Major Research Projects sanctioned by various funding agencies. The teachers of the college are always prepared to update their knowledge and to accept all kinds of challenges for future prospects and plans in Higher Education. The college ensures empowerment of human resource through Seminars, conferences, workshops and faculty development programmes.</p>

        <p>To keep pace with the changing times and meet the new challenges, we cater to the infrastructural requirements by keeping quality as the core principle. There are separate classroom buildings for the Arts, Commerce, Science and B. Voc. faculties. There is a large playground with a 400-meter running track, and facilities for various games. The college has two separate hostel buildings for girls and boys.</p>

        <p>The college is re-accredited with A+ grade by NAAC in 2015-16 (CGPA 3.58) in the 3rd cycle valid till Dec, 2025.</p>

        <p>The college is proud recipient of STAR STATUS by Department of Biotechnology, Govt. of India. The college has also received financial assistance from Department of Science and Technology twice under FIST programme.</p>

        <p>For its outstanding performance, the college has been honoured with the "Best College" Award by Savitribai Phule Pune University in 2002, 2008 and recently, in 2019. The college was also chosen as the Best NSS Unit, the Best NCC unit and the Best Sports unit by Savitribai Phule Pune University, Pune.</p>

        <p>We are all geared up as an AUTONOMOUS COLLEGE and heading for a new identity as a FAST GROWING HUB OF QUALITY EDUCATION with a strong support of the management of Shikshan Prasarak Sanstha, dedicated faculty members, hard-working non-teaching staff, aspiring students, motivated parents and all of our inspiring stakeholders.</p>

        <p class="text-center"><a href="https://mr.wikipedia.org/wiki/%E0%A4%B8%E0%A4%82%E0%A4%97%E0%A4%AE%E0%A4%A8%E0%A5%87%E0%A4%B0_%E0%A4%AE%E0%A4%B9%E0%A4%BE%E0%A4%B5%E0%A4%BF%E0%A4%A6%E0%A5%8D%E0%A4%AF%E0%A4%BE%E0%A4%B2%E0%A4%AF" target="_blank" class="readmorebtn">संगमनेर महाविद्यालय विकिपीडिया</a></p>
    </div> -->
</div>
<br>
<br>

<?php include("include/footer.php"); ?>

</body>
</html>
