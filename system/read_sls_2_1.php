<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';

if(isset($_REQUEST['delete_id'])){
    $id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

    $select_stmt = $conn->prepare('SELECT * FROM enrollments_sls WHERE enrol_id =:id'); // sql select query
    $select_stmt->bindParam(':id',$id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    // delete an original record from the database
    $delete_stmt = $conn->prepare('DELETE FROM enrollments_sls WHERE enrol_id =:id');
    $delete_stmt->bindParam(':id',$id);
    $delete_stmt->execute();
    header("Location:read_sls_2_1.php");
}

$group_name = "SLS 2.1";
$select_stmt = $conn->prepare("SELECT * FROM enrollments_sls WHERE group_name = :group_name");
$select_stmt->bindParam(':group_name', $group_name);
$select_stmt->execute();
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
                            <h1 style="text-align: center;">SLS 2.1</h1>
                            <h3><a href="enrollment_sls.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp; Single New Student</a></h3>
                            <h3><a href="enrollment_multiple_sls.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp; Multiple New Students</a></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Student Code</th>
                                            <th style="text-align: center;">Subject Code</th>
                                            <th style="text-align: center;">Subject Name</th>
                                            <th style="text-align: center;">Group Name</th>
                                            <th style="text-align: center;">Lecturer Name</th>
                                            <th style="text-align: center;">Enrol Status</th>
                                            <th style="text-align: center;">Edit</th>
                                            <th style="text-align: center;">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['student_code']; ?></td>
                                            <td><?php echo $row['subject_code']; ?></td>
                                            <td><?php echo $row['subject_name']; ?></td>
                                            <td><?php echo $row['group_name']; ?></td>
                                            <td><?php echo $row['lect_name']; ?></td>
                                            <td><?php echo $row['enrol_status']; ?></td>
                                            <td><a href="edit_enrollment_sls.php?update_id=<?php echo $row['enrol_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                                            <td><a href="?delete_id=<?php echo $row['enrol_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></a></td>
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
