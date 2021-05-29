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

    $ydate =date('Y-m-d');
    if($status == 'yes' || $status == 'Yes') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>TimeTable-Teachers-OCTH</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body>
        <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
        <h2 align="center" style="color: blue"><?php echo "Teacher" ?></h2>

        <div class="header">
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="attendance.php">Attendance</a>
            <a href="search.php">Search Student Information</a>
            <a href="markattendance.php">Mark Attendance</a>
            <a href="marks.php">Marks</a>
            <a href="addexamandnotice.php">Add Exam and notice</a>
            <a href="timetable.php">TimeTable</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../../logout.php">Logout</a>
        </div>
        <div align="center" style="padding: 8px">

            <?php
            if(isset($_POST['submit'])){
                $ydate = $_POST['date'];
            }
            $timestamp = strtotime($ydate);
            $day = date('l', $timestamp);
            ?>
            <form action="timetable.php" method="post">
                <h3>Choose date (mm/dd/yyyy)</h3>
                <input type="date" name="date" value="<?php echo $ydate; ?>">
                <input type="submit" name="submit" value="submit">
            </form>
        </div>
        <div style="padding-left:20px; float: left;border-left: 6px solid red;background-color: lightgrey;width: 100%">
            <h1 align="center">Time Table</h1>
            <p align="center"><?php echo $ydate.'<br>('.$day.')' ?></p>
            <table border="2" align="center" cellpadding="5px">
                <tr>
                    <th>S.No</th>
                    <th>Timing</th>
                    <th>Subject name</th>
                    <th>Batch</th>
                </tr>

                <?php
                $sql_time = "SELECT * FROM timetable WHERE  day ='$day' AND eid = '$eid'";
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
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "250px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }
        </script>
        <style>
            input[type=date]{
                width: 15%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                margin-top: 6px;
                margin-bottom: 16px;
                resize: vertical;
            }

            input[type=submit] {
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
            }

            input[type=submit]:hover {
                background-color: #45a049;
            }


        </style>
        </body>
        </html>
        <?php
    }else{
        ?>
        <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
        <?php
    }
}else{
    header("Location: ../../../index.php");
}

?>