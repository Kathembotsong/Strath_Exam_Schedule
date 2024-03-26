<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

// Initialize variables to store messages
$successMessage = "";
$errorMessage = "";

if (isset($_POST['submit'])) {
    try {
        // Perform the data insertion into the existing merged_data_bbt table
        $insertDataQuery = "
    INSERT INTO merged_data (
        student_code,
        exam_day,
        exam_date,
        exam_time,
        venue_name,
        timeslot_group_name,
        group_capacity,
        timeslot_subject_code,
        timeslot_subject_name,
        timeslot_lect_name,
        invigilator_name,
        enrol_status
    )
    SELECT
        et.student_code,
        t.exam_day,
        t.exam_date,
        t.exam_time,
        t.venue_name,
        t.group_name AS timeslot_group_name,
        t.group_capacity,
        t.subject_code AS timeslot_subject_code,
        t.subject_name AS timeslot_subject_name,
        t.lect_name AS timeslot_lect_name,
        t.invigilator_name,
        et.enrol_status
    FROM
        enrollments_bcom et
    JOIN
        timeslot_bbt t
    ON
        et.subject_code = t.subject_code;
";


        // Execute the data insertion query
        $conn->exec($insertDataQuery);

        // Set success message
        $successMessage = "Processed successfully.";
        header("Location:conflicts_identification_bcom.php");
    } catch (PDOException $e) {
        // Set error message
        $errorMessage = "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include "exam_officer_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">PROCESS BCOM EXAM SCHEDULE</h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/exam_schedule.jpeg" alt="my image here">
                            <form method="post">
                                <?php
                                if (!empty($successMessage)) {
                                    echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $successMessage . '</div>';
                                } elseif (!empty($errorMessage)) {
                                    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">' . $errorMessage . '</div>';
                                }
                                ?>
                                <button type="submit" name="submit" class="btn btn-primary">Process</button>
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