<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION["user_code"])) {
    header("Location: ../authentifications/login.php");
    exit();
}

// Include database connection and other necessary files
include '../system/dbcon.php';

// Place any other common code for the header here
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?></h2>
    <a href="logout.php">Logout</a>
</body>
</html>
