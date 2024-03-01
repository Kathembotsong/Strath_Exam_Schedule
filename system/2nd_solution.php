<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';
?>


<div class="container-fluid">
    <div class="row">
        <?php include "examoffice_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                <?php
                
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
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">CONGRATULATION! Pressure is gone</h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/solution2.png" style="width:60%;" alt="my image here">
                            <form method="post">
                                <!-- Display messages here -->
                                <?php
                                if (!empty($successMessage)) {
                                    echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $successMessage . '</div>';
                                } elseif (!empty($errorMessage)) {
                                    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">' . $errorMessage . '</div>';
                                }
                                ?>
                                <a href="individual_exam_schedule_students.php" style="text-decoration:none;"><span class="btn btn-primary">Verify known cases</span></a>
                                <a href="exam_officer_dashboard.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </center>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

