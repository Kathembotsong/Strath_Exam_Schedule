<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';

if(isset($_POST['btn_update'])){
    $student_code = $_POST['student_code'];
    $exam_day = $_POST['exam_day'];
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $timeslot_group_name = $_POST['timeslot_group_name'];
    $ids = $_POST['id']; // Array of IDs

    if(empty($exam_day) || empty($exam_date) || empty($exam_time) || empty($timeslot_group_name) ){
        $errorMsg = "Please enter all fields";
    } else {
        try {
            // Loop through each ID and update the corresponding record
            foreach($ids as $key => $id) {
                // Update the record
                $update_stmt = $conn->prepare('UPDATE exams_collision SET student_code = :student_code, exam_day = :exam_day, exam_date = :exam_date, exam_time = :exam_time, timeslot_group_name = :timeslot_group_name WHERE id = :id');
                $update_stmt->bindParam(':student_code', $student_code[$key]);
                $update_stmt->bindParam(':exam_day', $exam_day[$key]);
                $update_stmt->bindParam(':exam_date', $exam_date[$key]);
                $update_stmt->bindParam(':exam_time', $exam_time[$key]);
                $update_stmt->bindParam(':timeslot_group_name', $timeslot_group_name[$key]);
                $update_stmt->bindParam(':id', $id);
                
                $update_stmt->execute();
            }
            $updateMsg = "Records updated successfully";
            header("Location:process_first_solution.php"); // Redirect after 3 seconds
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include "examoffice_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 10%; width: 80%;">
                <div class="panel panel-default">
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">FIND HERE CONFLICTS IDENTIFIED</h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/exam_schedule.jpeg" alt="my image here">
                            <?php
                                if(isset($errorMsg)){
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $errorMsg; ?>
                                </div>
                            <?php } ?>

                            <?php
                                if(isset($updateMsg)){
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $updateMsg; ?>
                                </div>
                            <?php } ?>

                            <form method="post">
                                <div class="row">
                                    <?php
                                        // Fetch the records to be edited
                                        $select_stmt = $conn->prepare('SELECT * FROM exams_collision ORDER BY student_code');
                                        $select_stmt->execute();
                                        $rows = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $counter = 0;
                                        foreach($rows as $row) {
                                            if ($counter % 4 == 0 && $counter != 0) {
                                                echo '</div>'; // Close the current row
                                            }
                                            if ($counter % 4 == 0) {
                                                echo '<div class="row">'; // Start a new row
                                            }
                                    ?>
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="student_code_<?php echo $row['id']; ?>" class="form-label">Student Code</label>
                                                            <input type="text" readonly class="form-control" id="student_code_<?php echo $row['id']; ?>" name="student_code[]" value="<?php echo $row['student_code']; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="enrol_status<?php echo $row['id']; ?>" class="form-label">Status</label>
                                                            <input type="text" readonly class="form-control" id="enrol_status<?php echo $row['id']; ?>" name="enrol_status[]" value="<?php echo $row['enrol_status']; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exam_day_<?php echo $row['id']; ?>" class="form-label">Exam Day</label>
                                                            <input type="text" class="form-control" id="exam_day_<?php echo $row['id']; ?>" name="exam_day[]" value="<?php echo $row['exam_day']; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exam_date_<?php echo $row['id']; ?>" class="form-label">Exam Date</label>
                                                            <input type="date" class="form-control" id="exam_date_<?php echo $row['id']; ?>" name="exam_date[]" value="<?php echo $row['exam_date']; ?>" onchange="updateExamDay_<?php echo $row['id']; ?>()">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="exam_time_<?php echo $row['id']; ?>" class="form-label">Exam Time</label>
                                                            <input type="time" class="form-control" id="exam_time_<?php echo $row['id']; ?>" name="exam_time[]" value="<?php echo $row['exam_time']; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="timeslot_group_name<?php echo $row['id']; ?>" class="form-label">Group Name</label>
                                                            <input type="text" class="form-control" id="timeslot_group_name<?php echo $row['id']; ?>" name="timeslot_group_name[]" value="<?php echo $row['timeslot_group_name']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            $counter++;
                                        }
                                    ?>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="btn_update" class="btn btn-primary">solve</button>
                                    <a href="read_conflicts.php" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </center>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

<script>
    // Function to update the exam day based on the selected exam date
    <?php foreach($rows as $row) { ?>
        function updateExamDay_<?php echo $row['id']; ?>() {
            var examDate = document.getElementById('exam_date_<?php echo $row['id']; ?>').value;
            var date = new Date(examDate);
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var examDay = days[date.getDay()];
            document.getElementById('exam_day_<?php echo $row['id']; ?>').value = examDay;
        }
    <?php } ?>
</script>
