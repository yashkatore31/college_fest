<?php
require 'db_connection.php';
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    die("Access Denied");
}

// Check if a certificate ID is provided
if (!isset($_POST['certificate_id'])) {
    die("Certificate ID is missing.");
}

$certificate_id = $_POST['certificate_id'];

// Approve the certificate
$query = "UPDATE certificates SET approved = 1 WHERE certificate_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $certificate_id);
if ($stmt->execute()) {
    echo "Certificate Approved Successfully!";
} else {
    echo "Error approving certificate.";
}

// Redirect back to manage_certificates.php
header("Location: manage_certificates.php");
exit();
?>
