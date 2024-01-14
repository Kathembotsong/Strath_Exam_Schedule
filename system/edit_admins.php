<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Retrieve the student information for the given update_id
    $select_stmt = $conn->prepare('SELECT * FROM admins WHERE admin_id = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the form is submitted for updating
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form data
        $updated_name = htmlspecialchars($_POST['updated_name']);
        $updated_email = htmlspecialchars($_POST['updated_email']);
        $updated_phone = htmlspecialchars($_POST['updated_phone']);
        $updated_school = htmlspecialchars($_POST['updated_school']);
        $updated_password = htmlspecialchars($_POST['updated_password']);

        // Update the student details in the database
        $update_stmt = $conn->prepare('UPDATE admins SET admin_name = :admin_name, admin_email = :admin_email, admin_phone = :admin_phone, admin_school = :admin_school, admin_password = :admin_password WHERE admin_id = :id');
        $update_stmt->bindParam(':admin_name', $updated_name);
        $update_stmt->bindParam(':admin_email', $updated_email);
        $update_stmt->bindParam(':admin_phone', $updated_phone);
        $update_stmt->bindParam(':admin_school', $updated_school);
        $update_stmt->bindParam(':admin_password', $updated_passwrord);
        $update_stmt->bindParam(':id', $update_id);

        if ($update_stmt->execute()) {
            header('Location: read_admins.php'); // Redirect after successful update
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating lecturer details. Please try again.</div>';
        }
    }
}
?>

<!-- Display the form for updating student details -->
<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left:35%; width:35%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">UPDATE ADMINISTRATORS</h1>
                        </div>
                        <div class="panel-body">
                            <form method="post">
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
                                    <input type="text" name="updated_password" class="form-control" value="<?php echo $row['admin_password']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="read_admins.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
