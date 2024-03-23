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

            // Validate password
            if (!validatePassword($updated_password)) {
                $message = 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.';
            } else {
                //hashing password function
                $hashedPassword = password_hash($updated_password, PASSWORD_DEFAULT);

                // Update the student details in the students table
                $update_stmt_students = $conn->prepare('UPDATE students SET student_name = :student_name, student_email = :email, student_phone = :phone, student_school = :school, student_password = :student_password WHERE student_id = :id');
                $update_stmt_students->bindParam(':student_name', $updated_name);
                $update_stmt_students->bindParam(':email', $updated_email);
                $update_stmt_students->bindParam(':phone', $updated_phone);
                $update_stmt_students->bindParam(':school', $updated_school);
                $update_stmt_students->bindParam(':student_password', $hashedPassword);
                $update_stmt_students->bindParam(':id', $update_id);
                $update_stmt_students->execute();
                
                // Commit the transaction
                $conn->commit();

                // Redirect after successful update
                header('Location: read_tourism_students.php'); 
                exit();
            }
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            $message = 'Error updating admin details: ' . $e->getMessage();
        }
    }
}

// Function to validate the password based on the provided policy
function validatePassword($password) {
    // Password policy: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/";
    return preg_match($pattern, $password);
}
?>

<!-- Display the form for updates -->
<div class="container-fluid">
    <div class="row">
        <?php include "bbit_facadmin_sidebar.php"; ?>
        <main class="col-md-5">
            <div class="container" style="margin-left:35%; background-color:rgba(255,105,20,.2); padding:5px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 style="text-align: center;">UPDATE BBIT STUDENTS</h1>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <?php if(isset($message)) echo '<div class="alert alert-danger" role="alert">' . $message . '</div>'; ?>
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
                            <a href="read_tourism_students.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
