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
                   <a class="nav-link collapsed" href="read_tourism_students.php">
                      <h4 style="color:white;">Students</h4>
                   </a>
                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#SubjectCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                   <h3><a class="nav-link" style="color:white;" href="read_subjects_tourism.php">Subjects</a></h3>
                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#GroupCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Semester enrollment</h3>
                      </a>
                      <div class="collapse" id="GroupCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">                            
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#SCSGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4><li class="nav-link">
                                    <a class="nav-link" style="color:white;" href="read_tourism_1_1.php">SCS 1.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_1_2.php">SCS 1.2</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_2_1.php">SCS 2.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_2_2.php">SCS 2.2</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_3_1.php">SCS 3.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_3_2.php">SCS 3.2</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_4_1.php">SCS 4.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_4_2.php">SCS 4.2</a>
                                    <a class="nav-link" style="color:red;" href="read_tourism_repeats.php">Repeats&Specials</a>
                                  </li>           
                                </h4>
                              </a>                              
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
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_tourism.php">TOURISM</a>
                    </li>                              
                </nav>
              </div>
          </li>                   
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule_lecturer_tourism_admin.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Check schedule as Lecturer</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule_invigilator_tourism_admin.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Check schedule as Invigilator</h3>
            </a>
          </li>                        
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule_students_tourism_admin.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Check schedule as student</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="tourism_exam_schedule_pdf.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Generate Faculty exam schedule</h3>
            </a>
          </li>
        </ul>       
      </div>
    </nav>
