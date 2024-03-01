<?php
    include 'dbcon.php';
    include 'header.php';
    include 'js_datatable.php'; 
?>

    <?php include "examoffice_sidebar.php"; ?>
     <div class="container-fluid">
    <div class="row">
        <?php include "examoffice_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                <?php
         try {
            // Retrieve all rows from the exams_collision table
            $selectStmt = $conn->query("SELECT * FROM exams_collision");
            $rows = $selectStmt->fetchAll(PDO::FETCH_ASSOC);

            // Start a transaction
            $conn->beginTransaction();

            // Insert each row into the merged_data table
            foreach ($rows as $row) {
                $insertStmt = $conn->prepare("
                    INSERT INTO merged_data 
                    (student_code, exam_day, exam_date, exam_time, venue_name, timeslot_group_name, group_capacity, timeslot_subject_code, timeslot_subject_name, timeslot_lect_name, invigilator_name, id) 
                    VALUES 
                    (:student_code, :exam_day, :exam_date, :exam_time, :venue_name, :timeslot_group_name, :group_capacity, :timeslot_subject_code, :timeslot_subject_name, :timeslot_lect_name, :invigilator_name, :id)
                ");

                $insertStmt->execute([
                    ':student_code' => $row['student_code'],
                    ':exam_day' => $row['exam_day'],
                    ':exam_date' => $row['exam_date'],
                    ':exam_time' => $row['exam_time'],
                    ':venue_name' => $row['venue_name'],
                    ':timeslot_group_name' => $row['timeslot_group_name'],
                    ':group_capacity' => $row['group_capacity'],
                    ':timeslot_subject_code' => $row['timeslot_subject_code'],
                    ':timeslot_subject_name' => $row['timeslot_subject_name'],
                    ':timeslot_lect_name' => $row['timeslot_lect_name'],
                    ':invigilator_name' => $row['invigilator_name'],
                    ':id' => $row['id']
                ]);
            }

            // Optionally, delete rows from the exams_collision table
            $deleteStmt = $conn->exec("DELETE FROM exams_collision");

            // Commit the transaction
            $conn->commit();
        } catch (PDOException $e) {
            // Rollback the transaction in case of an error
            $conn->rollBack();
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
        ?>
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">FIRST SOLUTION EXECUTED</h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/solution1.jpg" style="width:60%;" alt="my image here">
                            <form method="post">
                                <!-- Display messages here -->
                                <?php
                                if (!empty($successMessage)) {
                                    echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $successMessage . '</div>';
                                } elseif (!empty($errorMessage)) {
                                    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">' . $errorMessage . '</div>';
                                }
                                ?>
                                <a href="read_conflicts.php" style="text-decoration:none;"><span class="btn btn-primary">Process solution 2</span></a>
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

