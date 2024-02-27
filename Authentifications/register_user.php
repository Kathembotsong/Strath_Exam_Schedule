<?php

require '../system/dbcon.php';  

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Sanitize inputs to prevent SQL injection
    $user_code = filter_var($_POST['user_code'], FILTER_SANITIZE_STRING);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $school = filter_var($_POST['school'], FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);

    // Prepare and execute SQL query to insert user into database
    $insert = $conn->prepare("INSERT INTO users (user_code, username, email, phone, school, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert->execute([$user_code, $username, $email, $phone, $school, $password, $role]);

    // Check if user is successfully inserted
    if($insert) {
        $message = "User created successfully.";
    } else {
        $error = "Error creating user: " . $insert->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <!-- Add your CSS links here -->
</head>
<body>
    <h1>Create User</h1>
    <?php
    // Display success or error message if available
    if(isset($message)) {
        echo "<p style='color: green;'>$message</p>";
    }
    if(isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form action="" method="post">
        <label for="user_code">Usr_code:</label><br>
        <input type="text" id="username" name="user_code" required><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        
        <label for="school">School:</label><br>
        <input type="text" id="school" name="school" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
            <option value="facadmin">Faculty Admin</option>
            <option value="schooladmin">School Admin</option>
        </select><br>
        
        <input type="submit" name="submit" value="Create User">
    </form>
</body>
</html>
