
<?php
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
          <li class="nav-item">
            <a class="nav-link" href="individual_exam_schedule_students.php">
              <span data-feather="shopping-cart"></span>
              <h3 style="color:white;">Check schedule as student</h3>
            </a>
          </li>
        </ul>       
      </div>
    </nav>
<?php require 'footer.php' ?>