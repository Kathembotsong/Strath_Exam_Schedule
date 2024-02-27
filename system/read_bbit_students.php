
<?php 
	  include 'dbcon.php'; 
	  include 'header.php';     
	  include 'js_datatable.php';
 ?>  

<?php 
if(isset($_REQUEST['delete_id'])){
	// select image from database to delete
	$id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

	$select_stmt = $conn->prepare('SELECT * FROM students WHERE student_id =:id'); // sql select query
	$select_stmt->bindParam(':id',$id);
	$select_stmt->execute();
	$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
	// delete an original record from database
	$delete_stmt = $conn->prepare('DELETE FROM students WHERE student_id =:id');
	$delete_stmt->bindParam(':id',$id);
	$delete_stmt->execute();
	header("Location:read_scs_students.php");
}
?>
<div class="container-fluid">
  <div class="row">  
	<?php include "bbit_facadmin_sidebar.php";?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="wrapper">	
	<div class="">			
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h1 style="text-align: center;">STUDENTS</h1>
                    <h3><a href="create_multiple_students.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp;Multiple New Student</a></h3>
                    <h3><a href="create_single_student.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp;Single New Student</a></h3>
                </div>
                <div class="panel-body">
                	<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<th style="text-align: center;">Student Code</th>
                                    <th style="text-align: center;">Student Name</th>
                                    <th style="text-align: center;">Student Email</th>
                                    <th style="text-align: center;">Student Phone</th>
                                    <th style="text-align: center;">Student School</th>
                                    <th style="text-align: center;">Edit</th>
									<th style="text-align: center;">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php 
                                    $school=
									$select_stmt = $conn->prepare("SELECT * FROM students where student_school='BBIT'"); //sql select query
                                    //$select_stmt->bindParam(':school',$school)
									$select_stmt->execute();
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
								{
								?>
							    <tr>
						    		<td><?php echo $row['student_code']; ?></td>
                                    <td><?php echo $row['student_name']; ?></td>
                                    <td><?php echo $row['student_email']; ?></td>
                                    <td><?php echo $row['student_phone']; ?></td>
                                    <td><?php echo $row['student_school']; ?></td>
                                    <td><a href="edit_students.php?update_id=<?php echo $row['student_id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
									<td><a href="?delete_id=<?php echo $row['student_id']; ?>" class="btn btn-danger"><i class="fas fa-trash"></a></td>
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