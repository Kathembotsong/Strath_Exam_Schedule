
    <!-- Side bar -->
    <nav id="collapsePages" class="col-md-2 d-md-block sidebar collapse" style="background-color: rgba(0, 0, 0, 0.83);">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="schooladmin_dashboard.php">
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
                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#studentCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                   <h4 style="color:white;">Students</h4>
                   </a>
                   <div class="collapse" id="studentCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_bbit_students_read_only.php">BBIT</a>
                              <a class="nav-link"style="color:white;" href="read_bcom_students_read_only.php">BCOM</a>
                              <a class="nav-link" style="color:white;" href="read_scs_students_read_only.php">SCS</a>
                              <a class="nav-link" style="color:white;" href="read_sls_students_read_only.php">SLS</a>
                              <a class="nav-link" style="color:white;" href="read_tourism_students_read_only.php">TOURISM</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#repeatsCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                   <h4 style="color:white;">Repeats</h4>
                   </a>
                      <div class="collapse" id="repeatsCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_bbit_repeats_read_only.php">BBIT</a>
                              <a class="nav-link"style="color:white;" href="read_bcom_repeats_read_only.php">BCOM</a>
                              <a class="nav-link" style="color:white;" href="read_scs_repeats_read_only.php">SCS</a>
                              <a class="nav-link" style="color:white;" href="read_sls_repeats_read_only.php">SLS</a>
                              <a class="nav-link" style="color:white;" href="read_tourism_repeats_read_only.php">TOURISM</a>
                            </li>                              
                          </nav>
                      </div>
                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#EmployeeCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                   <h4 style="color:white;">Employees</h4>
                   </a>
                      <div class="collapse" id="EmployeeCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_admins.php">Administrators</a>
                              <a class="nav-link"style="color:white;" href="read_exam_officers.php">Exam Officers</a>
                              <a class="nav-link" style="color:white;" href="read_lecturers.php">Lecturers</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#SubjectCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Units</h3>
                      </a>
                      <div class="collapse" id="SubjectCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_subjects_bbit_by_schooladmin.php">BBIT</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_bcom_by_schooladmin.php">BCOM</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_scs_by_schooladmin.php">SCS</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_sls_by_schooladmin.php">SLS</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_tourism_by_schooladmin.php">TOURISM</a>
                            </li>                              
                          </nav>
                      </div>
                    <ul class="nav-link">
                </nav>
            </div>
          <li class="nav-item">
            <a class="nav-link" href="read_only_exam_venue.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Exam rooms</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule_lecturer.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Check schedule as Lecturer</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule_invigilator.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Check schedule as Invigilator</h3>
            </a>
          </li>         
        </ul>       
      </div>
    </nav>
