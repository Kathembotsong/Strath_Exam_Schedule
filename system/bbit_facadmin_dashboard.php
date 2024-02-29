<?php
include '../authentifications/session_check.php';

// Check if the user has access to this specific page (for example, based on their role)
if ($user['role'] !== "role" || $user['school'] !== "BBIT") {
    // If the user is not authorized to access this page, redirect to a suitable landing page
    header("Location: ../dashboard.php");
    exit();
}
    include 'header.php';  
	  include 'dbcon.php';	     
	  include 'js_datatable.php';
 ?>  


    <!-- Side bar -->
    <nav id="collapsePages" class="col-md-2 d-md-block sidebar collapse" style="background-color: rgba(0, 0, 0, 0.83);">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard.php">
              <span data-feather="home"></span>
              <h3 style="color:white;">Dashboard</h3>
            </a>
          </li>
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#Enrollcollapse" aria-expanded="false">
              <h3 style="color:white;">Enrollments</h3>           
         </a>
            <div class="collapse" id="Enrollcollapse" aria-labelledby="headingTwo" data-bs-parent="#collapsePages">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                 <ul class="nav-link">
                   <a class="nav-link collapsed" href="read_bbit_students.php">
                   <h4 style="color:white;">Students</h4>
                   </a>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#SubjectCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Subjects</h3>
                      </a>
                      <div class="collapse" id="SubjectCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_subjects_bbit.php">BBIT</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#GroupCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Semester enrollment</h3>
                      </a>
                      <div class="collapse" id="GroupCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#BbitGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4>BBIT</h4>
                              </a>
                              <div class="collapse" id="BbitGroups" aria-labelledby="headine" >
                                <nav class="sb-sidenav-menu-nested nav">
                                <li class="nav-link">
                                    <a class="nav-link" style="color:white;" href="read_bbit_1_1.php">BBIT 1.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_1_2.php">BBIT 1.2</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_2_1.php">BBIT 2.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_2_2.php">BBIT 2.2</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_3_1.php">BBIT 3.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_3_2.php">BBIT 3.2</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_4_1.php">BBIT 4.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bbit_4_2.php">BBIT 4.2</a>
                                    <a class="nav-link" style="color:red;" href="read_bbit_repeats.php">Repeats&Specials</a>
                                  </li>                             
                                </nav>
                              </div>
                            </li>                                                             
                          </nav>
                      </div>
                  <ul class="nav-link">
                </nav>
            </div>
            <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#DraftCollapse" aria-expanded="false" aria-controls="HomeCollapse">
              <h3 style="color:white;">Time slot</h3>
            </a>
                <div class="collapse" id="DraftCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <li class="nav-link">
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_bbit.php">BBIT</a>
                    </li>                              
                </nav>
              </div>
          </li>                   
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Individual Exam Schedule</h3>
            </a>
          </li>
        </ul>       
      </div>
    </nav>
<?php require 'footer.php' ?>  


    