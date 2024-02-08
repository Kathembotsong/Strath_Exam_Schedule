<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

// Initialize variables to store messages
$successMessage = "";
$errorMessage = "";

try {
    // Start a transaction
    $conn->beginTransaction();

    // Identify minority exam details
    $minorityQuery = "
        SELECT exam_day, exam_date, timeslot_subject_code, timeslot_group_name
        FROM merged_data
        GROUP BY exam_day, exam_date, timeslot_subject_code, timeslot_group_name
        HAVING COUNT(DISTINCT student_code) = 1
    ";
    $stmt = $conn->prepare($minorityQuery);
    $stmt->execute();
    $minorityRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Update exam dates for majority students to match the minority
    foreach ($minorityRows as $minorityRow) {
        $updateQuery = "
            UPDATE merged_data
            SET exam_day = :exam_day, exam_date = :exam_date
            WHERE timeslot_subject_code = :timeslot_subject_code
            AND timeslot_group_name = :timeslot_group_name
            AND (exam_day != :exam_day OR exam_date != :exam_date)
        ";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':exam_day', $minorityRow['exam_day']);
        $stmt->bindParam(':exam_date', $minorityRow['exam_date']);
        $stmt->bindParam(':timeslot_subject_code', $minorityRow['timeslot_subject_code']);
        $stmt->bindParam(':timeslot_group_name', $minorityRow['timeslot_group_name']);
        $stmt->execute();
    }

    // Commit the transaction
    $conn->commit();

    $successMessage = "Exam dates updated successfully!";
} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $conn->rollBack();
    $errorMessage = "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Exam Dates</title>
    <!-- Include any CSS files or stylesheets here -->
</head>
<body>
    <div class="container">
        <h1>Update Exam Dates</h1>
        <p>This script updates the exam dates for majority students in the merged_data table to match the minority in terms of exam day and date, based on specific conditions.</p>
        <div class="result">
            <!-- Display the result of the operation here -->
            <?php
            if (!empty($successMessage)) {
                echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $successMessage . '</div>';
            } elseif (!empty($errorMessage)) {
                echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">' . $errorMessage . '</div>';
            }
            ?>
        </div>
    </div>
    <!-- Include any JavaScript files or scripts here -->
</body>
</html>
