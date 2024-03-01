
<?php 
	  include 'dbcon.php'; 
	  include 'header.php';     
	  include 'js_datatable.php';
 ?>  

?>
<div class="container-fluid">
  <div class="row">  
  <?php include "schooladmin_sidebar.php";?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
<div class="wrapper">	
	<div class="">			
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h1 style="text-align: center;">SUBJECTS IN SCS [ READ ONLY ]</h1>
                </div>
                <div class="panel-body">
                	<div class="table-responsive">
						<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
							<thead>
								<tr>
									<th style="text-align: center;">Subject Code</th>
                                    <th style="text-align: center;">Subject Name</th>
                                </tr>
							</thead>
							<tbody>
								<?php 
									$select_stmt = $conn->prepare("SELECT * FROM subjects_scs"); //sql select query
									$select_stmt->execute();
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
								{
								?>
							    <tr>
						    		<td style="text-align: center;"><?php echo $row['subject_code']; ?></td>
                                    <td style="text-align: center;"><?php echo $row['subject_name']; ?></td>
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