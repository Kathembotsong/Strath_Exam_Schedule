<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php'; 

// Initialize variable to store success/error message
$message = '';

// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    try {
        // Prepare the delete query for merged_data table
        $deleteQuery = "DELETE FROM merged_data WHERE timeslot_group_name LIKE '%SCS%'";

        // Execute the delete query for merged_data table
        $stmt = $conn->prepare($deleteQuery);
        $stmt->execute();

        // Prepare the delete query for exams_collision table
        $deleteCollision = "DELETE FROM exams_collision WHERE timeslot_group_name LIKE '%SCS%'";

        // Execute the delete query for exams_collision table
        $stmt = $conn->prepare($deleteCollision);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            header("location:process_exam_scheduling_scs.php");
        } else {
            $message = "No data found to delete.";
        }
    } catch (PDOException $e) {
        // Handle database error
        $message = "Error: " . $e->getMessage();
    }
}

// Close the database connection
$conn = null;
?>
<div class="container-fluid">
    <div class="row">
        <?php include "exam_officer_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">REPROCESSING SCS EXAM SCHEDULE?</h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/reprocess.png" style="width:60%;" alt="my image here">
                            <form method="post">
                                <?php
                                if (!empty($message)) {
                                    echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $message . '</div>';
                                }
                                ?>
                                <button type="submit" name="delete" class="btn btn-success">Reprocess</button>
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
