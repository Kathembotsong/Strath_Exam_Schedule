<?php
require_once('tcpdf/tcpdf.php');
include 'dbcon.php';

// Fetch university header information from the database
$sql = "SELECT * FROM university_header ORDER BY id DESC LIMIT 1"; // Assuming the latest entry is the current header
$stmt = $conn->query($sql);
$universityHeaderData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$universityHeaderData) {
    // Handle case where no university header is found
    echo "Error: University header not found.";
    exit;
}

// Extract university header data
$universityName = $universityHeaderData['university_name'];
$faculties = $universityHeaderData['faculties'];
$term = $universityHeaderData['term'];

// Create new TCPDF instance with landscape orientation
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->AddPage();

// Set font
$pdf->SetFont('dejavusans', '', 12);

// University Header
$html = '<div style="text-align: center; background-color: #007bff; color: white; padding: 10px;">';
$html .= '<h1>' . $universityName . '</h1>';
$html .= '<p>Faculties: ' . $faculties . '</p>';
$html .= '<p>Term: ' . $term . '</p>';
$html .= '</div>';
$pdf->writeHTML($html, true, false, true, false, '');

// Fetch exam schedule data from the database
$sql = "SELECT * FROM merged_data GROUP BY exam_day, exam_date, exam_time, timeslot_subject_code ORDER BY exam_date";
$stmt = $conn->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if data is available
if (count($data) > 0) {
    // Add table header
    $pdf->Ln(10); // Add space before the table
    $pdf->Cell(0, 10, 'University Exam Schedule', 0, 1, 'C');
    $pdf->Ln(5); // Add space after the header
    $pdf->SetFont('dejavusans', 'B', 10); // Set font size for table header

    // Dynamically generate table header based on columns in merged_data table
    $header = array('Student Code', 'Exam Day', 'Exam Date', 'Exam Time', 'Venue Name', 'Timeslot Group Name', 'Group Capacity', 'Timeslot Subject Code', 'Timeslot Subject Name', 'Timeslot Lecturer Name', 'Invigilator Name');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(255, 255, 255);
    $pdf->SetLineWidth(0.2);
    $pdf->SetFont('', 'B');
    foreach ($header as $col) {
        $pdf->Cell(40, 7, $col, 1, 0, 'C', 1);
    }
    $pdf->Ln();
    $pdf->SetFont('');

    // Set font size for table data
    $pdf->SetFont('dejavusans', '', 10); // Change 10 to the desired font size

    // Add table data
    foreach ($data as $row) {
        $pdf->Cell(40, 7, $row['student_code'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['exam_day'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['exam_date'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['exam_time'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['venue_name'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['timeslot_group_name'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['group_capacity'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['timeslot_subject_code'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['timeslot_subject_name'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['timeslot_lect_name'], 1, 0, 'C');
        $pdf->Cell(40, 7, $row['invigilator_name'], 1, 0, 'C');
        $pdf->Ln();
    }
} else {
    // No exam schedule data found
    $pdf->Cell(0, 10, 'No exam schedule data found.', 0, 1, 'C');
}

// Output PDF as a string
$pdfContent = $pdf->Output('university_exam_schedule.pdf', 'S');

// Send PDF to the browser for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="university_exam_schedule.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($pdfContent));

echo $pdfContent;
exit;
?>
