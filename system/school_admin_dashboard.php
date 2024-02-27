
<?php 
session_start();
// Check if the user is logged in and is a school admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'schooladmin') {
    header("Location: login.php"); // Redirect to login page
    exit();
}

include 'dbcon.php'; 
include 'header.php';     
include 'js_datatable.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <!-- main page -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="background-color: rgba(0,0,255,.2);">
       
        </main>            
    </div>
</div>
</body>
<?php include 'footer.php'; ?>


