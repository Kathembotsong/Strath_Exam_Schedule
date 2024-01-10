<?php
// Include the Twilio library
require(__DIR__.'/../twilio_php_main/src/Twilio/autoload.php');
use Twilio\Rest\Client;

// Function to send the reset code to the user's phone using Twilio
function sendResetCode($phoneNumber, $resetCode) {
    // Your Twilio credentials
    $sid = 'AC7d5e1f2cadf4fcaec7cff1382a77bac6';
    $token = 'c573dfdad0388bde25c876e79df6d7c2';
    $twilioNumber = '+12064298938';

    // Initialize Twilio client
    $twilio = new Client($sid, $token);

    // Format the phone number (assuming it's in E.164 format)
    $formattedPhoneNumber = '+' . $phoneNumber;

    // Send SMS using Twilio
    $twilio->messages->create(
        $formattedPhoneNumber,
        [
            'from' => $twilioNumber,
            'body' => "Your password reset code is: $resetCode"
        ]
    );
}
?>




