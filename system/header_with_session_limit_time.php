<?php
// Start the session
session_start();

// Set session timeout (in seconds) - adjust as needed
$session_timeout = 60; // 1 minutes

// Check if the user is logged in and session is active
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Session expired, destroy session and redirect to login page
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../authentifications/login.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

// Check if user is logged in and username is set in session
if(isset($_SESSION["username"])) {
    // User is logged in, display welcome message
    $welcome_message = '<h4>Welcome, ' . htmlspecialchars($_SESSION["username"]) . '</h4>';
} else {
    // User is not logged in, redirect to login page
    header("Location: ../authentifications/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Header</title>
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    
    <style>
        .username {
            color: white;
        }
    </style>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <img src="assets/strathLogo.ico" alt="University Logo" style="width: 50px;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">My Exam Schedule</a>
        <h2><span class="username"><?php echo $welcome_message; ?></span></h2>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-25" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="../authentifications/logout.php">Sign out</a>
            </div>
        </div>
    </header>
</body>
</html>

       