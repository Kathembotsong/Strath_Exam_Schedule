<?php
session_start();
include '../system/dbcon.php';

// Database connection
try {
     if (isset($_POST["login"])) {
        if (empty($_POST["user_code"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';
        } else {
            $user_code = $_POST["user_code"];
            $password = $_POST["password"];

            // Fetch user data by user_code
            $query = "SELECT * FROM users WHERE user_code = :user_code";
            $statement = $conn->prepare($query);
            $statement->execute(['user_code' => $user_code]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user["password"])) {
                    $_SESSION["user_code"] = $user_code;
                    $_SESSION["role"] = $user["role"];
                    // Redirect based on role
                    switch ($user["role"]) {
                        case "schoolAdmin":
                            header("Location: ../system/schooladmin_dashboard.php");
                            exit();
                        case "facAdmin":
                            header("Location: ../system/facultyadmin_dashboard.php");
                            exit();
                        case "student":
                            header("Location: ../system/student_dashboard.php");
                            exit();
                        case "lecturer":
                            header("Location: ../system/lecturer_dashboard.php");
                            exit();
                        default:
                            header("Location: login.php");
                            exit();
                    }
                } else {
                    $message = '<label>The code or password is incorrect</label>';
                }
            } else {
                $message = '<label>The code or password is incorrect</label>';
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
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
         background:yellow;
         width:70%;
         margin:3%;
      }
   </style>
</head>
<body>
   <section>
      <center>
        <form method="post" enctype="multipart/form-data">
            <div class="card">
               <img src="image/login.jpeg" class="card-img-top" alt="login image" >
               <div class="card-body">
               <p class="message"><?php if (isset($message)) { echo '<label>' . $message . '</label>'; } ?></p>
                  <div class="mb-3">
                     <input type="text" class="form-control" required placeholder="user_code" name="user_code">
                  </div>
                  <div class="mb-3">
                     <input type="password" class="form-control" required placeholder="password" name="password">
                  </div>
                  <div class="mb-3">
                     <input type="submit" class="btn btn-primary" value="Login" name="login">
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



