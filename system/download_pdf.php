<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Include database connection
include 'dbcon.php';

// Function to generate and download the PDF
function generateAndDownloadPDF($conn, $invigilatorName) {
    // Create new TCPDF instance with landscape orientation
    $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Exam Schedule PDF');
    $pdf->SetSubject('Exam Schedule');
    $pdf->SetKeywords('Exam, Schedule');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('dejavusans', '', 12);

    // Fetch exam schedule data from the database
    $sql = "SELECT * FROM merged_data WHERE invigilator_name = :invigilator_name GROUP BY exam_day, exam_date, exam_time, timeslot_subject_code";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':invigilator_name', $invigilatorName, PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if data is available
    if (count($data) > 0) {
        // Add table header
        $pdf->Ln(5); // Add space before the table
        $pdf->Cell(0, 5, 'Exam Schedule for Invigilator: ' . $invigilatorName, 0, 1, 'C');
        $pdf->Ln(5); // Add space after the header
        $pdf->SetFont('dejavusans', 'B', 12);
        $header = array('Exam Day', 'Exam Date', 'Exam Time', 'Subject Code', 'Subject Name', 'Group Name', 'Exam Venue');
        $pdf->SetFillColor(220, 220, 220);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->SetLineWidth(0.2);
        $pdf->SetFont('', 'B');
        foreach ($header as $col) {
            $pdf->Cell(40, 10, $col, 1, 0, 'C', 1);
        }
        $pdf->Ln();
        $pdf->SetFont('');

        // Add table data
        foreach ($data as $row) {
            $pdf->Cell(40, 10, $row['exam_day'], 1, 0, 'C', 0, '', 1);
            $pdf->Cell(40, 10, $row['exam_date'], 1, 0, 'C', 0, '', 1);
            $pdf->Cell(40, 10, $row['exam_time'], 1, 0, 'C', 0, '', 1);
            $pdf->Cell(40, 10, $row['timeslot_subject_code'], 1, 0, 'C', 0, '', 1);
            $pdf->Cell(40, 5, $row['timeslot_subject_name'], 1, 0, 'C', 0, '', 1);
            $pdf->Cell(40, 10, $row['timeslot_group_name'], 1, 0, 'C', 0, '', 1);
            $pdf->Cell(40, 10, $row['venue_name'], 1, 0, 'C', 0, '', 1);
            $pdf->Ln();
        }

        // Output PDF as a string
        $pdfContent = $pdf->Output('exam_schedule.pdf', 'S');

        // Send PDF to the browser for download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="exam_schedule.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($pdfContent));

        echo $pdfContent;
        exit;
    } else {
        echo "No exam schedule data found.";
        exit;
    }
}

// Call the function to generate and download the PDF if the invigilator name is provided
if (isset($_POST['download_pdf']) && isset($_POST['invigilator_name'])) {
    $invigilatorName = $_POST['invigilator_name'];
    generateAndDownloadPDF($conn, $invigilatorName);
} else {
    echo "No name is provided. Please provide one";
}
?>
