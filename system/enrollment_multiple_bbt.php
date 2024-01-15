<?php
require_once 'dbcon.php';

if (isset($_POST['submit'])) {
    $student_codes = explode(',', $_POST['student_codes']);
    $subjects = $_POST['subjects'];
    $group = $_POST['group'];
    $lecturers = $_POST['lecturers'];

    try {
        foreach ($student_codes as $student_code) {
            // Check if the student exists
            $checkStudentQuery = "SELECT COUNT(*) FROM students WHERE student_code = :student_code and student_school='BBIT'";
            $stmt = $conn->prepare($checkStudentQuery);
            $stmt->bindParam(':student_code', $student_code);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                // Inside the foreach loop (subjects loop)
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
                    $stmt->bindParam(':status', $status); // Bind the status value here
                    $stmt->execute();
                }
                echo "Enrollments added successfully for student code: $student_code<br>";
            } else {
                echo "Student with the provided code '$student_code' does not exist.<br>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Form</title>
</head>
<body>
    <form action="" method="post">
        <label for="student_codes">Enter Student Codes (comma-separated):</label><br>
        <input type="text" name="student_codes" id="student_codes"><br><br>

        <label>Select Subjects:</label><br>
        <?php
        try {
            $sql = "SELECT subject_code, subject_name FROM subjects_bbt";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<input type="checkbox" name="subjects[]" value="' . $row['subject_code'] . '">' . $row['subject_name'] . '<br>';
                echo 'Select Lecturer for ' . $row['subject_name'] . ': ';
                echo '<select name="lecturers[' . $row['subject_code'] . ']">';

                $lecturerQuery = "SELECT lecturer_name FROM lecturers where lecturer_school= 'BBIT'";
                $lecturerStmt = $conn->prepare($lecturerQuery);
                $lecturerStmt->execute();

                while ($lecturerRow = $lecturerStmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $lecturerRow['lecturer_name'] . '">' . $lecturerRow['lecturer_name'] . '</option>';
                }

                echo '</select><br>';

                // Add a status dropdown for each subject
                echo 'Select Status for ' . $row['subject_name'] . ': ';
                echo '<select name="status[' . $row['subject_code'] . ']">';
                echo '<option value="Normal">Normal</option>';
                echo '<option value="Special">Special</option>';
                echo '</select><br>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

        <br><br>
        <label for="group">Select Group:</label><br>
        <select name="group" id="group">
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
        <br><br>

        <input type="submit" name="submit" value="Enroll">
    </form>
</body>
</html>
