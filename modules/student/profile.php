<?php
session_start();
include ("../../config/database.php");
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
$id = $_SESSION['id'];
$sid = $_SESSION['username'];
$sql_profile = "SELECT * FROM students WHERE sid = '$sid'";
$sql_profile_check = mysqli_query($conn, $sql_profile);
$sql_profile_check_result = mysqli_num_rows($sql_profile_check);
while($rows = mysqli_fetch_assoc($sql_profile_check)){
    $fname = $rows['fname'];
    $lname = $rows['lname'];
    $email = $rows['email'];
    $mobile = $rows['phone'];
    $address = $rows['address'];
    $city = $rows['district'];
    $state = $rows['state'];
    $postal_code = $rows['postalcode'];
    $fees = $rows['fee'];
    $paid_fees = $rows['paidfee'];
    $pid = $rows['pid'];
    $status = $rows['status'];
    $batch = $rows['batch'];
    $class = $rows['class'];
    $fathername = $rows['fathername'];
    $fathermob = $rows['fathermob'];
    $fatheroccu = $rows['fatheroccu'];
    $mothername = $rows['mothername'];
    $mothermob = $rows['mothermob'];
    $motheroccu = $rows['motheroccu'];
    $mentor = $rows['mentor'];
    $timing = $rows['timing'];
    $date_of_joinig = $rows['dateofreg'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $fname.' '.$lname ?>Students-OCTH</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        a{
            text-decoration: none;
        }
        a:hover{
            text-decoration: none;
        }
    </style>
</head>
<h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
<h2 align="center" style="color: blue"><?php echo "Student" ?></h2>
<body>
    <div class="header">
        <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($sid) . ")" ?></a>
        <a href="index.php">Home</a>
        <a href="attendance.php">Attendance</a>
        <a href="timetable.php">TimeTable</a>
        <a href="marks.php">Marks</a>
        <a href="notice.php">Notices</a>
        <a href="fees.php">Fees</a>
        <a href="complaint.php">Complaint</a>
        <a href="password_update.php">Update Password</a>
        <a href="../../logout.php">Logout</a>
    </div>
<div class="container">
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                <img src="images/default_pic.png" alt="stack photo" class="img">
            </div>
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                <div class="container" style="border-bottom:1px solid black">
                    <h2><?php echo $fname.' '.$lname; ?></h2>
                </div>
                <hr>
                <ul class="container details">
                    <li><p><span class="glyphicon glyphicon-ok-sign" style="width:50px;"></span><?php echo $sid.' ( PID:'.$pid.')'; ?></p></li>
                    <li><p><span class="glyphicon glyphicon-earphone one" style="width:50px;"></span><?php echo '+88 '.$mobile; ?></p></li>
                    <li><p><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span><?php echo $email; ?></p></li>
                    <li><p><span class="glyphicon glyphicon-tower" style="width:50px;"></span><?php echo $batch.' ('.strtoupper($timing).')'; ?></p></li>
                </ul>
            </div>
        </div>
    </div>
    <div align="center">
        <p><b><i>Address:</i></b><?php echo $address.', '. $city.', '.$state.', '.$postal_code ?></p>
        <p><b><i>Total Fee:</i></b><?php echo $fees; ?> &nbsp; &nbsp;<b><i>Total Fee To Pay:</i></b><?php $newfee = $fees; echo $newfee ?> &nbsp; &nbsp; <b><i>Total Paid Fees:</i></b><?php echo $paid_fees; ?> &nbsp;&nbsp; <b><i>Fees To Pay:</i></b><?php echo $newfee-$paid_fees;  ?> &nbsp; &nbsp;&nbsp;<a href="fees.php"><button>Pay</button></a></p>
        <p><b><i>Class: </i></b><?php echo $class; ?> &nbsp; &nbsp; <?php if(isset($mark10)){echo '<b><i>Class 10 Marks: </i></b>'.$mark10; } ?> &nbsp;&nbsp; <?php if(isset($mark12)){echo '<b><i>Class 12 Marks:</i></b>'.$mark12; } ?>&nbsp</p>
        <p><b><i>Father's Name: </i></b><?php echo ucfirst($fathername); ?> &nbsp;&nbsp; <b><i>Father's Occupation: </i></b><?php echo ucfirst($fatheroccu); ?> &nbsp;&nbsp; <b><i>Father's Mobile:</i></b> <?php echo '+91 '.$fathermob; ?></p>
        <p><b><i>Mother's Name: </i></b><?php echo ucfirst($mothername); ?> &nbsp;&nbsp; <b><i>Mother's Occupation: </i></b><?php echo ucfirst($motheroccu); ?> &nbsp;&nbsp; <b><i>Mother's Mobile:</i></b> <?php echo '+91 '.$mothermob; ?></p>
        <p><button onclick="showsome()">Update Details</button></p>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function showsome() {
            alert("To Update Details Kindly Contact admin.");
        }
    </script>
</body>
</html>
<?php } ?>