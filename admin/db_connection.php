<?php
$servername = "localhost";
$username = "root";  // change to your database username
$password = "";      // change to your database password
$dbname = "management_fest";  // change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
