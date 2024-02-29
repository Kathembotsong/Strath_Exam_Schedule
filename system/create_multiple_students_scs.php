
<?php 
	  include 'dbcon.php'; 
	  include 'header.php';     
	  include 'js_datatable.php';
 ?> 
<div class="container-fluid">
  <div class="row">
    <!-- include the sidebar -->
  <?php include 'sidebar.php'; ?>
     <!-- main page -->
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color:rgba(0,0,255,.2);">
      
     <?php
function validatePassword($password) {
    // Password policy: Minimum 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/";
    return preg_match($pattern, $password);
}

function registerUser($code, $name, $email, $phone, $school, $password) {
    global $conn;
    $message = array(); // Initialize an empty array to store error messages

    // Validate password strength
    if (!validatePassword($password)) {
        $message[] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }

    // Check if there are any error messages
    if (!empty($message)) {
        // Display only the first error message
        echo '<div class="alert alert-danger" role="alert">' . $message[0] . '</div>';
        return; // Stop execution if there are errors
    }

    try {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement using prepared statements
        $stmt = $conn->prepare("INSERT INTO students (student_code, student_name, student_email, student_phone, student_school, student_password) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Bind parameters if using MySQLi (PDO does not have bind_param method)
        $stmt->bindParam(1, $code);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $phone);
        $stmt->bindParam(5, $school);
        $stmt->bindParam(6, $hashedPassword);

        // Execute the statement
        $stmt->execute();

        // Close the statement
        $stmt->close();

        echo "Registration successful!";
    } catch (PDOException $e) {
        // Check if the error is related to a unique constraint violation
        if ($e->getCode() == '23000') {
            // Display a user-friendly message for unique constraint violation
            echo '<div class="alert alert-danger" role="alert">A user with the same code or email already exists.</div>';
        } else {
            // Display a generic error message for other database errors
            echo '<div class="alert alert-danger" role="alert">An error occurred while processing your request. Please try again later.</div>';
        }
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    $numUsers = count($_POST['student_code']);

    for ($i = 0; $i < $numUsers; $i++) {
        $code = htmlspecialchars($_POST['student_code'][$i]);
        $name = htmlspecialchars($_POST['student_name'][$i]);
        $email = htmlspecialchars($_POST['student_email'][$i]);
        $phone = htmlspecialchars($_POST['student_phone'][$i]);
        $school = htmlspecialchars($_POST['student_school'][$i]);
        $password = htmlspecialchars($_POST['student_password'][$i]);

        // Call the registerUser function to insert data into the database
        registerUser($code, $name, $email, $phone, $school, $password);
    }
}
?>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>

    <div class="container mt-5">
        <h2 class="mb-4">Enrol Multiple Students at the same time</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="row row-cols-1 row-cols-md-5 g-4">
                <?php
                // Define the number of users to register
                $numUsers = 50;

                for ($i = 0; $i < $numUsers; $i++) {
                    echo "<div class='col'>";
                    echo "<div class='card p-3'>";
                    echo "<h3 class='card-title text-center mb-4'>Student " . ($i + 1) . "</h3>";
                    echo "<label for='student_code[$i]' class='form-label'>Student Code:</label>";
                    echo "<input type='text' name='student_code[]' class='form-control' ><br>";

                    echo "<label for='student_name[$i]' class='form-label'>Name:</label>";
                    echo "<input type='text' name='student_name[]' class='form-control' ><br>";

                    echo "<label for='student_email[$i]' class='form-label'>Email:</label>";
                    echo "<input type='email' name='student_email[]' class='form-control' ><br>";

                    echo "<label for='student_phone[$i]' class='form-label'>Phone:</label>";
                    echo "<input type='text' name='student_phone[]' class='form-control' ><br>";

                    echo "<label for='student_school[$i]' class='form-label'>School:</label>";
                    echo "<input type='text' name='student_school[]' class='form-control' ><br>";

                    echo "<label for='student_password[$i]' class='form-label'>Password:</label>";
                    echo "<input type='password' name='student_password[]' class='form-control'><br>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
            <input type="submit" class="btn btn-primary mt-3" value="Register">
        </form>
    </div>
</div>
</div>

</main>
<?php include 'footer.php';?>

    