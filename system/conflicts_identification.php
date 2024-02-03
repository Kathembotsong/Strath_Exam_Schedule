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

    // Insert rows into exams_collision table
    $insertQuery = "
        INSERT INTO exams_collision
        SELECT *
        FROM merged_data
        WHERE (student_code, exam_date) IN (
            SELECT student_code, exam_date
            FROM merged_data
            GROUP BY student_code, exam_date
            HAVING COUNT(*) > 1
        )
    ";
    $conn->exec($insertQuery);

    // Delete rows from merged_data table
    $deleteQuery = "
        DELETE FROM merged_data
        WHERE (student_code, exam_date) IN (
            SELECT student_code, exam_date
            FROM exams_collision
        )
    ";
    $conn->exec($deleteQuery);

    // Commit the transaction
    $conn->commit();

    $successMessage = "Transaction successful!";
} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $conn->rollBack();
    $errorMessage = "Error: " . $e->getMessage();
}

?>

<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">CONFLICTS IDENTIFICATION</h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/collision.jpg" style="width:40%;" alt="my image here">
                            <form method="post">
                                <!-- Display messages here -->
                                <?php
                                if (!empty($successMessage)) {
                                    echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $successMessage . '</div>';
                                } elseif (!empty($errorMessage)) {
                                    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">' . $errorMessage . '</div>';
                                }
                                ?>
                                <a href="read_conflicts.php" style="text-decoration:none;"><span class="btn btn-primary">Identify</span></a>
                                <a href="#" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </center>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
