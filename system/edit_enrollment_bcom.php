<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

if(isset($_GET['update_id'])){
    $id = $_GET['update_id']; // get update_id and store in $id variable

    $select_stmt = $conn->prepare('SELECT * FROM enrollments_bcom WHERE enrol_id =:id'); // sql select query
    $select_stmt->bindParam(':id', $id);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['update'])){
    $student_code = $_POST['student_code'];
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $group_name = $_POST['group_name'];
    $lect_name = $_POST['lect_name'];
    $enrol_status = $_POST['enrol_status'];

    if(empty($student_code) || empty($subject_code) || empty($subject_name) || empty($group_name) || empty($lect_name) || empty($enrol_status)){
        $errorMsg = "Please fill all the fields.";
    } else {
        try {
            $update_stmt = $conn->prepare('UPDATE enrollments_bcom SET student_code=:student_code, subject_code=:subject_code, subject_name=:subject_name, group_name=:group_name, lect_name=:lect_name, enrol_status=:enrol_status WHERE enrol_id=:id');
            $update_stmt->bindParam(':student_code', $student_code);
            $update_stmt->bindParam(':subject_code', $subject_code);
            $update_stmt->bindParam(':subject_name', $subject_name);
            $update_stmt->bindParam(':group_name', $group_name);
            $update_stmt->bindParam(':lect_name', $lect_name);
            $update_stmt->bindParam(':enrol_status', $enrol_status);
            $update_stmt->bindParam(':id', $id);

            if($update_stmt->execute()){
                $updateMsg = "Record updated successfully.";
                header("refresh:2;read_bcom_1_1.php"); // redirect to read_bcom_1_1.php after 2 seconds
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
    <?php include "bcom_facadmin_sidebar.php";?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">
                <div>
                    <div class="col-lg-6" style="margin-left:30%; margin-top:5%; background-color: rgba(0,0,15,.2); padding:3%; border-radius:5%;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="text-align: center;">Edit Enrollment</h1>
                            </div>
                            <div class="panel-body">
                                <?php
                                if(isset($errorMsg)){
                                ?>
                                    <div class="alert alert-danger">
                                        <strong>Error!</strong> <?php echo $errorMsg; ?>
                                    </div>
                                <?php
                                }

                                if(isset($updateMsg)){
                                ?>
                                    <div class="alert alert-success">
                                        <strong>Success!</strong> <?php echo $updateMsg; ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="student_code">Student Code:</label>
                                        <input type="text" class="form-control" name="student_code" value="<?php echo $row['student_code']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject_code">Subject Code:</label>
                                        <input type="text" class="form-control" name="subject_code" value="<?php echo $row['subject_code']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject_name">Subject Name:</label>
                                        <input type="text" class="form-control" name="subject_name" value="<?php echo $row['subject_name']; ?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="group_name">Group Name:</label>
                                        <input type="text" class="form-control" name="group_name" value="<?php echo $row['group_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lect_name">Lecturer Name:</label>
                                        <input type="text" class="form-control" name="lect_name" value="<?php echo $row['lect_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="enrol_status">Enrollment Status:</label>
                                        <input type="text" class="form-control" name="enrol_status" value="<?php echo $row['enrol_status']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                                        <a class="btn btn-danger fas fa-multiply" href="read_bcom_1_1.php"></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require 'footer.php' ?>
</div>
