<?php 
include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';
?>


<?php 
if(isset($_REQUEST['delete_id'])){
	$id = $_REQUEST['delete_id']; // get delete_id and store in $id variable

	$select_stmt = $conn->prepare('SELECT * FROM exam_venue WHERE venue_id =:id'); // sql select query
	$select_stmt->bindParam(':id',$id);
	$select_stmt->execute();
	$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
	// delete an original record from database
	$delete_stmt = $conn->prepare('DELETE FROM exam_venue WHERE venue_id =:id');
	$delete_stmt->bindParam(':id',$id);
	$delete_stmt->execute();
	header("Location:read_exam_venue.php");
}
?>

<?php
// Query to fetch data from exam_venue table
$venueQuery = "SELECT * FROM exam_venue";
$venueStmt = $conn->prepare($venueQuery);
$venueStmt->execute();
?>

<head>
    <script>
        function updateDay() {
            var examDate = new Date(document.getElementById("exam_date").value);
            var days = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var day = days[examDate.getDay()];
            document.getElementById("exam_day").value = day;
        }

        function populateFields(select) {
            var selectedSubjectName = select.value;
            var groupInput = document.getElementById("selected_groups");
            var lectNameInput = document.getElementById("lect_name");

            var subjectData = <?php echo json_encode($subjects); ?>;
            var subjectInfo = subjectData[selectedSubjectName];

            if (subjectInfo) {
                var groups = subjectInfo.groups;
                var lectName = subjectInfo.lect_name;

                groupInput.innerHTML = '';
                for (var i = 0; i < groups.length; i++) {
                    var option = document.createElement("option");
                    option.text = groups[i];
                    option.value = groups[i];
                    groupInput.add(option);
                }

                lectNameInput.value = lectName;
            } else {
                // Handle the case where the selected subject name is not found
                groupInput.innerHTML = '';
                lectNameInput.value = '';
                alert("Selected subject_name not found in the database.");
            }
        }
    </script>
</head>

<div class="container-fluid">
    <div class="row">  
    <?php include 'schooladmin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">EXAM VENUE [ READ ONLY ]</h1>
                            <h3><a href="create_exam_venue.php" style="text-decoration:none;"><span class="fas fa-plus"></span>&nbsp; New Exam</a></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Venue Name</th>
                                            <th style="text-align: center;">Venue Capacity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($row = $venueStmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['venue_name']; ?></td>
                                            <td><?php echo $row['venue_capacity']; ?></td>
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
