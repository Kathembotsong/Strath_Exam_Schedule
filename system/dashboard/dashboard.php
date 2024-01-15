<?php include '../dbcon.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <img src="../assets/strathLogo.ico" alt="University Logo" style="width: 50px;">
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
                   <a class="nav-link collapsed" href="../read_students.php">
                   <h4 style="color:white;">Students</h4>
                   </a>
                   <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#EmployeeCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                   <h4 style="color:white;">Employees</h4>
                   </a>
                      <div class="collapse" id="EmployeeCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="../read_admins.php">Amdinistrators</a>
                              <a class="nav-link"style="color:white;" href="../read_exam_officers.php">Exam Officers</a>
                              <a class="nav-link" style="color:white;" href="../read_lecturers.php">Lecturers</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#SubjectCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Subjects</h3>
                      </a>
                      <div class="collapse" id="SubjectCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="../read_subjects_bbit.php">BBIT</a>
                              <a class="nav-link" style="color:white;" href="../read_subjects_bcom.php">BCOM</a>
                              <a class="nav-link" style="color:white;" href="../read_subjects_scs.php">SCS</a>
                              <a class="nav-link" style="color:white;" href="../read_subjects_sls.php">SLS</a>
                              <a class="nav-link" style="color:white;" href="../read_subjects_tourism.php">TOURISM</a>
                            </li>                              
                          </nav>
                      </div>
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#GroupCollapse" aria-expanded="false" aria-controls="HomeCollapse">
                      <h3 style="color:white;">Groups</h3>
                      </a>
                      <div class="collapse" id="GroupCollapse" aria-labelledby="headine" data-bs-parent="#sidenavAccordionPages">
                          <nav class="sb-sidenav-menu-nested nav">
                            <li class="nav-link">
                              <a class="nav-link" style="color:white;" href="../read_group_bbit.php">BBIT</a>
                              <a class="nav-link" style="color:white;" href="../read_group_bcom.php">BCOM</a>
                              <a class="nav-link" style="color:white;" href="../read_group_scs.php">SCS</a>
                              <a class="nav-link" style="color:white;" href="../read_group_sls.php">SlS</a>
                              <a class="nav-link" style="color:white;" href="../read_group_tourism.php">TOURISM</a>
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
    <?php include '../footer.php'; ?>