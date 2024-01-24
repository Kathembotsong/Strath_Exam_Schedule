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

// Function to check if the username and email exist in the students table
function isValidUser($username, $email)
{
    global $conn; // Access the global $conn object

    try {
        $stmt = $conn->prepare("SELECT * FROM students WHERE student_code = :code AND student_email = :email");
        $stmt->bindParam(':code', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($row !== false); // Return true if the row exists, false otherwise
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false in case of an error
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);

    // Perform your validation logic here
    if (isValidUser($username, $email)) {
        // If valid, proceed to the next step (enter phone and email)
        header("Location: enter_phone_email.php?username=$username&email=$email");
        exit();
    } else {
        // If not valid, redirect back to the reset page with an error parameter
        header("Location: password_reset_request.php?error=1");
        
        exit();
    }
}
?>
