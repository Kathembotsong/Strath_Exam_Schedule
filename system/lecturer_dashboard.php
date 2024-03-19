<?php
include 'header.php';
include 'dbcon.php';
include 'js_datatable.php';
?>

<div class="container-fluid">
    <div class="row justify-content-center text-center">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="container" style="width: 80%;">               
                <div class="row" style="background-color: #007bff; color: white; border-radius: 3%;">
                    <h1 class="text-center" style="margin-top: 20px;">MY EXAM TIMETABLE</h1>
                    <div class="col-6">
                        <h5>As Lecturer</h5>                        
                        <a href="exam_schedule_as_lecturer.php"><img src="assets/images/lecture.png" alt="" class="card img-fluid"></a>
                    </div>
                    <div class="col-6">
                    <h5>As Invigilator</h5>
                        <a href="exam_schedule_as_invigilator.php"><img src="assets/images/invigilator.png" alt="" class="card img-fluid"></a>
                    </div>
                </div>             
            </div>
        </main>
        <?php require 'footer.php' ?>
    </div>
</div>

