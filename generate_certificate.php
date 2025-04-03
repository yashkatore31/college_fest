<?php
require('fpdf/fpdf.php');
require 'config.php';
session_start();
 

// Ensure student is logged in
if (!isset($_SESSION['id'])) {
 die("Access Denied");
}

$student_id = $_SESSION['id'];
$event_id = $_GET['event_id'] ?? die("Event ID missing");

// Fetch the existing certificate details
$query = "SELECT s.name AS student_name, e.event_name, c.certificate_id, c.issue_date 
          FROM students s
          JOIN event_registrations er ON s.id = er.student_id
          JOIN events e ON e.event_id = er.event_id
          LEFT JOIN certificates c ON c.student_id = s.id AND c.event_id = e.event_id
          WHERE s.id = ? AND e.event_id = ? AND er.certificate_status = 'approved'";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $student_id, $event_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("No approved certificate available for this event.");
}

$student_name = $row['student_name'];
$event_name = $row['event_name'];
$certificate_id = $row['certificate_id'];
$issue_date = $row['issue_date'];

// **Fix:** Use the existing certificate ID if available
if (empty($certificate_id)) {
    $certificate_id = "CERT-$student_id-$event_id-" . date('Ymd') . "-" . strtoupper(substr(md5(uniqid()), 0, 6));
    $issue_date = date('Y-m-d');

    // Insert the certificate into the database only if it doesn't exist
    $insert_query = "INSERT INTO certificates (student_id, event_id, certificate_id, issue_date) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("iiss", $student_id, $event_id, $certificate_id, $issue_date);
    $insert_stmt->execute();
}

// Generate the PDF
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 20);
        $this->SetTextColor(0, 102, 204);
        $this->Cell(190, 20, "Certificate of Participation", 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 12);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(190, 10, "Issued by ManagementFest", 0, 1, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetLineWidth(1);
$pdf->Rect(10, 10, 190, 277);

$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(190, 10, "This is to certify that", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(0, 51, 153);
$pdf->Cell(190, 10, $student_name, 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(190, 10, "has successfully participated in", 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(255, 69, 0);
$pdf->Cell(190, 10, $event_name, 0, 1, 'C');
$pdf->Ln(15);

$pdf->SetFont('Arial', 'I', 12);
$pdf->SetTextColor(128, 128, 128);
$pdf->Cell(190, 10, "Certificate ID: " . $certificate_id, 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(190, 10, "Issued on: " . $issue_date, 0, 1, 'C');
$pdf->Ln(15);

$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(95, 10, "__________________", 0, 0, 'C');
$pdf->Cell(95, 10, "__________________", 0, 1, 'C');

$pdf->Cell(95, 10, "Coordinator", 0, 0, 'C');
$pdf->Cell(95, 10, "Principal", 0, 1, 'C');

ob_clean();
$pdf->Output('D', "Certificate_{$student_name}_{$event_name}.pdf");
exit();

?>
