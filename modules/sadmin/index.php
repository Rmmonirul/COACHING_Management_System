<?php


session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../config/database.php");
    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];
    $sql = "SELECT * FROM teachers WHERE eid = '$eid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    if($row = mysqli_fetch_assoc($result)){
        $fname= ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        $status = $row['status'];
    }
    if($status == 'yes' || $status == 'Yes') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>SAdmin-OCTH</title>
            <link rel="stylesheet" type="text/css" href="../admin/css/style.css">
        </head>
        <body>
        <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
        <h2 align="center" style="color: blue"><?php echo "Super Admin" ?></h2>
        <div class="header">
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="add.php">Add/Update</a>
            <a href="view.php">View Details</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../logout.php">Logout</a>
        </div>

        <div align="center">
            <table cellpadding="10px">
                <tr>
                    <?php
                    $sql_find_batch = "SELECT count(batch) AS total_batch FROM batches";
                    $sql_find_batch_get=mysqli_query($conn,$sql_find_batch);
                    $sql_find_batch_total = mysqli_fetch_assoc($sql_find_batch_get);
                    ?>
                    <th><div style="background-color: green; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Batch</h3><p><?php echo $sql_find_batch_total['total_batch'];?></p></div></th>

                    <?php
                    $sql_find_sid = "SELECT count(sid) AS total_sid FROM students";
                    $sql_find_sid_get=mysqli_query($conn,$sql_find_sid);
                    $sql_find_sid_total = mysqli_fetch_assoc($sql_find_sid_get);
                    ?>
                    <th><div style="background-color: red; color:white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Students</h3><p><?php echo $sql_find_sid_total['total_sid'];?></p></div></th>

                    <?php
                    $sql_find_teacher = "SELECT count(eid) AS total_teacher FROM teachers WHERE position='teacher'";
                    $sql_find_teacher_get=mysqli_query($conn,$sql_find_teacher);
                    $sql_find_teacher_total = mysqli_fetch_assoc($sql_find_teacher_get);
                    ?>
                    <th><div style="background-color: skyblue; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Teachers</h3><p><?php echo $sql_find_teacher_total['total_teacher']?></p></div></th>

                </tr>
            </table>
        </div>

        <div align="center" style="background-color: lightgray; padding: 10px;">
            <h3 style="color: blue">Admins</h3>
            <table border="1" cellpadding="10px">
                <tr>
                     <th width="250px">Admin EID</th>
                    <th width="250px">Admin Name</th>
                    <th width="250px">Admin Salary</th>
                </tr>
                <?php
                    $get_batch_information = "SELECT * FROM teachers where position='admin'";
                    $get_batch_information_query = mysqli_query($conn,$get_batch_information);
                    while($rwo = mysqli_fetch_assoc($get_batch_information_query)){
                ?>
                        <tr>
                            <th><?php echo $rwo['eid']?></th>
                            <th><?php echo $rwo['fname']." ".$rwo['lname']?></th>
                            <th><?php echo $rwo['salary']?></th>
                        </tr>
                      <?php }  ?>
            </table>
        </div>
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>
        </body>
        </html>
        <?php
    }else{
        ?>
        <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
        <?php
    }
}else{
    header("Location: ../../index.php");
}

?>