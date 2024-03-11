<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Retrieve the student information for the given update_id
    $select_stmt = $conn->prepare('SELECT * FROM exam_venue WHERE venue_id = :id');
    $select_stmt->bindParam(':id', $update_id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the form is submitted for updating
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate form data
        $updated_venue_name = htmlspecialchars($_POST['updated_venue_name']);
        $updated_venue_capacity = htmlspecialchars($_POST['updated_venue_capacity']);
        // Update the student details in the database
        $update_stmt = $conn->prepare('UPDATE exam_venue SET venue_name = :venue_name, venue_capacity = :venue_capacity WHERE venue_id = :id');
        $update_stmt->bindParam(':venue_name', $updated_venue_name);
        $update_stmt->bindParam(':venue_capacity', $updated_venue_capacity);
        $update_stmt->bindParam(':id', $update_id);

        if ($update_stmt->execute()) {
            header('Location: read_exam_venue.php'); // Redirect after successful update
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating exam venue details. Please try again.</div>';
        }
    }
}
?>

<!-- Display the form for updating student details -->
<div class="container-fluid">
    <div class="row">
        <?php include "exam_officer_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left:35%; width:35%">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">UPDATE EXAM VENUE</h1>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <div class="mb-3">
                                    <label for="updated_venue_name" class="form-label">Venue Name:</label>
                                    <input type="text" name="updated_venue_name" class="form-control" value="<?php echo $row['venue_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updated_venue_capacity" class="form-label">Venue Capacity:</label>
                                    <input type="text" name="updated_venue_capacity" class="form-control" value="<?php echo $row['venue_capacity']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="read_exam_venue.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
