<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';

// Read data from group_scs table
$venueStmt = $conn->query("SELECT * FROM group_sls");

if(isset($_REQUEST['delete_id'])){
	$id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

	$select_stmt = $conn->prepare('SELECT * FROM group_sls WHERE group_id =:id'); // sql select query
	$select_stmt->bindParam(':id',$id);
	$select_stmt->execute();
	$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
	// delete an original record from database
	$delete_stmt = $conn->prepare('DELETE FROM group_sls WHERE group_id =:id');
	$delete_stmt->bindParam(':id',$id);
	$delete_stmt->execute();
	header("Location:read_group_sls.php");
}
?>

<div class="container-fluid">
    <div class="row">  
    <?php include 'sls_facadmin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">GROUP CAPACITY</h1>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Group Name</th>
                                            <th style="text-align: center;">Group Capacity</th>
                                            <th style="text-align: center;">Edit</th>
                                            <th style="text-align: center;">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($row = $venueStmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $row['group_name']; ?></td>
                                            <td style="text-align: center;"><?php echo $row['group_capacity']; ?></td>
                                            <td style="text-align: center;"><a href="edit_group_sls.php?update_id=<?php echo $row['group_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                                            <td style="text-align: center;"><a href="?delete_id=<?php echo $row['group_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></a></td>
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
