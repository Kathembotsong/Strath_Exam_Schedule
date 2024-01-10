<?php
include '../system/dbcon.php';

// Function to validate user login
function loginUser($code, $password) {
    global $conn;

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_code = ?");
    
    // Bind parameters
    $stmt->bindParam(1, $code);

    // Execute the statement
    $stmt->execute();

    // Fetch the user record
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check if the provided password matches the stored hashed password
        if (password_verify($password, $user['student_password'])) {
            return $user;
        }
    }

    return false;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $code = $_POST["username"];
    $password = $_POST["password"];

    // Validate user login
    $user = loginUser($code, $password);

    if ($user) {
        // Successful login, redirect to the dashboard
        header("Location: ../system/dashboard/dashboard.php");
        exit();
    } else {
        $message[] = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <style>
      
      section {
         margin-top: 7%;
      }

      .card {
         width: 25rem;
         background-color:#2A7FFF;
         border-radius: 15%;
      }
      .card-img-top {
         width: 50%;
         border-radius: 15%;
         margin-top:10%;        
         padding:3%;
      }
      .mb-3{
         padding:3%;
      }

      .message {
         margin-left: 15%;
         color: red;
      }
   </style>
</head>
<body>
   <section>
      <center>
         <form action="" method="post" enctype="multipart/form-data">
            <div class="card">
               <img src="image/login.jpeg" class="card-img-top" alt="login image" >
               <div class="card-body">
                  <?php
                     if (isset($message)) {
                        foreach ($message as $message) {
                           echo '
                              <div class="message">
                                 <span>'.$message.'</span>
                                 <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                              </div>
                           ';
                        }
                     }
                  ?>
                  <div class="mb-3">
                     <input type="text" class="form-control" required placeholder="username" name="username">
                  </div>
                  <div class="mb-3">
                     <input type="password" class="form-control" required placeholder="password" name="password">
                  </div>
                  <div class="mb-3">
                     <input type="submit" class="btn btn-primary" value="Login now" name="submit">
                  </div>
                  <div class="mb-3">
                     <a href="../twilio_php_main/example/password_reset_request.php" style="text-decoration: none; color:white;">Forgot password?</a>
                  </div>
               </div>
            </div>
         </form>
      </center>
   </section>
</body>
</html>

