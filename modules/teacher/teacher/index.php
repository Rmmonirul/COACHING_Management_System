<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../../config/database.php");
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
            <title>Teachers</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body>
        <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
        <h2 align="center" style="color: blue"><?php echo "Teacher" ?></h2>>

        <div class="header">
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="attendance.php">Attendance</a>
            <a href="search.php">Search Student Information</a>
            <a href="markattendance.php">Mark Attendance</a>
            <a href="markmarks.php">Marks</a>
            <a href="addexamandnotice.php">Add Exam and notice</a>
            <a href="timetable.php">TimeTable</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../../logout.php">Logout</a>
        </div>
        <div style="padding-left:20px; float: left;border-left: 6px solid red;background-color: lightgrey;width: 50%">
            <h1 align="center">Time Table</h1>
            <p align="center"><?php echo date("d-m-Y") . '<br>(' . date("l") . ')' ?></p>
            <table border="2" align="center" cellpadding="5px">
                <tr>
                    <th>S.No</th>
                    <th>Timing</th>
                    <th>Subject name</th>
                    <th>Batch</th>
                </tr>

                <?php
                $day = date("l");
                $sql_time = "SELECT * FROM timetable WHERE day ='$day' AND eid = '$eid'";
                $sql_time_result = mysqli_query($conn, $sql_time);
                $sql_time_result_check = mysqli_num_rows($sql_time_result);
                $j = 0;
                while ($rown = mysqli_fetch_assoc($sql_time_result)){
                $j++;
                $time = $rown['timing'];
                $subject = $rown['subject'];
                $batch = $rown['batch'];

                ?>
                <tr>
                    <td><?php echo $j; ?></td>
                    <td><?php echo $time; ?></td>
                    <td><?php echo $subject ?></td>
                    <td><?php echo $batch; ?></td>

                    <?php } ?>

            </table>
        </div>
        <div style="padding-left:20px; float: left;border-left: 6px solid red;background-color: lightgrey;width: 50%">
            <h1 align="center">Attendance</h1>
            <p align="center">Yesterday's Attendane<br>(<?php $ydate = date('Y-m-d', strtotime("-1 days"));
                echo date('d-m-Y', strtotime("-1 days")); ?>) </p>

            <table border="2" align="center" cellpadding="5px">
                <tr>
                    <th>S.NO.</th>
                    <th>Time To Come</th>
                    <th>Time To Go</th>
                    <th>Status</th>
                    <th>By</th>
                    <th>By (EID)</th>
                </tr>
                <?php
                $sqli = "SELECT * FROM tea_attendance WHERE eid = '$eid' AND date = '$ydate'";
                $resulti = mysqli_query($conn, $sqli);
                $resultchecki = mysqli_num_rows($resulti);
                $i = 0;
                while ($rows = mysqli_fetch_assoc($resulti)) {
                    $i++;
                    $timetocome = $rows['timetocome'];
                    $timetogo = $rows['timetogo'];
                    $status = $rows['status'];
                    $bid = $rows['bywhom'];
                    if ($status == 'p' OR $status == 'P') {
                        $status = "Present";
                        $color = "#d3d3d3";
                        $textcolor="black";
                    } else if ($status == 'a' OR $status == 'A') {
                        $status = "Absent";
                        $color = "red";
                        $textcolor="white";
                    }
                    $sql_teacher = "SELECT * FROM teachers WHERE eid = '$bid'";
                    $sql_result = mysqli_query($conn, $sql_teacher);
                    $sql_result_teacher = mysqli_num_rows($sql_result);
                    while ($rowsn = mysqli_fetch_assoc($sql_result)) {
                        $teacherfname = $rowsn['fname'];
                        $teacherlname = $rowsn['lname'];

                    }

                    ?>
                    <tr style="background-color:<?php echo $color; ?>;color: <?php echo $textcolor; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $timetocome; ?></td>
                        <td><?php echo $timetogo; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $teacherfname . ' ' . $teacherlname ?></td>
                        <td><?php echo ucfirst($bid); ?></td>
                    </tr>
                <?php } ?>
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