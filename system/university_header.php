<?php
include 'dbcon.php'; // Include your database connection script

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize
    $universityName = htmlspecialchars($_POST['university_name']);
    $faculties = htmlspecialchars($_POST['faculties']);
    $term = htmlspecialchars($_POST['term']);
    $logo = $_FILES['logo']['name'];

    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO university_header (university_name, faculties, term, logo) VALUES (:university_name, :faculties, :term, :logo)");

        // Bind parameters
        $stmt->bindParam(':university_name', $universityName);
        $stmt->bindParam(':faculties', $faculties);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':logo', $logo);

        // Execute SQL statement
        $stmt->execute();
        
        // Redirect to the PDF generation page
        header("Location: University_exam_schedule_pdf.php");
        exit; // Stop further execution
    } catch (PDOException $e) {
        // Handle database error
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include "examoffice_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 10%; width: 80%;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: #007bff; color: white; border-radius:5%;">
                        <h1 class="text-center" style="margin-top: 20px;">UNIVERSITY HEADER</h1>
                    </div>
                    <div class="panel-body" style="padding: 20px;">
                        <div class="card" style="margin:10px;">
                        <?php
                        if (!empty($successMessage)) {
                            echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-top: 10px;">' . $successMessage . '</div>';
                        } elseif (!empty($errorMessage)) {
                            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-top: 10px;">' . $errorMessage . '</div>';
                        }
                        ?>
                        <form method="post" enctype="multipart/form-data" action="University_exam_schedule_pdf.php">
                            <div class="form-group">
                                <label for="logo">Logo:</label>
                                <input type="file" id="logo" name="logo" accept="image/*" class="form-control-file">
                            </div>

                            <div class="form-group">
                                <label for="university_name">Name of the University:</label>
                                <input type="text" id="university_name" name="university_name" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="faculties">Faculties:</label>
                                <textarea id="faculties" name="faculties" rows="6" cols="100" required class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="term">Month-year:</label>
                                <input type="text" id="term" name="term" required class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        </div>                        
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>
