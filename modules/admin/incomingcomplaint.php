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
    if(isset($_GET['ret'])) {
        if ($_GET['ret'] == 'success') {
            echo '<script>alert("Replied Successful")</script>';
        }
        if ($_GET['ret'] == 'cancel') {
            echo '<script>alert("Replied Cancel")</script>';
        }
    }
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
    <style>
        .linking{
            background-color: #ddffff;
            padding: 7px;
            text-decoration: none;
        }
        .linking:hover{
            background-color: blue;
            color: white;
        }

                input,button,select{
                    padding: 5px;
                    border: 2px solid blue;
                    border-radius: 10px;
                    margin: 2px;
                }
                input[type=submit],button{
                    width: 200px;
                }
                input:hover{
                    background-color: lightblue;
                }
                    input[type=submit]:hover{
                    background-color: green;
                        color: white;
                }

    </style>
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
            <div align="center" style="background-color: aquamarine;padding: 10px">
            <a href="downloadComplaint.php" class="linking">Download Excel</a>
            
        </div>
<?php
    $sql_get_complaint = "SELECT * FROM complaint WHERE teacher_type='admin' OR teacher_type='Admin' ORDER BY  dateofcomp";
    $sql_get_complaint_check = mysqli_query($conn,$sql_get_complaint);
    $sql_get_complaint_check_result = mysqli_num_rows($sql_get_complaint_check);
    if($sql_get_complaint_check_result>0){
        ?>
        <div align="center">
            <h4>Incoming Complaints</h4>
            <table border="2px">
                <tr>
                <tr><th>Teacher Id</th>
                    <th>Username</th>
                    <th>Batch</th>
                    <th>Subject</th>
                    <th>Complaint</th>
                    <th>Date Of Complaint</th>
                    <th>Reply</th>
                    <th>Date Of Reply</th>
                    <th>Status</th>
                </tr>
            <?php while($rown = mysqli_fetch_assoc($sql_get_complaint_check)){
                    $id_get = $rown['id'];
                ?>
                <tr align="center">
                <td><?php echo $rown['eid']?></td>
                <td><?php echo $rown['username']?></td>
                <td><?php echo $rown['batch']?></td>
                <td><?php echo $rown['subject']?></td>
                <td><?php echo $rown['complaint']?></td>
                <td><?php echo $rown['dateofcomp']?></td>
                <td><?php echo $rown['reply']?></td>
                <td><?php echo $rown['dateofreply']?></td>
                 <td><?php
                     if($rown['replyed']=='1'){?>
                         <a href="reply.php?complaintid=<?php echo $id_get?>">See Replied</a>
                    <?php }else{?><a href="reply.php?complaintid=<?php echo $id_get?>">Reply</a> </td>
                <?php } ?>
                </tr>
            <?php } ?>
            </table>
        </div>

    <?php }
?>
</body>
    </html>
    <?php
}else{
    ?>
    <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
    <h1 align="center"><a href="../../logout.php">Logout</a> </h1>
    <?php
}
}else{
    header("Location: ../../index.php");
}

?>