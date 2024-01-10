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
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailOrPhone = htmlspecialchars($_POST['phone']);

        // Generate a unique code or token
        $resetCode = generateUniqueCode();

        // Save the reset code and user's email/phone in the database
        saveResetRequest($emailOrPhone, $resetCode);

        // Send the code to the user's phone or email
        sendResetCode($emailOrPhone, $resetCode);

        echo '<div class="alert alert-success" role="alert">Reset code sent successfully. Check your email or phone.</div>';
    }
    ?>

    <!-- Your HTML form for initiating the password reset -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="phone">Enter your Email or Phone:</label>
        <input type="text" name="phone" class="form-control" required>
        <input type="submit" class="btn btn-primary mt-3" value="Send Reset Code">
    </form>

    <!-- Add your footer or include the footer file here -->

<?php
function generateUniqueCode() {
    // You can implement a function to generate a unique code or token (e.g., using random_bytes())
    // This is a simple example; you should use a more secure method in production
    return substr(md5(uniqid(rand(), true)), 0, 8);
}

function saveResetRequest($emailOrPhone, $resetCode) {
    global $conn;

    // Save the reset code and user's email/phone in the database
    $stmt = $conn->prepare("INSERT INTO password_reset (phone, reset_code) VALUES (?, ?)");
    $stmt->bindParam(1, $emailOrPhone);
    $stmt->bindParam(2, $resetCode);
    $stmt->execute();
    $stmt->closeCursor();
}

function sendResetCode($emailOrPhone, $resetCode) {
    require_once 'vendor/autoload.php';  // Include Twilio PHP library

    use Twilio\Rest\Client;
    
    function sendResetCode($emailOrPhone, $resetCode) {
        // Twilio credentials
        $accountSid = 'your_account_sid';
        $authToken  = 'your_auth_token';
        $twilioNumber = 'your_twilio_phone_number';
    
        // User's phone number (replace with $emailOrPhone if the format is phone number)
        $to = 'user_phone_number';
    
        // Create a Twilio client
        $client = new Client($accountSid, $authToken);
    
        try {
            // Send SMS
            $message = $client->messages->create(
                $to,
                [
                    'from' => $twilioNumber,
                    'body' => 'Your reset code is: ' . $resetCode,
                ]
            );
    
            // Output a success message
            echo 'Reset code sent successfully.';
        } catch (Exception $e) {
            // Output an error message
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    // Example usage
    $resetCode = '123456';  // Replace with the actual reset code
    sendResetCode('user@example.com', $resetCode);
    
}
?>
</body>
</html>