<?php
// enter_phone_email.php

// Include the database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam_tb1";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Function to generate a random reset code
function generateResetCode()
{
    return mt_rand(100000, 999999);
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
    .container {
        margin-top: 10%;
        margin-left: 30%;
        background-color: rgba(0, 85, 255);
        color: white;
        width: 35%;
        padding: 5%;
        border-radius: 5%;
    }
</style>

<body>
    <div class="container">
        <center>
        <?php
        // Set the server time zone to Nairobi
        date_default_timezone_set('Africa/Nairobi');

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $phone = htmlspecialchars($_POST['phone']);
            $email = htmlspecialchars($_POST['email']);

            // Validate user existence and get their student_id
            $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_phone = :phone AND student_email = :email");
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Generate a random 6-digit code
                $resetCode = generateResetCode();

                // Store the reset code and its expiration time in the database
                $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Example: Code expires in 1 hour
                $userId = $row['student_id'];
                $stmt = $conn->prepare("INSERT INTO password_resets (student_id, reset_code, expiration_time) VALUES (?, ?, ?)");
                $stmt->bindParam(1, $userId);
                $stmt->bindParam(2, $resetCode);
                $stmt->bindParam(3, $expirationTime);
                $stmt->execute();

                // Display the password reset form
                echo "<h2>Reset Code</h2>";
                echo "<form method='post' action='validate_reset_code.php'>";
                echo "<p>Reset Code: $resetCode</p>";
                echo "<input type='text' name='reset_code' value='Enter your code' required>";
                echo "<div><input type='submit' value='confirm'></div>";
                echo "</form>";
            } else {
                echo "<h2>User Validation</h2>";
                echo "<p class='btn btn-danger'>User not found. Please check your phone number or email.</p>";
                echo "<form method='post' action=''>";
                echo "<input type='text' name='phone' placeholder='Enter your phone number' required>";
                echo "<input type='email' name='email' placeholder='Enter your email' required>";
                echo "<div><input type='submit' value='confirm'></div>";
                echo "</form>";
                
            }
        } else {
            // Display the user validation form initially
            echo "<h2>User Validation</h2>";
            echo "<form method='post' action=''>";
            echo "<input type='text' name='phone' placeholder='Enter your phone number' required>";
            echo "<input type='email' name='email' placeholder='Enter your email' required>";
            echo "<div><input type='submit' value='confirm'></div>";
            echo "</form>";
        }
        ?>
        </center>
    </div>
</body>

</html>
