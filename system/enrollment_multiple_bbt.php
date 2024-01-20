<?php 
    require_once 'dbcon.php';
    include 'header.php';
    include 'js_datatable.php';

    // Initialize variables for success and error messages
    $successMessage = '';
    $errorMessage = '';

    // Handle form submission
    if (isset($_POST['submit'])) {
        try {
            // Get form data
            $student_codes = explode(',', $_POST['student_codes']);
            $subjects = $_POST['subjects'];
            $group = $_POST['group'];
            $lecturers = $_POST['lecturers'];

            foreach ($student_codes as $student_code) {
                // Check if the student exists
                $checkStudentQuery = "SELECT COUNT(*) FROM students WHERE student_code = :student_code AND student_school = 'BBIT'";
                $stmt = $conn->prepare($checkStudentQuery);
                $stmt->bindParam(':student_code', $student_code);
                $stmt->execute();

                if ($stmt->fetchColumn() > 0) {
                    foreach ($subjects as $subject) {
                        // Get the subject name based on the subject code
                        $subjectNameQuery = "SELECT subject_name FROM subjects_bbt WHERE subject_code = :subject_code";
                        $stmt = $conn->prepare($subjectNameQuery);
                        $stmt->bindParam(':subject_code', $subject);
                        $stmt->execute();
                        $subject_name = $stmt->fetchColumn();

                        // Get the selected lecturer for the subject
                        $lecturer = isset($lecturers[$subject]) ? $lecturers[$subject] : null;

                        // Get the selected status for the subject
                        $status = isset($_POST['status'][$subject]) ? $_POST['status'][$subject] : 'Normal';

                        // Insert enrollment record with the selected status
                        $sql = "INSERT INTO enrollments_bbt (student_code, subject_code, subject_name, group_name, lect_name, enrol_status) VALUES (:student_code, :subject_code, :subject_name, :group_name, :lect_name, :status)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':student_code', $student_code);
                        $stmt->bindParam(':subject_code', $subject);
                        $stmt->bindParam(':subject_name', $subject_name);
                        $stmt->bindParam(':group_name', $group);
                        $stmt->bindParam(':lect_name', $lecturer);
                        $stmt->bindParam(':status', $status);
                        $stmt->execute();
                    }
                    $successMessage .= "Enrollments with provided code '$student_code'has been added successfully<br>";
                } else {
                    $errorMessage .= "Student with the provided code '$student_code' does not exist.<br>";
                }
            }
        } catch (PDOException $e) {
            $errorMessage .= "Error: " . $e->getMessage();
        }
    }
?>

<body class="container-fluid">
    <div class="row">
        <?php include "sidebar.php";?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">    
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">SUBJECTS ENROLLMENTS BBIT</h1>
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
                                    <label for="student_codes">Enter Student Codes (comma-separated):</label>
                                    <input type="text" class="form-control" name="student_codes" id="student_codes">
                                </div>
                                <div class="form-group">
                                    <label>Select Subjects:</label>
                                    <div class="row">
                                        <?php
                                        try {
                                            $sql = "SELECT subject_code, subject_name FROM subjects_bbt";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();

                                            $subjectCounter = 0;

                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                if ($subjectCounter % 14 == 0) {
                                                    // Start a new row after every 14 subjects (2 columns with 7 subjects each)
                                                    echo '<div class="row">';
                                                }

                                                echo '<div class="col-md-6" style="background-color: ' . ($subjectCounter % 2 == 0 ? '#f9f9f9' : '#e5e5e5') . ';">';
                                                echo '<div class="form-check">';
                                                echo '<input type="checkbox" class="form-check-input" name="subjects[]" value="' . $row['subject_code'] . '">';
                                                echo '<label class="form-check-label">' . $row['subject_name'] . '</label>';
                                                echo '</div>';

                                                echo '<div class="form-group">';
                                                echo 'Select Lecturer: ';
                                                echo '<select class="form-control" name="lecturers[' . $row['subject_code'] . ']">';

                                                $lecturerQuery = "SELECT lecturer_name FROM lecturers where lecturer_school= 'BBIT'";
                                                $lecturerStmt = $conn->prepare($lecturerQuery);
                                                $lecturerStmt->execute();

                                                while ($lecturerRow = $lecturerStmt->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="' . $lecturerRow['lecturer_name'] . '">' . $lecturerRow['lecturer_name'] . '</option>';
                                                }

                                                echo '</select></div>';

                                                // Add a status dropdown for each subject
                                                echo '<div class="form-group">';
                                                echo 'Select Status: ';
                                                echo '<select class="form-control" name="status[' . $row['subject_code'] . ']">';
                                                echo '<option value="Normal">Normal</option>';
                                                echo '<option value="Special">Special</option>';
                                                echo '</select></div>';

                                                echo '</div>'; // Closing col-md-6

                                                $subjectCounter++;

                                                if ($subjectCounter % 14 == 0) {
                                                    // Close the row after every 14 subjects
                                                    echo '</div>';
                                                }
                                            }

                                            // Close the row if the last block is not complete
                                            if ($subjectCounter % 14 !== 0) {
                                                echo '</div>';
                                            }
                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                        ?>
                                        <div class="form-group">
                                        <label for="group">Select Group:</label><br>
                                        <select class="form-control" name="group" id="group">
                                            <?php
                                            try {
                                                $sql = "SELECT group_name FROM group_bbt";
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
                                </div>
                                 <button type="submit" class="btn btn-primary" name="submit">Enroll</button>
                                 <a class="btn btn-danger fas fa-multiply" href="enrollment_multiple_bbt.php"></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require 'footer.php' ?>
</body>
</html>