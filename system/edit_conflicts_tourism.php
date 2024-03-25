<?php
include 'header.php';
include 'dbcon.php';
include 'js_datatable.php';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Retrieve the exam collision information for the given update_id
    $select_stmt = $conn->prepare('SELECT * FROM exams_collision WHERE id = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the form is submitted for updating
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $conn->beginTransaction();
            // Retrieve form data
            $updated_day = $_POST['updated_day'];
            $updated_date = $_POST['updated_date'];
            $updated_time = $_POST['updated_time'];
            // Update the exam collision details in the database
            $update_stmt_collision = $conn->prepare('UPDATE exams_collision SET exam_day = :exam_day, exam_date = :exam_date, exam_time = :exam_time  WHERE id = :id');
            $update_stmt_collision->bindParam(':exam_day', $updated_day);
            $update_stmt_collision->bindParam(':exam_date', $updated_date);
            $update_stmt_collision->bindParam(':exam_time', $updated_time);
            $update_stmt_collision->bindParam(':id', $update_id);
            $update_stmt_collision->execute();
            
           // Delete all affected rows from exams_collision table
            $delete_stmt = $conn->prepare('DELETE FROM exams_collision WHERE timeslot_subject_code = :timeslot_subject_code AND id != :id');
            $delete_stmt->bindParam(':timeslot_subject_code', $row['timeslot_subject_code']);
            $delete_stmt->bindParam(':id', $update_id);
            $delete_stmt->execute();
            
            // Commit the transaction
            $conn->commit();

            // Redirect after successful update
            header('Location: read_conflicts_tourism.php'); 
            exit();
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            echo '<div class="alert alert-danger" role="alert">Error updating exam collision details: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<!-- Display the form for updates -->
<div class="container-fluid">
    <div class="row">
    <?php include 'exam_officer_sidebar.php'; ?>
        <main class="col-md-5">
            <div class="container" style="margin-left:35%; background-color:rgba(255,105,20,.2); padding:5px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 style="text-align: center;">UPDATE EXAM COLLISION</h1>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="updated_day" class="form-label">Exam Day:</label>
                                <input type="text" name="updated_day" id="updated_day" class="form-control" value="<?php echo $row['exam_day']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_date" class="form-label">Exam Date:</label>
                                <input type="date" name="updated_date" id="updated_date" class="form-control" value="<?php echo $row['exam_date']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_time" class="form-label">Exam Time:</label>
                                <input type="time" name="updated_time" id="updated_time" class="form-control"  required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_status" class="form-label">Enrol Status:</label>
                                <input type="text" name="updated_status" class="form-control" value="<?php echo $row['enrol_status']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="read_conflicts_bbit.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

<script>
    // Function to update the exam day based on the selected exam date
    document.getElementById('updated_date').addEventListener('change', function() {
        var selectedDate = new Date(this.value);
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var examDay = days[selectedDate.getDay()];
        document.getElementById('updated_day').value = examDay;
    });
</script>
