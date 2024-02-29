<?php
session_start();
include '../system/dbcon.php'; // Assuming this file contains your database connection

// Check if the user is not logged in, then redirect to the login page
if (!isset($_SESSION['user_code'])) {
    header("Location: ../authentifications/index.php");
    exit();
}

// Fetch user role from the database
$query = "SELECT role FROM users WHERE user_code = :user_code";
$statement = $conn->prepare($query);
$statement->bindParam(':user_code', $_SESSION['user_code']);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the user has the correct role
if (!$user || $user['role'] !== "role") {
    // If the user is not found or the role doesn't match, redirect to the login page
    header("Location: ../authentifications/index.php");
    exit();
}
?>

