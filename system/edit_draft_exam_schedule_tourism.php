<?php
include 'header.php';
include 'dbcon.php';    

// Check if update ID is set
if(isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];
    
    // Fetch the record to be edited
    $select_stmt = $conn->prepare('SELECT * FROM timeslot_bbt WHERE time_id = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if form is submitted for updating
    if(isset($_POST['btn_update'])) {
        // Retrieve form data
        $exam_day = $_POST['exam_day'];
        $exam_date = $_POST['exam_date'];
        $exam_time = $_POST['exam_time'];
        
        // Update the record in the database
        $update_stmt = $conn->prepare('UPDATE timeslot_bbt SET exam_day = :exam_day, exam_date = :exam_date, exam_time = :exam_time WHERE time_id = :id');
        $update_stmt->bindParam(':exam_day', $exam_day);
        $update_stmt->bindParam(':exam_date', $exam_date);
        $update_stmt->bindParam(':exam_time', $exam_time);       
        $update_stmt->bindParam(':id', $update_id);
        if($update_stmt->execute()) {
            header('Location: read_draft_exam_schedule_tourism.php');
            exit;
        } else {
            echo 'unexpected error has occured! Please check what could be the problem';
        }
    }
}
?>
<div class="container-fluid">
  <div class="row">  
  <?php include "bbit_facadmin_sidebar.php";?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="wrapper">    
            <div class="">            
                <div class="col-lg-12">
                    <div class="card" style="width:40%; margin-left:30%; padding:5px; background-color: rgba(40,40,40,.2)">
                        <div class="panel-heading" style="text-align: center; background-color: rgba(55,208,198,.2)">
                            <h1>EDIT EXAM SLOT</h1>
                        </div>
                           <form method="post">
                            <div class="form-group">
                                <label for="exam_day">Exam Day:</label>
                                <input type="text" class="form-control" id="exam_day" name="exam_day" value="<?php echo $row['exam_day']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exam_date">Exam Date:</label>
                                <input type="date" class="form-control" id="exam_date" name="exam_date" value="<?php echo $row['exam_date']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exam_time">Exam Time:</label>
                                <input type="text" class="form-control" id="exam_time" name="exam_time" value="<?php echo $row['exam_time']; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary" name="btn_update">Update</button>
                           </form>   
                    </div>
                </div>
            </div>          
        </div>
    </main>
    <?php require 'footer.php' ?>
</div>
</div>
