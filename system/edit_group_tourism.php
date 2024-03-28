<?php 
include 'dbcon.php'; 
include 'header.php';     

if(isset($_REQUEST['update_id'])) {
    try {
        $id = $_REQUEST['update_id']; // get update_id and store in $id variable
        
        $select_stmt = $conn->prepare('SELECT * FROM group_tourism WHERE group_id =:id'); // sql select query
        $select_stmt->bindParam(':id',$id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch(PDOException $e) {
        $e->getMessage();
    }
}

if(isset($_REQUEST['btn_update'])) {
    try {
        $group_name = $_REQUEST['txt_group_name']; // textbox name "txt_group_name"
        $group_capacity = $_REQUEST['txt_group_capacity']; // textbox name "txt_group_capacity"
            
        if(empty($group_name)) {
            $errorMsg = "Please Enter Group Name";
        } else if(empty($group_capacity)) {
            $errorMsg = "Please Enter Group Capacity";
        } else {
            if(!isset($errorMsg)) {
                $update_stmt = $conn->prepare('UPDATE group_tourism SET group_name=:group_name, group_capacity=:group_capacity WHERE group_id=:id'); // sql update query
                $update_stmt->bindParam(':group_name',$group_name);
                $update_stmt->bindParam(':group_capacity',$group_capacity);
                $update_stmt->bindParam(':id',$id);
                    
                if($update_stmt->execute()) {
                    $updateMsg = "Record update successfully...";
                    header("refresh:2;read_group_tourism.php"); // refresh 2 second and redirect to read_group_tourism.php page
                }
            }
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="row">  
        <?php include 'tourism_facadmin_sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="wrapper">            
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 style="text-align: center;">EDIT GROUP CAPACITY</h1>
                            <h3><a href="read_group_tourism.php" style="text-decoration:none;">&laquo; Back to Group List</a></h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" class="form-horizontal">
                                <?php 
                                if(isset($errorMsg)) {
                                ?>
                                    <div class="alert alert-danger">
                                        <strong><?php echo $errorMsg; ?></strong>
                                    </div>
                                <?php 
                                }
                                if(isset($updateMsg)) {
                                ?>
                                    <div class="alert alert-success">
                                        <strong><?php echo $updateMsg; ?></strong>
                                    </div>
                                <?php 
                                }
                                ?>
                                <div class="form-group">
                                    <label for="group_name" class="col-sm-3 control-label">Group Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="txt_group_name" class="form-control" value="<?php echo $group_name; ?>" placeholder="Enter Group Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="group_capacity" class="col-sm-3 control-label">Group Capacity</label>
                                    <div class="col-sm-6">
                                        <input type="number" name="txt_group_capacity" class="form-control" value="<?php echo $group_capacity; ?>" placeholder="Enter Group Capacity" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                                        <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </main>
    <?php require 'footer.php' ?>
</div>
</div>
