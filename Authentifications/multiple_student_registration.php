<?php include '../system/dbcon.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <img src="../system/assets/strathLogo.ico" alt="University Logo" style="width: 50px;">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">My Exam Schedule</a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <div class="navbar-nav">
        <div class="nav-item text-nowrap">
          <a class="nav-link px-3" href="#">Sign out</a>
        </div>
      </div>
    </header>


<div class="container-fluid">
  <div class="row">
     <?php include '../system/sidebar.php'; ?>
     <!-- main page -->
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color:rgba(0,0,255,.2);">
      
       
<?php
// Function to handle user registration
function registerUser($code, $name, $email, $phone, $school, $password) {
    global $conn;

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO students (student_code, student_name, student_email, student_phone, student_school, student_password) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bindParam(1, $code);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $phone);
    $stmt->bindParam(5, $school);
    $stmt->bindParam(6, $hashedPassword);

    // Execute the statement
    $stmt->execute();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $numUsers = count($_POST['student_code']);

    for ($i = 0; $i < $numUsers; $i++) {
        $code = $_POST['student_code'][$i];
        $name = $_POST['student_name'][$i];
        $email = $_POST['student_email'][$i];
        $phone = $_POST['student_phone'][$i];
        $school = $_POST['student_school'][$i];
        $password = $_POST['student_password'][$i];

        // Call the registerUser function to insert data into the database
        registerUser($code, $name, $email, $phone, $school, $password);
    }

    echo "Registration successful!";
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
        <h2 class="mb-4">Multiple Enrollment Form</h2>
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
                    echo "<input type='text' name='student_code[]' class='form-control' required><br>";

                    echo "<label for='student_name[$i]' class='form-label'>Name:</label>";
                    echo "<input type='text' name='student_name[]' class='form-control' required><br>";

                    echo "<label for='student_email[$i]' class='form-label'>Email:</label>";
                    echo "<input type='email' name='student_email[]' class='form-control' required><br>";

                    echo "<label for='student_phone[$i]' class='form-label'>Phone:</label>";
                    echo "<input type='text' name='student_phone[]' class='form-control' required><br>";

                    echo "<label for='student_school[$i]' class='form-label'>School:</label>";
                    echo "<input type='text' name='student_school[]' class='form-control' required><br>";

                    echo "<label for='student_password[$i]' class='form-label'>Password:</label>";
                    echo "<input type='password' name='student_password[]' class='form-control' required><br>";
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
<?php include '../system/footer.php';?>

    