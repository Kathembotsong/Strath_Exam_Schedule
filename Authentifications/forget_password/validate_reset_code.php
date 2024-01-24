<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_tb1";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

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
        background-color: red; 
        color: white;
        width:40%; 
        padding:1%;
        text-align:center;
        border-radius:5%;
    }
   </style>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = (int) htmlspecialchars($_POST['reset_code']);  // Convert entered code to integer

    // Retrieve the stored reset code and its expiration time from the database
    $stmt = $conn->prepare("SELECT reset_code, expiration_time FROM password_resets WHERE reset_code = :code");
    $stmt->bindParam(':code', $enteredCode);
    $stmt->execute();
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $storedCode = $row['reset_code'];
        $expirationTime = $row['expiration_time'];

        echo "Entered Code: $enteredCode<br>";
        echo "Stored Code: $storedCode<br>";
        echo "Expiration Time: $expirationTime<br>";

        // Check if the entered code matches the stored code
        if ($enteredCode == $storedCode) {
            // Check if the code is still valid (not expired)
            $currentDateTime = date('Y-m-d H:i:s');
            $currentTimestamp = strtotime($currentDateTime);
            $expirationTimestamp = strtotime($expirationTime);

            if ($currentTimestamp <= $expirationTimestamp) {
                // Code is valid, allow the user to reset their password
                header("Location: reset_password.php?reset_code=$enteredCode");
                exit();
            } else {
                echo '<h2 class="container">
                    "The code has expired. Please request a new one."
                  </h2>';
                
            }
        } else {
            echo '<div class="container">
                   <h2>Invalid code.</h2>
                    <a href="reset_request_handler.php" class="btn btn-primary mt-3">Please try again</a>
                  </div>';
            }        
    } else {
            echo '<div class="container">
                <h2>Invalid code.</h2>
                 <a href="password_reset_request.php" class="btn btn-primary mt-3">Please try again</a>
                </div>';
    }
}
?>
</div>
</body>
</html>
