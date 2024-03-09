<?php
include 'dbcon.php';
include 'header.php';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Retrieve the student information for the given update_id
    $select_stmt = $conn->prepare('SELECT * FROM subjects_bcom WHERE subject_code = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the form is submitted for updating
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form data
        $updated_code = htmlspecialchars($_POST['updated_code']);
        $updated_name = htmlspecialchars($_POST['updated_name']);
        // Update the student details in the database
        $update_stmt = $conn->prepare('UPDATE subjects_bcom SET subject_code = :subject_code, subject_name = :subject_name WHERE subject_code = :id');
        $update_stmt->bindParam(':subject_code', $updated_code);
        $update_stmt->bindParam(':subject_name', $updated_name);
        $update_stmt->bindParam(':id', $update_id);

        if ($update_stmt->execute()) {
            header('Location: read_subjects_bcom.php'); // Redirect after successful update
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating student details. Please try again.</div>';
        }
    }
}

include 'js_datatable.php';
?>

<!-- Display the form for updating student details -->
<div class="container-fluid">
    <div class="row">
    <?php include "bcom_facadmin_sidebar.php";?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container mt-5" style="margin-left:35%;">
                <div class="col-lg-4" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">UPDATE SUBJECTS</h1>
                        </div>
                        <div class="panel-body">
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="updated_code" class="form-label">Unit Code:</label>
                                    <input type="text" name="updated_code" class="form-control" value="<?php echo $row['subject_code']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updated_name" class="form-label">Unit Name:</label>
                                    <input type="text" name="updated_name" class="form-control" value="<?php echo $row['subject_name']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="read_subjects_bcom.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
