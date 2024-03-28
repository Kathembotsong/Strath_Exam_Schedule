<?php 
	include 'dbcon.php'; 
	include 'header.php';     
	include 'js_datatable.php';
?>

<?php
// Initialize variables for success and error messages
$successMessage = '';
$errorMessage = '';

if (isset($_POST['submit'])) {
	$student_code = $_POST['student_code'];
	$subjects = $_POST['subjects'];
	$group = $_POST['group'];
	$lecturers = $_POST['lecturers'];

	try {
		// Check if the student exists
		$checkStudentQuery = "SELECT COUNT(*) FROM students WHERE student_code = :student_code and student_school='BCOM'";
		$stmt = $conn->prepare($checkStudentQuery);
		$stmt->bindParam(':student_code', $student_code);
		$stmt->execute();

		if ($stmt->fetchColumn() > 0) {
			// Inside the foreach loop (subjects loop)
			foreach ($subjects as $subject) {
				// Get the subject name based on the subject code
				$subjectNameQuery = "SELECT subject_name FROM subjects_bcom WHERE subject_code = :subject_code";
				$stmt = $conn->prepare($subjectNameQuery);
				$stmt->bindParam(':subject_code', $subject);
				$stmt->execute();
				$subject_name = $stmt->fetchColumn();

				// Get the selected lecturer for the subject
				$lecturer = isset($lecturers[$subject]) ? $lecturers[$subject] : null;

				// Get the selected status for the subject
				$status = isset($_POST['status'][$subject]) ? $_POST['status'][$subject] : 'Normal';

				// Insert enrollment record with the selected status
				$sql = "INSERT INTO enrollments_bcom (student_code, subject_code, subject_name, group_name, lect_name, enrol_status) VALUES (:student_code, :subject_code, :subject_name, :group_name, :lect_name, :status)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':student_code', $student_code);
				$stmt->bindParam(':subject_code', $subject);
				$stmt->bindParam(':subject_name', $subject_name);
				$stmt->bindParam(':group_name', $group);
				$stmt->bindParam(':lect_name', $lecturer);
				$stmt->bindParam(':status', $status);
				$stmt->execute();
			}
			$successMessage = "Enrollments added successfully for student code: $student_code";
		} else {
			$errorMessage = "Student with the provided code '$student_code' does not exist.";
		}
	} catch (PDOException $e) {
		$errorMessage = "Error: " . $e->getMessage();
	}
}
?>

<body>
	<div class="container-fluid">
		<div class="row">
		<?php include "bcom_facadmin_sidebar.php";?>
			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<div class="wrapper">    
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h1 style="text-align: center;">UNITS ENROLLMENTS BCOM</h1>
							</div>
							<div class="panel-body">
								<!-- Display success and error messages within the form -->
								<?php
								if ($successMessage !== '') {
									echo '<div class="alert alert-success">' . $successMessage . '</div>';
								}
								if ($errorMessage !== '') {
									echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
								}
								?>
								<form action="" method="post">
									<div class="form-group">
										<label for="student_code">Enter Student Code:</label><br>
										<input type="text" class="form-control" name="student_code" id="student_code">
									</div>

									<div class="form-group">
										<label>Select Subjects:</label><br>
										<div class="row">
											<?php
											try {
												$sql = "SELECT subject_code, subject_name FROM subjects_bcom";
												$stmt = $conn->prepare($sql);
												$stmt->execute();

												$subjectCounter = 0;

												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													if ($subjectCounter % 14 == 0) {
														// Start a new row after every 14 subjects (2 columns with 7 subjects each)
														echo '<div class="col-md-6"><div class="row">';
													}

													echo '<div class="col-md-6" style="background-color: ' . ($subjectCounter % 2 == 0 ? '#f9f9f9' : '#e5e5e5') . ';">';
													echo '<input type="checkbox" name="subjects[]" value="' . $row['subject_code'] . '">' . $row['subject_name'] . '<br>';
													echo 'Select Lecturer: ';
													echo '<select class="form-control" name="lecturers[' . $row['subject_code'] . ']">';

													$lecturerQuery = "SELECT lecturer_name FROM lecturers where lecturer_school= 'BCOM'";
													$lecturerStmt = $conn->prepare($lecturerQuery);
													$lecturerStmt->execute();

													while ($lecturerRow = $lecturerStmt->fetch(PDO::FETCH_ASSOC)) {
														echo '<option value="' . $lecturerRow['lecturer_name'] . '">' . $lecturerRow['lecturer_name'] . '</option>';
													}

													echo '</select><br>';
													
													// Add a status dropdown for each subject
													echo 'Select Status: ';
													echo '<select class="form-control" name="status[' . $row['subject_code'] . ']">';
													echo '<option value="Normal">Normal</option>';
													echo '<option value="Special">Special</option>';
													echo '</select><br>';

													echo '</div>'; // Closing col-md-6

													$subjectCounter++;

													if ($subjectCounter % 14 == 0) {
														// Close the row after every 14 subjects
														echo '</div></div>';
													}
												}

												// Close the row if the last block is not complete
												if ($subjectCounter % 14 !== 0) {
													echo '</div></div>';
												}
											} catch (PDOException $e) {
												echo "Error: " . $e->getMessage();
											}
											?>
										</div>
									</div>

									<div class="form-group">
										<label for="group">Select Group:</label><br>
										<select class="form-control" name="group" id="group">
											<?php
											try {
												$sql = "SELECT group_name FROM group_bcom";
												$stmt = $conn->prepare($sql);
												$stmt->execute();

												while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
													echo '<option value="' . $row['group_name'] . '">' . $row['group_name'] . '</option>';
												}
											} catch (PDOException $e) {
												echo "Error: " . $e->getMessage();
											}
											?>
										</select>
									</div>

									<input type="submit" name="submit" value="Enroll" class="btn btn-primary">
								</form>
							</div>
						</div>
					</div>
				</div>
			</main>
			<?php require 'footer.php' ?>
		</div>
	</div>
</body>
</html>
