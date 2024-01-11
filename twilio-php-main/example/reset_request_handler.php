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

    // Include the Twilio library
    require(__DIR__.'/../src/Twilio/autoload.php');
    require('../../system/dbcon.php');
    use Twilio\Rest\Client;

    // Function to send the reset code to the user's phone using Twilio
    function sendResetCode($phoneNumber, $resetCode, $twilioNumber, $sid, $token) {
        try {
            // Initialize Twilio client
            $twilio = new Client($sid, $token);

            // Format the phone number to E.164 format
            $formattedPhoneNumber = normalizePhoneNumber($phoneNumber);

            // Send SMS using Twilio
            $twilio->messages->create(
                $formattedPhoneNumber,
                [
                    'from' => $twilioNumber,
                    'body' => "Your password reset code is: $resetCode"
                ]
            );

            // Output message with styling
            echo '<div class="resetcode">';
            echo 'Reset code sent successfully. Check your phone!';
            echo '</div>';
        } catch (\Exception $e) {
            // Handle errors
            echo '<div class="resetcode">';
            echo 'Error sending reset code: ' . $e->getMessage();
            echo '</div>';
        }
    }

    // Function to normalize the phone number to E.164 format
    function normalizePhoneNumber($phoneNumber) {
        // Remove any non-numeric characters
        $phoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

        // Add the country code if not present (assuming it's Kenya, which is '+254')
        if (substr($phoneNumber, 0, 1) !== '0') {
            $phoneNumber = '+' . $phoneNumber;
        }

        return $phoneNumber;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usernameOrEmail = htmlspecialchars($_POST['username_or_email']);

        // Validate user existence and get their phone number
        $stmt = $conn->prepare("SELECT student_id, student_phone FROM students WHERE student_code = :code OR student_email = :email");
        $stmt->bindParam(':code', $usernameOrEmail);
        $stmt->bindParam(':email', $usernameOrEmail);
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

        // Your Twilio credentials
        $sid = 'AC7d5e1f2cadf4fcaec7cff1382a77bac6';
        $token = 'c5668b90bf617dfe933dde2b6d7d66d8';
        $twilioNumber = '+12064298938';

        // Send the reset code to the user's phone using Twilio
        sendResetCode($phoneNumber, $resetCode, $twilioNumber, $sid, $token);
        
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