<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../config/database.php");
    $id = $_SESSION['id'];
    $pid = $_SESSION['username'];
    $sql = "SELECT * FROM students WHERE sid = (SELECT sid FROM students WHERE pid = '$pid')";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    if ($row = mysqli_fetch_assoc($result)) {
        $fname = ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        $batch = $row['batch'];
    }
    $ydate = date('Y-m-d');
    ?>
    <!DOCTYPE html>
    <html>
       <head>
            
            <title>Parents-OCTH</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">       
            <link rel="stylesheet" href="../../css/bootstrap.min.css" />
             <script src="../../js/jquery-3.3.1.min.js"></script>
            <script src="../../js/bootstrap.min.js"></script>
        </head>
        <body>
        <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
<h2 align="center" style="color: blue"><?php echo "Parent" ?></h2>
        <div class="header">
            <a href="index.php">Home</a>
            <a href="marks.php">Marks</a>
            <a href="fees.php">Fees</a>
            <a href="video.php">Videos</a>
            <a href="password_update.php">Update Password</a>
            <a href="../../logout.php">Logout</a>
        </div>
    <div style="padding-left:20px; float: left;border-left: 6px solid red;background-color: lightgrey;width: 100%">
        <h1 align="center">Attendance - <span style="color: blue"><?php echo $fname.' '.$lname; ?></span></h1>

        <table border="2" align="center" cellpadding="5px">
            <tr>
                <th>S.NO.</th>
                <th>Subject</th>
                <th>Timing</th>
                <th>Date</th>
                <th>Status</th>
                <th>Teacher</th>
                <th>Teacher ID (EID)</th>
            </tr>
            <?php
            $sqli = "SELECT * FROM attendance WHERE batch = '$batch' AND sid=(SELECT sid FROM students WHERE pid = '$pid')";
            $resulti = mysqli_query($conn, $sqli);
            $resultchecki = mysqli_num_rows($resulti);
            $i = 0;
            while ($rows = mysqli_fetch_assoc($resulti)) {
                $i++;
                $subject = $rows['subject'];
                $timing = $rows['timing'];
                $status = $rows['status'];
                $date=$rows['date'];
                $eid = $rows['eid'];
                if ($status == 'p' OR $status == 'P') {
                    $status = "Present";
                    $color = "#d3d3d3";
                    $textcolor = "green";
                } else if ($status == 'a' OR $status == 'A') {
                    $status = "Absent";
                    $color = "red";
                    $textcolor = "white";
                }
                $sql_teacher = "SELECT * FROM teachers WHERE eid = '$eid'";
                $sql_result = mysqli_query($conn, $sql_teacher);
                $sql_result_teacher = mysqli_num_rows($sql_result);
                while ($rowsn = mysqli_fetch_assoc($sql_result)) {
                    $teacherfname = $rowsn['fname'];
                    $teacherlname = $rowsn['lname'];

                }

                ?>
                <tr style="background-color:<?php echo $color; ?>;color: <?php echo $textcolor; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo ucfirst($subject); ?></td>
                    <td><?php echo $timing; ?></td>
                    <td><?php echo $date; ?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php echo $teacherfname . ' ' . $teacherlname ?></td>
                    <td><?php echo ucfirst($eid); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
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
    header("Location: ../../index.php");
}
?>