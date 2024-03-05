<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

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