<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <img src="../system/assets/strathLogo.ico" alt="University Logo" style="width: 50px;">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Password Reset Request</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <div class="navbar-nav">
            
        </div>
    </header>
<body>
    <div class="container">
        <center>
        <div class="card" style="width:40%; background-color: rgba(255,127,127,0.2); padding:5%;">
        <h2>Password Reset Request</h2>
        <?php
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<div class="error-message btn btn-danger">Invalid username or email. Please check your credentials.</div>';
            }
        ?>
        <form method="post" action="validate_user.php">
            <label for="username">Username</label>
            <div class="mb-3">
            <input type="text" name="username" required>
            </div>
            <label for="email">Email</label>
            <div class="mb-3">
            <input type="text" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
        </center>
    </div>
</body>
</html>