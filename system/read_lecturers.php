
<?php 
	  include 'dbcon.php'; 
	  include 'header.php';     
	  include 'js_datatable.php';
 ?>  

<?php 
if(isset($_REQUEST['delete_id'])){
	$id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

	$select_stmt = $conn->prepare('SELECT * FROM lecturers WHERE lecturer_id =:id'); // sql select query
	$select_stmt->bindParam(':id',$id);
	$select_stmt->execute();
	$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
	// delete an original record from database
	$delete_stmt = $conn->prepare('DELETE FROM lecturers WHERE lecturer_id =:id');
	$delete_stmt->bindParam(':id',$id);
	$delete_stmt->execute();
	header("Location:read_lecturers.php");
}
?>
<div class="container-fluid">
  <div class="row">  
  <?php include 'schooladmin_sidebar.php'; ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="wrapper">	
	<div class="">			
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h1 style="text-align: center;">LECTURERS</h1>
                    <h3><a href="create_multiple_lecturers.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp;Multiple New Lecturers</a></h3>
                    <h3><a href="create_single_lecturer.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp;Single New Lecturer</a></h3>
                </div>
                <div class="panel-body">
                	<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<th style="text-align: center;">Lecturer Code</th>
                                    <th style="text-align: center;">Lecturer Name</th>
                                    <th style="text-align: center;">Lecturer Email</th>
                                    <th style="text-align: center;">Lecturer Phone</th>
                                    <th style="text-align: center;">Lecturer School</th>
                                    <th style="text-align: center;">Edit</th>
									<th style="text-align: center;">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$select_stmt = $conn->prepare("SELECT * FROM lecturers"); //sql select query
									$select_stmt->execute();
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
								{
								?>
							    <tr>
						    		<td><?php echo $row['lecturer_code']; ?></td>
                                    <td><?php echo $row['lecturer_name']; ?></td>
                                    <td><?php echo $row['lecturer_email']; ?></td>
                                    <td><?php echo $row['lecturer_phone']; ?></td>
                                    <td><?php echo $row['lecturer_school']; ?></td>
                                    <td><a href="edit_lecturers.php?update_id=<?php echo $row['lecturer_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
									<td><a href="?delete_id=<?php echo $row['lecturer_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></a></td>
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