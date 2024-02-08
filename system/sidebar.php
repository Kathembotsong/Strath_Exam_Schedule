

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
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#SCSGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4>SCS</h4>
                              </a>
                              <div class="collapse" id="SCSGroups" aria-labelledby="headine" >
                                <nav class="sb-sidenav-menu-nested nav">
                                  <li class="nav-link">
                                    <a class="nav-link" style="color:white;" href="read_scs_1_1.php">SCS 1.1</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_1_2.php">SCS 1.2</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_2_1.php">SCS 2.1</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_2_2.php">SCS 2.2</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_3_1.php">SCS 3.1</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_3_2.php">SCS 3.2</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_4_1.php">SCS 4.1</a>
                                    <a class="nav-link" style="color:white;" href="read_scs_4_2.php">SCS 4.2</a>
                                    <a class="nav-link" style="color:red;" href="read_scs_repeats.php">Repeats&Specials</a>
                                  </li>                              
                                </nav>
                              </div>
                            </li>
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#SLSGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4>SLS</h4>
                              </a>
                              <div class="collapse" id="SLSGroups" aria-labelledby="headine" >
                                <nav class="sb-sidenav-menu-nested nav">
                                  <li class="nav-link">
                                    <a class="nav-link" style="color:white;" href="read_sls_1_1.php">SLS 1.1</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_1_2.php">SLS 1.2</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_2_1.php">SLS 2.1</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_2_2.php">SLS 2.2</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_3_1.php">SLS 3.1</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_3_2.php">SLS 3.2</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_4_1.php">SLS 4.1</a>
                                    <a class="nav-link" style="color:white;" href="read_sls_4_2.php">SLS 4.2</a>
                                    <a class="nav-link" style="color:red;" href="read_sls_repeats.php">Repeats&Specials</a>
                                  </li>                              
                                </nav>
                              </div>
                            </li> 
                            <li class="nav-link">
                              <a class="nav-link collapsed" style="color:white;" href="#" data-bs-toggle="collapse" data-bs-target="#TourismGroups" aria-expanded="false" aria-controls="HomeCollapse">
                              <h4>TOURISM</h4>
                              </a>
                              <div class="collapse" id="TourismGroups" aria-labelledby="headine" >
                                <nav class="sb-sidenav-menu-nested nav">
                                  <li class="nav-link">
                                    <a class="nav-link" style="color:white;" href="read_tourism_1_1.php">TOURISM 1.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_1_2.php">TOURISM 1.2</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_2_1.php">TOURISM 2.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_2_2.php">TOURISM 2.2</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_3_1.php">TOURISM 3.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_3_2.php">TOURISM 3.2</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_4_1.php">TOURISM 4.1</a>
                                    <a class="nav-link" style="color:white;" href="read_tourism_4_2.php">TOURISM 4.2</a>
                                    <a class="nav-link" style="color:red;" href="read_tourism_repeats.php">Repeats&Specials</a>
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
            <a class="nav-link" href="read_exam_venue.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Exam rooms</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#DraftCollapse" aria-expanded="false" aria-controls="HomeCollapse">
              <h3 style="color:white;">Time slot</h3>
            </a>
                <div class="collapse" id="DraftCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <li class="nav-link">
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_bbt.php">BBIT</a>
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_bcom.php">BCOM</a>
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_scs.php">SCS</a>
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_sls.php">SLS</a>
                      <a class="nav-link" style="color:white;" href="read_draft_exam_schedule_tourism.php">TOURISM</a>
                    </li>                              
                </nav>
              </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="read_time_availability.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Available time</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="process_exam_scheduling.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Process exam draft</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="conflicts_identification.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Conflicts identification</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="merged_data_back1.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Frist Solution</h3>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="2nd_solution.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Second Solution</h3>
            </a>
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