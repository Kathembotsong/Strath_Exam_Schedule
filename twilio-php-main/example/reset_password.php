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
<body>
    <div class="container">
       <?php
        // Check if the reset_code is present in the URL
        if (isset($_GET['reset_code'])) {
            // Echo the reset_code as a hidden input field
            $resetCode = htmlspecialchars($_GET['reset_code']);
            echo '
            <h2>Enter your new password</h2>
              <form method="post" action="reset_password_handler.php">
                <input type="password" name="new_password" required>
                <input type="hidden" name="reset_code" value="' . $resetCode . '">
                <button type="submit">Reset Password</button>
              </form>
            ';
        } else {
            // If reset_code is not present, display an error message
            echo '<h2 class="error_message">Invalid reset code. Please try again.</h2>';
        }
        ?>       
    </div>
</body>
</html>