<?php
session_start();
include '../system/dbcon.php'; // Assuming this file contains your database connection

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['user_code'])) {
    header("Location: ../authentifications/index.php");
    exit();
}

?>

