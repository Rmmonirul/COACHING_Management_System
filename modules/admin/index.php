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
            <title>Admin-OCTH</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">       
            <link rel="stylesheet" href="../../css/bootstrap.min.css" />
             <script src="../../js/jquery-3.3.1.min.js"></script>
            <script src="../../js/bootstrap.min.js"></script>
        </head>
        <body>
        <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
        <h2 align="center" style="color: blue"><?php echo "Admin" ?></h2>
        <div class="header">
            
            <a href="index.php">Home</a>
            <a href="student.php">Student</a>
            <a href="studentattendance.php">Student Attendance</a>
            <a href="teachers.php">Teachers</a>
            <a href="teachersattendance.php">Teachers Attendance</a>
            <a href="add.php">Add TimeTable/batch</a>
            <a href="addvideo.php">AddVideo</a>
            <a href="incomingcomplaint.php">Incoming Complaint</a>
            <a href="update_password.php">Update Password</a>
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="../../logout.php">Logout</a>
        </div>
        </div>
        <div align="center">
            <table cellpadding="10px">
                <tr>
                    <?php
                    $sql_find_batch = "SELECT count(batch) AS total_batch FROM batches";
                    $sql_find_batch_get=mysqli_query($conn,$sql_find_batch);
                    $sql_find_batch_total = mysqli_fetch_assoc($sql_find_batch_get);
                    ?>
                    <th><div style="background-color: green; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Batches</h3><p><?php echo $sql_find_batch_total['total_batch'];?></p></div></th>

                    <?php
                    $sql_find_sid = "SELECT count(sid) AS total_sid FROM students";
                    $sql_find_sid_get=mysqli_query($conn,$sql_find_sid);
                    $sql_find_sid_total = mysqli_fetch_assoc($sql_find_sid_get);
                    ?>
                    <th><div style="background-color: blue; color:white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Students</h3><p><?php echo $sql_find_sid_total['total_sid'];?></p></div></th>

                    <?php
                    $sql_find_parent = "SELECT count(id) AS total_parent FROM users WHERE type='parent'";
                    $sql_find_parent_get=mysqli_query($conn,$sql_find_parent);
                    $sql_find_parent_total = mysqli_fetch_assoc($sql_find_parent_get);
                    ?>
                    <th><div style="background-color: teal; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Parentss</h3><p><?php echo $sql_find_parent_total['total_parent']; ?></p></div></th>
                    <?php
                    $sql_find_teacher = "SELECT count(eid) AS total_teacher FROM teachers WHERE  position='teacher'";
                    $sql_find_teacher_get=mysqli_query($conn,$sql_find_teacher);
                    $sql_find_teacher_total = mysqli_fetch_assoc($sql_find_teacher_get);
                    ?>
                    <th><div style="background-color: lime; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Teachers</h3><p><?php echo $sql_find_teacher_total['total_teacher']?></p></div></th>

                </tr>
            </table>
        </div>

        <div align="center" style="background-color: lightgray; padding: 10px;">
            <h3 style="color: blue">Batches</h3>
            <table border="1" cellpadding="10px">
                <tr>
                    <th width="250px">Batches</th>
                    <th width="250px">Timings</th>

                </tr>
                <?php
                    $get_batch_information = "SELECT * FROM batches ORDER BY batch";
                    $get_batch_information_query = mysqli_query($conn,$get_batch_information);
                    while($rwo = mysqli_fetch_assoc($get_batch_information_query)){
                ?>
                        <tr>
                            <th><?php echo $rwo['batch']?></th>
                            <td><?php echo $rwo['timings']?></td>
                        </tr>
                      <?php }  ?>
            </table>
        </div>
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