<?php
    include 'header.php'; 
    include 'dbcon.php'; 

    // Check if user is logged in and retrieve user credentials from session
    if(!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
    $username = $_SESSION['username'];

    // Fetch user data based on user ID
    $select_stmt = $conn->prepare('SELECT * FROM users WHERE username = :username');
    $select_stmt->bindParam(':username', $username);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if user data exists
    if(!$row) {
        // Redirect or display error message if user data does not exist
        header("Location: error.php");
        exit();
    }

    // Initialize the message variable
    $message = '';

    // Function to validate the password based on the provided policy
    function validatePassword($password) {
        // Password policy: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/";
        return preg_match($pattern, $password);
    }

    // Function to update user information
    function updateUser($email, $phone, $password, $user_id) {
        global $conn;
        global $message; // Access the message variable

        // Validate password if provided
        if($password && !validatePassword($password)) {
            $message = '<div class="alert alert-danger" role="alert">Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.</div>';
            return;
        }

        try {
            // Prepare SQL statement to update user information
            $update_stmt = $conn->prepare('UPDATE users SET email = :email, phone = :phone' . ($password ? ', user_password = :password' : '') . ' WHERE username = :username');
            $update_stmt->bindParam(':email', $email);
            $update_stmt->bindParam(':phone', $phone);
            if($password) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt->bindParam(':password', $hashedPassword);
            }
            $update_stmt->bindParam(':username', $username);
            $update_stmt->execute();
            header("location:../authentifications/login.php");
        } catch(PDOException $e) {
            $message = '<div class="alert alert-danger" role="alert">An error occurred while updating user information. Please try again later.</div>';
        }
    }

    // Check if form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $password = htmlspecialchars($_POST['password']);
        updateUser($email, $phone, $password, $username);
    }
?>

<div class="container-fluid">
    <div class="row">
        <main>
            <div class="container mt-5">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row g-4">
                        <div class="col-5" style="margin-left:35%; background-color:rgba(255,105,20,.2); padding:5px;">
                            <div class="card p-3">
                                <h3 class="card-title text-center mb-4">My credentials</h3>
                                <?php echo $message; ?>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" readonly>
                                
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required><br>

                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo $row['phone']; ?>" required><br>

                                <label for="password" class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control"><br>
                                </div>
                            <input type="submit" class="btn btn-primary mt-3" value="Update"> 
                        </div>
                    </div>
                </form>
            </div>
        </main>            
    </div>
</div>