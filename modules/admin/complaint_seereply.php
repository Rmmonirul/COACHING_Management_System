<?php


session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    if(isset($_GET['id'])) {
include("../../config/database.php");
$idn = $_SESSION['id'];
$eid = $_SESSION['username'];
$sql = "SELECT * FROM teachers WHERE eid = '$eid'";
$result = mysqli_query($conn, $sql);
$resultcheck = mysqli_num_rows($result);
if ($row = mysqli_fetch_assoc($result)) {
    $fname = ucfirst($row['fname']);
    $lname = ucfirst($row['lname']);
}
$ydate = date('Y-m-d');
$id = (int)$_GET['id'];
$day = date("l");

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
         >
            <a href="index.php">Home</a>
            <a href="student.php">Student</a>
            <a href="studentattendance.php">Student Attendance</a>
            <a href="teachers.php">Teachers</a>
            <a href="teachersattendance.php">Teachers Attendance</a>
            <a href="add.php">Add TimeTable/batch</a>
            <a href="complaint.php">Complaint</a>
            <a href="addvideo.php">AddVideo</a>
            <a href="incomingcomplaint.php">Incoming Complaint</a>
            <a href="update_password.php">Update Password</a>
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="../../logout.php">Logout</a>
        </div>
<h2 style="color: green; background-color: lightgray;padding: 10px" align="center">Details Of Complaint</h2>
<div style=" float: left;border: 6px solid red;width: 100%;border-radius: 20px" align="center">

<?php
$sql_complaint = "SELECT * FROM complaint WHERE id = '$id' AND username = '$eid'";
$sql_complaint_result = mysqli_query($conn,$sql_complaint);
$sql_complaint_result_check = mysqli_num_rows($sql_complaint_result);
if($sql_complaint_result_check>0) {
    while ($complaint_rows = mysqli_fetch_assoc($sql_complaint_result)) {
        ?>
        <h3><i class="show">Id No.-</i><?php echo $id; ?> &nbsp;&nbsp;<i class="show">EID-</i><?php echo $complaint_rows['username']; ?></h3><hr>
        <h3><i class="show">Teacher-</i><?php echo ucfirst($complaint_rows['teacher_type']); ?> &nbsp;&nbsp;<i class="show">Admin EID-</i><?php echo $complaint_rows['eid']; ?></h3>
        <hr><h3><i class="show">Date Of Complaint-</i><?php echo $complaint_rows['dateofcomp']; ?></h3>
        <hr><h3><i class="show">Subject-</i><?php echo ucfirst($complaint_rows['subject']); ?></h3>
        <hr><h3><i class="show">Complaint</i></h3>
        <h3><?php echo ucfirst($complaint_rows['complaint']); ?></h3>
        <hr>
        <?php
        if ($complaint_rows['dateofreply'] == '0000-00-00') {
            ?>
            <h3><i class="reply"> There is no reply by <?php echo ucfirst($complaint_rows['teacher_type']); ?> </i></h3>
        <?php } else { ?>
            <h3><i class="show">Date Of Reply-</i><?php echo $complaint_rows['dateofreply']; ?></h3>
            <hr> <h3><i class="show">Reply by <?php echo ucfirst($complaint_rows['teacher_type']); ?></i></h3>
            <h3><?php echo ucfirst($complaint_rows['reply']); ?></h3><hr>
            <?php
        }
    }
}else{
    echo 'some thing went wrong contact to Sadmin';
}
?>
</div>

        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>

        <style>
            .show{
                color: blue;
                font-size: 25px;
            }

            .reply{
                color: red;
                font-size: 25px;
            }

            hr{
                background-color: green;
                height: 5px;
            }
        </style>
        </body>

        </html>
        <?php
    }else{
        header("Location: complaint.php");
    }
        }else{
            header("Location: ../../index.php");
        }
?>
