<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';
?>  

<?php 
if(isset($_REQUEST['delete_id'])){
    $id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

    $select_stmt = $conn->prepare('SELECT * FROM timeslot_bbt WHERE time_id = :id'); // sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    
    // delete an original record from the database
    $delete_stmt = $conn->prepare('DELETE FROM timeslot_bbt WHERE time_id = :id');
    $delete_stmt->bindParam(':id', $id);
    $delete_stmt->execute();
    header("Location: read_timeslot_bbt.php");
}
?>
<div class="container-fluid">
  <div class="row">  
    <?php include "sidebar.php";?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="wrapper">    
            <div class="">            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">TIMESLOTS TOURISM</h1>
                            <h3><a href="create_timeslot_tourism.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp; New Exam</a></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Exam Day</th>
                                            <th style="text-align: center;">Exam Date</th>
                                            <th style="text-align: center;">Exam Time</th>
                                            <th style="text-align: center;">Venue Name</th>
                                            <th style="text-align: center;">Group Name</th>
                                            <th style="text-align: center;">Group Capacity</th>
                                            <th style="text-align: center;">Subject Code</th>
                                            <th style="text-align: center;">Subject Name</th>
                                            <th style="text-align: center;">Lecturer Name</th>
                                            <th style="text-align: center;">Invigilator Name</th>
                                            <th style="text-align: center;">Edit</th>
                                            <th style="text-align: center;">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $select_stmt = $conn->prepare("SELECT * FROM timeslot_bbt where group_name like '%TOURISM%' "); //sql select query
                                            $select_stmt->execute();
                                            while($row = $select_stmt->fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['exam_day']; ?></td>
                                            <td><?php echo $row['exam_date']; ?></td>
                                            <td><?php echo $row['exam_time']; ?></td>
                                            <td><?php echo $row['venue_name']; ?></td>
                                            <td><?php echo $row['group_name']; ?></td>
                                            <td><?php echo $row['group_capacity']; ?></td>
                                            <td><?php echo $row['subject_code']; ?></td>
                                            <td><?php echo $row['subject_name']; ?></td>
                                            <td><?php echo $row['lect_name']; ?></td>
                                            <td><?php echo $row['invigilator_name']; ?></td>
                                            <td><a href="edit_draft_exam_schedule_sls.php?update_id=<?php echo $row['time_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                                            <td><a href="?delete_id=<?php echo $row['time_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                                        </tr>
                                        <?php
                                        }                   
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </main>
    <?php require 'footer.php' ?>
</div>
</div>
