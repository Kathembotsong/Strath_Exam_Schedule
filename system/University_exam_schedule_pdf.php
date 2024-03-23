



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

// Define array keys
$studentCodes = [];
$examDays = [];
$examDates = [];
$examTimes = [];
$venueNames = [];
$timeslotGroupNames = [];
$groupCapacities = [];
$timeslotSubjectCodes = [];
$timeslotSubjectNames = [];
$timeslotLectNames = [];
$invigilatorNames = [];

// Populate arrays with data
foreach ($data as $row) {
    $studentCodes[] = $row['student_code'];
    $examDays[] = $row['exam_day'];
    $examDates[] = $row['exam_date'];
    $examTimes[] = $row['exam_time'];
    $venueNames[] = $row['venue_name'];
    $timeslotGroupNames[] = $row['timeslot_group_name'];
    $groupCapacities[] = $row['group_capacity'];
    $timeslotSubjectCodes[] = $row['timeslot_subject_code'];
    $timeslotSubjectNames[] = $row['timeslot_subject_name'];
    $timeslotLectNames[] = $row['timeslot_lect_name'];
    $invigilatorNames[] = $row['invigilator_name'];
}

// Check if data is available
if (count($data) > 0) {
    // Add table header
    $pdf->Ln(10); // Add space before the table
    $pdf->Cell(0, 10, 'University Exam Schedule', 0, 1, 'C');
    $pdf->Ln(5); // Add space after the header
    $pdf->SetFont('dejavusans', 'B', 10); // Set font size for table header

    // Define table header
    $header = array('Day', 'Date', 'Time', 'Venue', 'Group', 'Capacity', 'Code', 'Subject', 'Lecturer', 'Invigilator');

    // Set column widths
    $columnWidths = array(22, 22, 22, 31, 20, 10, 22, 78, 28, 22);

    // Output table header
    $pdf->SetFillColor(220, 220, 220);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0, 0, 0); // Set border color to black
    $pdf->SetLineWidth(0.2);
    $pdf->SetFont('', 'B');
    foreach ($header as $key => $col) {
        $pdf->Cell($columnWidths[$key], 7, $col, 1, 0, '', 1);
    }
    $pdf->Ln();
    $pdf->SetFont('');

    // Set font size for table data
    $pdf->SetFont('dejavusans', '', 7);

    // Add table data
    $rowCount = count($studentCodes);
    for ($i = 0; $i < $rowCount; $i++) {
        $pdf->Cell($columnWidths[0], 7, $examDays[$i], 'LTRB', 0, ''); // Day
        $pdf->Cell($columnWidths[1], 7, $examDates[$i], 'LTRB', 0, ''); // Date
        $pdf->Cell($columnWidths[2], 7, $examTimes[$i], 'LTRB', 0, ''); // Time
        $pdf->Cell($columnWidths[3], 7, $venueNames[$i], 'LTRB', 0, ''); // Venue
        $pdf->Cell($columnWidths[4], 7, $timeslotGroupNames[$i], 'LTRB', 0, ''); // Group
        $pdf->Cell($columnWidths[5], 7, $groupCapacities[$i], 'LTRB', 0, ''); // Capacity
        $pdf->Cell($columnWidths[6], 7, $timeslotSubjectCodes[$i], 'LTRB', 0, ''); // Code
        $pdf->Cell($columnWidths[7], 7, $timeslotSubjectNames[$i], 'LTRB', 0, ''); // Subject
        $pdf->Cell($columnWidths[8], 7, $timeslotLectNames[$i], 'LTRB', 0, ''); // Lecturer
        $pdf->Cell($columnWidths[9], 7, $invigilatorNames[$i], 'LTRB', 1, ''); // Invigilator
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
