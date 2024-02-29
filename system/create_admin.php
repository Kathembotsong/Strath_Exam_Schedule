<?php
include 'dbcon.php';
include 'header.php';
include 'js_datatable.php';

function showMessage($message, $type) {
    echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
            ' . $message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// Function to hash the password using PHP's password_hash function
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to register user and return success or failure message
function registerUser($code, $name, $email, $phone, $school, $password, $admin_role) {
    global $conn;

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Hash the password
        $hashedPassword = hashPassword($password);

        // Insert data into the admins table
        $stmtAdmins = $conn->prepare("INSERT INTO admins (admin_code, admin_name, admin_email, admin_phone, admin_school, admin_password, admin_role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmtAdmins->bindParam(1, $code);
        $stmtAdmins->bindParam(2, $name);
        $stmtAdmins->bindParam(3, $email);
        $stmtAdmins->bindParam(4, $phone);
        $stmtAdmins->bindParam(5, $school);
        $stmtAdmins->bindParam(6, $hashedPassword);
        $stmtAdmins->bindParam(7, $admin_role);
        $stmtAdmins->execute();

        // Commit the transaction
        $conn->commit();

        return array('success' => true, 'message' => "Registration successful!");

    } catch (PDOException $e) {
        // Rollback the transaction on error
        $conn->rollBack();

        // Check if the error is related to a unique constraint violation
        if ($e->getCode() == '23000') {
            return array('success' => false, 'message' => "A user with the same code or email already exists.");
        } else {
            return array('success' => false, 'message' => "An error occurred while processing your request. Please try again later.");
        }
    }
}
?>

<!-- HTML form -->
<div class="container-fluid">
    <div class="row">
        <?php include 'schooladmin_sidebar.php'; ?>
        <!-- main page -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: rgba(0,0,255,.2);">
        
        <style>
            body {
                background-color: #f8f9fa;
            }
            h2 {
                color: #007bff;
            }
            .container {
                width: 40%;
                margin-left: 20%;
                text-align: center;
            }
            .card {
                background-color: #ffffff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }
        </style>
        
        <div class="container mt-5">
            <h2 class="mb-4">Create Administrator</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col">
                    <p class="message">
                       <?php 
                         // Check if the form is submitted
                          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                              $code = $_POST['admin_code'];
                              $name = $_POST['admin_name'];
                              $email = $_POST['admin_email'];
                              $phone = $_POST['admin_phone'];
                              $school = $_POST['admin_school'];
                              $password = $_POST['admin_password'];
                              $admin_role = $_POST['admin_role'];

                            // Call the registerUser function to insert data into the database
                             $result = registerUser($code, $name, $email, $phone, $school, $password, $admin_role);

                            // Display success or failure message
                            if ($result['success']) {
                            showMessage("Registration successful!", 'success');
                             } else {
                                    showMessage($result['message'], 'danger');
                            }
                        } ?></p>
                        <div class="card p-3">
                            <h3 class="card-title text-center mb-4">Administrator</h3>                            
                            <label for="admin_code" class="form-label">Admin Code:</label>
                            <input type="text" name="admin_code" class="form-control" required><br>

                            <label for="admin_name" class="form-label">Admin Name:</label>
                            <input type="text" name="admin_name" class="form-control" required><br>

                            <label for="admin_email" class="form-label">Admin Email:</label>
                            <input type="email" name="admin_email" class="form-control" required><br>

                            <label for="admin_phone" class="form-label">Admin Phone:</label>
                            <input type="text" name="admin_phone" class="form-control" required><br>

                            <label for="admin_school" class="form-label">Admin School:</label>
                            <input type="text" name="admin_school" class="form-control" required><br>

                            <label for="admin_password" class="form-label">Admin Password:</label>
                            <input type="password" name="admin_password" class="form-control" required><br>

                            <label for="admin_role" class="form-label">Role:</label>
                            <select class="form-control" name="admin_role" id="admin_role">
                                <option value="facAdmin">Faculty Admin</option>
                                <option value="schoolAdmin">School Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary mt-3" value="Register">
            </form>
        </div>
        </main>            
    </div>
</div>
</body>
<?php require 'footer.php' ?>
