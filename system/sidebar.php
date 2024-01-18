

    <!-- Side bar -->
    <nav id="collapsePages" class="col-md-2 d-md-block sidebar collapse" style="background-color: rgba(0, 0, 0, 0.83);">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard/dashboard.php">
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
                   <a class="nav-link collapsed" href="read_students.php">
                   <h4 style="color:white;">Students</h4>
                   </a>
                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#EmployeeCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                   <h4 style="color:white;">Employees</h4>
                   </a>
                      <div class="collapse" id="EmployeeCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_admins.php">Amdinistrators</a>
                              <a class="nav-link"style="color:white;" href="read_exam_officers.php">Exam Officers</a>
                              <a class="nav-link" style="color:white;" href="read_lecturers.php">Lecturers</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#SubjectCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Subjects</h3>
                      </a>
                      <div class="collapse" id="SubjectCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="read_subjects_bbit.php">BBIT</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_bcom.php">BCOM</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_scs.php">SCS</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_sls.php">SLS</a>
                              <a class="nav-link" style="color:white;" href="read_subjects_tourism.php">TOURISM</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#GroupCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Semester enrollment</h3>
                      </a>
                      <div class="collapse" id="GroupCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#BBITGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4>BBIT</h4>
                              </a>
                              <div class="collapse" id="BBITGroups" aria-labelledby="headine" >
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
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#BCOMGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4>BCOM</h4>
                              </a>
                              <div class="collapse" id="BCOMGroups" aria-labelledby="headine" >
                                <nav class="sb-sidenav-menu-nested nav">
                                  <li class="nav-link">
                                    <a class="nav-link" style="color:white;" href="read_bcom_1_1.php">BCOM 1.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_1_2.php">BCOM 1.2</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_2_1.php">BCOM 2.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_2_2.php">BCOM 2.2</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_3_1.php">BCOM 3.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_3_2.php">BCOM 3.2</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_4_1.php">BCOM 4.1</a>
                                    <a class="nav-link" style="color:white;" href="read_bcom_4_2.php">BCOM 4.2</a>
                                    <a class="nav-link" style="color:red;" href="read_bcom_repeats.php">Repeats&Specials</a>
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
            <a class="nav-link" href="read_exam_rooms.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Exam rooms</h3>
            </a>
          </li>
        </ul>       
      </div>
    </nav>