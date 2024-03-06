<?php
include 'header.php';
include 'dbcon.php';
include 'js_datatable.php';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Retrieve the student information for the given update_id
    $select_stmt = $conn->prepare('SELECT * FROM students WHERE student_id = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the form is submitted for updating
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $conn->beginTransaction();
            // Retrieve form data
            $updated_name = $_POST['updated_name'];
            $updated_email = $_POST['updated_email'];
            $updated_phone = $_POST['updated_phone'];
            $updated_school = $_POST['updated_school'];
            $updated_password = $_POST['updated_password'];

            //hashing password function
            $hashedPassword = password_hash($updated_password, PASSWORD_DEFAULT);

            // Update the student details in the students table
            $update_stmt_students = $conn->prepare('UPDATE students SET student_name = :student_name, student_email = :email, student_phone = :phone, student_school = :school, student_password = :student_password WHERE student_id = :id');
            $update_stmt_students->bindParam(':student_name', $updated_name);
            $update_stmt_students->bindParam(':email', $updated_email);
            $update_stmt_students->bindParam(':phone', $updated_phone);
            $update_stmt_students->bindParam(':school', $updated_school);
            $update_stmt_students->bindParam(':student_password', $hashedPassword); // Use hashed password
            $update_stmt_students->bindParam(':id', $update_id);
            $update_stmt_students->execute();
            
            // Commit the transaction
            $conn->commit();

            // Redirect after successful update
            header('Location: read_scs_students.php'); 
            exit();
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            echo '<div class="alert alert-danger" role="alert">Error updating admin details: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<!-- Display the form for updats -->
<div class="container-fluid">
    <div class="row">
        <?php include "scs_facadmin_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left:35%; width:35%">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 style="text-align: center;">UPDATE ADMINISTRATORS</h1>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="mb-3">
                                <label for="updated_name" class="form-label">Student Name:</label>
                                <input type="text" name="updated_name" class="form-control" value="<?php echo $row['student_name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_email" class="form-label">Student Email:</label>
                                <input type="email" name="updated_email" class="form-control" value="<?php echo $row['student_email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_phone" class="form-label">Student Phone:</label>
                                <input type="text" name="updated_phone" class="form-control" value="<?php echo $row['student_phone']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_school" class="form-label">Student School:</label>
                                <input type="text" name="updated_school" class="form-control" value="<?php echo $row['student_school']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_password" class="form-label">Student Password:</label>
                                <input type="password" name="updated_password" class="form-control" required> 
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="read_scs_students.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
