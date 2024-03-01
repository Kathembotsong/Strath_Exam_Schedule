<?php
    include 'dbcon.php';
    include 'header.php';
    include 'js_datatable.php'; 
?>
     <div class="container-fluid">
    <div class="row">
        <?php include "examoffice_sidebar.php"; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="margin-left: 35%; width: 35%; background-color: rgba(0, 15, 180, .2); padding: 3%; border-radius: 5%;">
                <div class="panel panel-default">
                
                    <center>
                        <div class="panel-heading">
                            <h1 style="text-align: center;">GENERATE NOW </h1>
                        </div>
                        <div class="panel-body">
                            <img src="assets/images/pdf-download.png" style="width:60%;" alt="my image here">
                            <form method="post">
                                <!-- Display messages here -->
                                <?php
                                if (!empty($successMessage)) {
                                    echo '<div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px;">' . $successMessage . '</div>';
                                } elseif (!empty($errorMessage)) {
                                    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 10px;">' . $errorMessage . '</div>';
                                }
                                ?>
                                <a href="university_exam_schedule_pdf.php" style="text-decoration:none;"><span class="btn btn-primary">Ok</span></a>
                                <a href="exam_officer_dashboard.php" style="text-decoration:none;"><span class="fas fa-times btn btn-danger"></span></a>
                            </form>
                        </div>
                    </center>
                </div>
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

