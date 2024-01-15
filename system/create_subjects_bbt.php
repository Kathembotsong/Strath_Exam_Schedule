<?php 
	  include 'dbcon.php'; 
	  include 'header.php';     
	  include 'js_datatable.php';
 ?> 

    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            <!-- main page -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: rgba(0,0,255,.2);">
            <?php
                      function registerUser($code, $name) {
                   global $conn;
                   $message = array(); // Initialize an empty array to store error messages

                    try {
                      // Prepare the SQL statement using prepared statements
                      $stmt = $conn->prepare("INSERT INTO subjects_bbt (subject_code, subject_name) VALUES (?, ?)");
        
                      // Bind parameters if using MySQLi (PDO does not have bind_param method)
                      $stmt->bindParam(1, $code);
                      $stmt->bindParam(2, $name);
                      // Execute the statement
                      $stmt->execute();

                      echo "Insertion successful!";
                    } catch (PDOException $e) {
                              // Display a generic error message for other database errors
                               echo '<div class="alert alert-danger" role="alert">An error occurred while processing your request. Please try again later.</div>';
                        }
                    }
                

                // Check if the form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                     // Validate and sanitize form data
                    $code = htmlspecialchars($_POST['subject_code']);
                    $name = htmlspecialchars($_POST['subject_name']);
                    // Call the registerUser function to insert data into the database
                    registerUser($code, $name);
               }
            ?>
            <style>
                body {
                    background-color: #f8f9fa;
                }
                h2 {
                   color: #007bff;
                }
              .container{
                   width:40%;
                   margin-left:20%;
                   text-align: center;
                }
               .card{
                   background-color: #ffffff;
                   box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
                    <h2 class="mb-4">Create Subject</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row g-4">
                            <div class="col">
                                <div class="card p-3">
                                    <h3 class="card-title text-center mb-4">BBIT</h3>
                                    <label for="subject_code" class="form-label">Subject Code:</label>
                                    <input type="text" name="subject_code" class="form-control" required><br>
                                    <label for="subject_name" class="form-label">Subject Name:</label>
                                    <input type="text" name="subject_name" class="form-control" required><br>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" value="Register">
                    </form>
                </div>
            </main>            
        </div>
    </div>
</body>
<?php include 'footer.php'; ?>

