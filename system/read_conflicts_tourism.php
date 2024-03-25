<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';

if(isset($_REQUEST['delete_id'])){
    $id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

    $select_stmt = $conn->prepare('SELECT * FROM exams_collision WHERE id = :id'); // sql select query
    $select_stmt->bindParam(':id',$id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    // delete an original record from database
    $delete_stmt = $conn->prepare('DELETE FROM exams_collision WHERE id = :id');
    $delete_stmt->bindParam(':id',$id);
    $delete_stmt->execute();
    header("Location:read_conflicts_tourism.php");
}
?>

<div class="container-fluid">
  <div class="row">  
    <?php include "exam_officer_sidebar.php";?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="wrapper">    
    <div class="">            
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 style="text-align: center;">EXAMS COLLISION IN TOURISM</h1>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Student Code</th>
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
                                    <th style="text-align: center;">Enrol Status</th>
                                    <th style="text-align: center;">Edit</th>
                                    <th style="text-align: center;">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $select_stmt = $conn->prepare("SELECT * FROM exams_collision where timeslot_group_name like '%TOURISM%'"); //sql select query
                                    $select_stmt->execute();
                                    while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                ?>
                                <tr>
                                    <td><?php echo $row['student_code']; ?></td>
                                    <td><?php echo $row['exam_day']; ?></td>
                                    <td><?php echo $row['exam_date']; ?></td>
                                    <td><?php echo $row['exam_time']; ?></td>
                                    <td><?php echo $row['venue_name']; ?></td>
                                    <td><?php echo $row['timeslot_group_name']; ?></td>
                                    <td><?php echo $row['group_capacity']; ?></td>
                                    <td><?php echo $row['timeslot_subject_code']; ?></td>
                                    <td><?php echo $row['timeslot_subject_name']; ?></td>
                                    <td><?php echo $row['timeslot_lect_name']; ?></td>
                                    <td><?php echo $row['invigilator_name']; ?></td>
                                    <td><?php echo $row['enrol_status']; ?></td>
                                    <td><a href="edit_conflicts_tourism.php?update_id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                                    <td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
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
