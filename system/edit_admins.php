<?php
include 'header.php';
include 'dbcon.php';
include 'js_datatable.php';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

  
   // Retrieve the admin information for the given update_id
   $select_stmt = $conn->prepare('SELECT * FROM admins WHERE admin_id = :id');
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

                // Update the admin details in the database
            $update_stmt_admin = $conn->prepare('UPDATE admins SET admin_name = :admin_name, admin_email = :admin_email, admin_phone = :admin_phone, admin_school = :admin_school, admin_password = :admin_password WHERE admin_id = :id');
            $update_stmt_admin->bindParam(':admin_name', $updated_name);
            $update_stmt_admin->bindParam(':admin_email', $updated_email);
            $update_stmt_admin->bindParam(':admin_phone', $updated_phone);
            $update_stmt_admin->bindParam(':admin_school', $updated_school);
            $update_stmt_admin->bindParam(':admin_password', $hashedPassword); // Fix variable name here
            $update_stmt_admin->bindParam(':id', $update_id);
            $update_stmt_admin->execute();
                
                // Commit the transaction
                $conn->commit();

                // Redirect after successful update
                header('Location: read_admins.php'); 
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
                                <label for="updated_name" class="form-label">Admin Name:</label>
                                <input type="text" name="updated_name" class="form-control" value="<?php echo $row['admin_name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_email" class="form-label">Admin Email:</label>
                                <input type="email" name="updated_email" class="form-control" value="<?php echo $row['admin_email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_phone" class="form-label">Admin Phone:</label>
                                <input type="text" name="updated_phone" class="form-control" value="<?php echo $row['admin_phone']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_school" class="form-label">Admin School:</label>
                                <input type="text" name="updated_school" class="form-control" value="<?php echo $row['admin_school']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="updated_password" class="form-label">Admin Password:</label>
                                <input type="password" name="updated_password" class="form-control" required> <!-- Change input type to password -->
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="read_admins.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
