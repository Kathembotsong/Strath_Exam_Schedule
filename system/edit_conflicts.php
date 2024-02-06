<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';

if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];

    // Fetch the record to be edited
    $select_stmt = $conn->prepare('SELECT * FROM exams_collision WHERE id = :id');
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['btn_update'])){
    $id = $_POST['id'];
    $exam_day = $_POST['exam_day'];
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    
    if(empty($exam_date) || empty($exam_time)){
        $errorMsg = "Please enter all fields";
    } else {
        try {
            // Update the record
            // Note: exam_day is being updated based on the selected exam_date
            $update_stmt = $conn->prepare('UPDATE exams_collision SET exam_date = :exam_date, exam_time = :exam_time, exam_day = DAYNAME(:exam_date) WHERE id = :id');
            $update_stmt->bindParam(':exam_date', $exam_date);
            $update_stmt->bindParam(':exam_time', $exam_time);
            $update_stmt->bindParam(':id', $id);
            
            if($update_stmt->execute()){
                $updateMsg = "Record updated successfully";
                header("refresh:3;read_conflicts.php"); // Redirect after 3 seconds
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<div class="container">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Conflict</h4>
                </div>
                <div class="card-body">
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
                    
                    <form method="post" class="row g-3">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="col-md-6">
                            <label for="exam_day" class="form-label">Exam Day</label>
                            <input type="text" class="form-control" id="exam_day" name="exam_day" value="<?php echo $row['exam_day']; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="exam_date" class="form-label">Exam Date</label>
                            <input type="date" class="form-control" id="exam_date" name="exam_date" value="<?php echo $row['exam_date']; ?>" onchange="updateExamDay()">
                        </div>
                        <div class="col-md-6">
                            <label for="exam_time" class="form-label">Exam Time</label>
                            <input type="time" class="form-control" id="exam_time" name="exam_time" value="<?php echo $row['exam_time']; ?>">
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" name="btn_update" class="btn btn-primary">Update</button>
                            <a href="read_conflicts.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

