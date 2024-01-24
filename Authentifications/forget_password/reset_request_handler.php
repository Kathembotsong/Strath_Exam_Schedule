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
    <?php
    // Set the server time zone to Nairobi
    date_default_timezone_set('Africa/Nairobi');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);

        // Validate user existence and get their phone number
        $stmt = $conn->prepare("SELECT student_id, student_phone FROM students WHERE student_code = :code and student_email = :email");
        $stmt->bindParam(':code', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "User not found. Please check your code or email.";
            exit();
        }

        $userId = $row['student_id'];
        $phoneNumber = $row['student_phone'];

        // Generate a random 6-digit code
        $resetCode = mt_rand(100000, 999999);

        // Store the reset code and its expiration time in the database
        $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Example: Code expires in 1 hour
        $stmt = $conn->prepare("INSERT INTO password_resets (student_id, reset_code, expiration_time) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $userId);
        $stmt->bindParam(2, $resetCode);
        $stmt->bindParam(3, $expirationTime);
        $stmt->execute();

    }
    ?>
    <h2>Enter the reset code here</h2>
    <form method="post" action="validate_reset_code.php">
        <input type="text" name="reset_code" required>
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
