<?php
include 'dbcon.php';

if(isset($_POST['id'], $_POST['student_code'], $_POST['exam_day'], $_POST['exam_date'], $_POST['exam_time'])) {
    $id = $_POST['id'];
    $student_code = $_POST['student_code'];
    $exam_day = $_POST['exam_day'];
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];

    $update_stmt = $conn->prepare('UPDATE exams_collision SET student_code = :student_code, exam_day = :exam_day, exam_date = :exam_date, exam_time = :exam_time WHERE id = :id');
    $update_stmt->bindParam(':id', $id);
    $update_stmt->bindParam(':student_code', $student_code);
    $update_stmt->bindParam(':exam_day', $exam_day);
    $update_stmt->bindParam(':exam_date', $exam_date);
    $update_stmt->bindParam(':exam_time', $exam_time);

    if ($update_stmt->execute()) {
        // Redirect or display success message
        header("Location: success.php");
        exit();
    } else {
        // Handle update failure
        echo "Update failed.";
    }
} else {
    // Handle missing form data
    echo "Form data missing.";
}
?>
