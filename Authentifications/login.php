<?php
include 'config.php';

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
   <!-- Your existing head content here -->

   <style>
      /* Add any additional styling you need */
      section {
         margin-top: 7%;
      }

      .card {
         width: 25rem;
         background-color: rgba(15, 15, 50, .2);
      }

      .card-img-top {
         margin-left: 28%;
         width: 50%;
         border-radius: 25%;
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
               <img src="image/login.jpeg" class="card-img-top" alt="login image">
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
                  <input type="submit" class="btn btn-primary" value="Login now" name="submit">
                  <a href="#" style="text-decoration: none;">Forgot password?</a>
               </div>
            </div>
         </form>
      </center>
   </section>
</body>
</html>
