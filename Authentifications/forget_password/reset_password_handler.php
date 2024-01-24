<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<style>
    .container{
        margin-top:10%;
        margin-left:30%;
        background-color: rgba(0,85,255); 
        color: white;
        width:35%; 
        padding:5%;
        border-radius:5%;
    }
</style>
<?php
require('../../system/dbcon.php');

// Function to validate the password based on the provided policy
function validatePassword($password) {
    // Password policy: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/";
    return preg_match($pattern, $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $newPassword = $_POST['new_password'];

    // Check if the reset_code is present in the form
    if (isset($_POST['reset_code'])) {
        $resetCode = htmlspecialchars($_POST['reset_code']);

        // Retrieve the user ID based on the reset code
        $stmt = $conn->prepare("SELECT student_id FROM password_resets WHERE reset_code = :code");
        $stmt->bindParam(':code', $resetCode);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $userId = $row['student_id'];

            // Validate the new password
            if (validatePassword($newPassword)) {
                // Update the password in the students table
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE students SET student_password = :password WHERE student_id = :id");
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':id', $userId);

                // Check if the update was successful
                if ($updateStmt->execute()) {
                    // After updating the password, you may want to delete the reset code entry
                    $deleteStmt = $conn->prepare("DELETE FROM password_resets WHERE reset_code = :code");
                    $deleteStmt->bindParam(':code', $resetCode);

                    // Check if the delete was successful
                    if ($deleteStmt->execute()) {
                        echo '<div class="container">
                            <h2>Password updated successfully</h2>
                            <a href="../../authentifications/login.php" class="btn btn-primary mt-3">You can now log in with your new password.</a>
                        </div>';
                    } else {
                        echo '<div class="container">
                            <h2>Error deleting the reset code</h2>
                            <a href="support.php" class="btn btn-primary mt-3">Please contact the support</a>
                        </div>';
                    }
                } else {
                    echo '<div class="container">
                            <h2>Error updating the password.</h2>
                            <a href="reset_password.php" class="btn btn-primary mt-3">Please try again</a>
                        </div>';
                }
            } else {
                echo '<div class="container">
                <h2>Invalid password.</h2>
                 <a href="reset_password.php" class="btn btn-primary mt-3">Please follow the password policy.</a>
                </div>';
            }
        } else {
            echo '<div class="container">
                <h2>Invalid reset code.</h2>
                 <a href="reset_request_handler.php" class="btn btn-primary mt-3">Please try again</a>
                </div>';
        }
    } else {
        echo '<div class="container">
                <h2>Invalid reset code.</h2>
                 <a href="reset_request_handler.php" class="btn btn-primary mt-3">Please try again</a>
                </div>';
        
    }
}
?>
</div>
</body>
</html>