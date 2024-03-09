
<?php 
	  include 'dbcon.php'; 
	  include 'header.php';     
	  include 'js_datatable.php';
 ?>  

<?php 
if(isset($_REQUEST['delete_id'])){
	$id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

	$select_stmt = $conn->prepare('SELECT * FROM subjects_bcom WHERE subject_code =:id'); // sql select query
	$select_stmt->bindParam(':id',$id);
	$select_stmt->execute();
	$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
	// delete an original record from database
	$delete_stmt = $conn->prepare('DELETE FROM subjects_bcom WHERE subject_code =:id');
	$delete_stmt->bindParam(':id',$id);
	$delete_stmt->execute();
	header("Location:read_subjects_scs.php");
}
?>
<div class="container-fluid">
  <div class="row">  
	<?php include "bcom_facadmin_sidebar.php";?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="wrapper">	
	<div class="">			
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h1 style="text-align: center;">UNITS IN BCOM</h1>
                    <h3><a href="create_subjects_bcom.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp; New unit</a></h3>
                </div>
                <div class="panel-body">
                	<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<th style="text-align: center;">Unit Code</th>
                                    <th style="text-align: center;">Unit Name</th>
                                    <th style="text-align: center;">Edit</th>
									<th style="text-align: center;">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$select_stmt = $conn->prepare("SELECT * FROM subjects_bcom"); //sql select query
									$select_stmt->execute();
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
								{
								?>
							    <tr>
						    		<td><?php echo $row['subject_code']; ?></td>
                                    <td><?php echo $row['subject_name']; ?></td>
                                    <td><a href="edit_subjects_bcom.php?update_id=<?php echo $row['subject_code']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
									<td><a href="?delete_id=<?php echo $row['subject_code']; ?>" class="btn btn-danger"><i class="fas fa-trash"></a></td>
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