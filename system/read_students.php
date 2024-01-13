
<?php include 'header.php';?>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <img src="../system/assets/strathLogo.ico" alt="University Logo" style="width: 50px;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">My Exam Schedule</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">Sign out</a>
            </div>
        </div>
    </header>

    <?php
      include 'dbcon.php'; 
      include 'js_datatable.php'; 
      include 'sidebar.php'; 
      ?>

<?php 
if(isset($_REQUEST['delete_id'])){
	// select image from database to delete
	$id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

	$select_stmt = $connection->prepare('SELECT * FROM students WHERE student_id =:id'); // sql select query
	$select_stmt->bindParam(':id',$id);
	$select_stmt->execute();
	$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
	// delete an original record from database
	$delete_stmt = $connection->prepare('DELETE FROM students WHERE student_id =:id');
	$delete_stmt->bindParam(':id',$id);
	$delete_stmt->execute();

	header("Location:read_students.php");
}

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="wrapper">	
	<div class="">			
		<div class="col-lg-12">
			<div class="panel panel-default">
                    <div class="panel-heading">
                    	<h1 style="text-align: center;">STUDENTS</h1>
                        <h3><a href="create_theologians.php"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add File</a></h3>
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
										$select_stmt = $conn->prepare("SELECT * FROM students"); //sql select query
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