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
if(isset($_GET['res'])) {
    if ($_GET['res'] == 'success') {
        echo '<script>alert("Successfully done")</script>';
    }
    if ($_GET['res'] == 'fail') {
        echo '<script>alert("Failed Try Again")</script>';
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
    <a href="student.php?addstudent=true" class="linking">Add Student</a>
    <a href="student.php?updatestudent=true" class="linking">Update Student</a>
    <a href="student.php?studentfees=true" class="linking">Student Fees</a>
    <a href="downloadstudent.php" class="linking">Download Student Excel</a>
    
</div>

<?php if(isset($_GET['addstudent']) OR isset($_GET['batch'])) { ?>
    <div align="center">
        <h4>Select Batch(in which you want to add student)</h4>
        <form method="get" action="student.php">
            Batch: <select name="batch">
                     <option value="none">Select Batch</option>
                <?php
                $sql_get_batch = "SELECT * FROM batches";
                $sql_get_batch_query = mysqli_query($conn, $sql_get_batch);
                while ($rom = mysqli_fetch_assoc($sql_get_batch_query)) { ?>
                    <option value="<?php echo $rom['batch'] ?>"><?php echo $rom['batch'] ?></option>
                <?php }
                ?></select>
            <input type="submit" name="submit">
        </form>

    </div>
    <?php if (isset($_GET['submit'])) {
        if ($_GET['batch'] != 'none') {
            $batch_get = mysqli_real_escape_string($conn, $_GET['batch']);
            $get_mentorandtiming = "SELECT * FROM batches WHERE batch='$batch_get'";
            $get_mentorandtiming_check = mysqli_query($conn, $get_mentorandtiming);
            $get = mysqli_fetch_assoc($get_mentorandtiming_check);
            $get_timing = $get['timings'];
            $get_class=$get['class'];

            $sql = "SELECT sid,pid FROM students ORDER BY id DESC LIMIT 1";
            $sql_q = mysqli_query($conn, $sql);
            $ro = mysqli_fetch_assoc($sql_q);
            $sid = $ro['sid'];
            $pid = $ro['pid'];
            function increment($sid)
            {
                return ++$sid[1];
            }

            $sid = preg_replace_callback("|(\d+)|", "increment", $sid);
            function incrementp($pid)
            {
                return ++$pid[1];
            }

            $pid = preg_replace_callback("|(\d+)|", "incrementp", $pid);
            ?>
            <div align="center">
                <h3>Add Student</h3>
                <form method="post">
                    <b>SID:</b> <input type="text" name="sid" value="<?php echo $sid; ?>" disabled>
                    &nbsp;&nbsp;<b>PID:</b> <input type="text" name="pid" value="<?php echo $pid; ?>" disabled><br>
                    <b>Fname:</b> <input type="text" name="fname" placeholder="First Name">
                    &nbsp;&nbsp;<b>Lname:</b> <input type="text" name="lname" placeholder="Last Name">
                    <br><b>Email:</b> <input type="email" name="email" placeholder="Email">
                    &nbsp;&nbsp;<b>Mobile:</b> <input type="text" name="mobile" placeholder="Mobile"><br>
                    <b>Address:</b> <input type="text" name="address" placeholder="Address">
                    &nbsp;&nbsp;<b>City:</b> <input type="text" name="city" placeholder="City">
                    <br><b>Division:</b> <input type="text" name="state" placeholder="Division">
                    &nbsp;&nbsp;<b>Pin code:</b> <input type="text" name="postalcode" placeholder="Pin Code"><br>
                    <b>Date Of Reg:</b> <input type="date" name="dateofreg">
                    <hr width="80%">
                    <br><b>Fees:</b> <input type="text" name="fees" placeholder="Total Fees">
                    &nbsp;&nbsp;<b>Paid Fees:</b> <input type="text" name="paidfee" placeholder="Paid Fees">
                    <br>
                    &nbsp;&nbsp;<b>Batch:</b> <input type="text" name="batch" value="<?php echo ucfirst($batch_get); ?>"
                                                     disabled>
                    <br><b>Class:</b> <input type="text" name="class" value="<?php echo $get_class; ?>" disabled>
                    <hr width="80%">
                    <b>Father's Name:</b> <input type="text" name="fathername" placeholder="Father's Name">
                    &nbsp;&nbsp;<b>Occupation: </b><input type="text" name="fatheroccu"
                                                          placeholder="Father's Occupation">
                    &nbsp;&nbsp;<b>Mobile Number:</b> <input type="text" name="fathermob"
                                                             placeholder="Father's Mobile Number">
                    <br><b>Mother's Name:</b> <input type="text" name="mothername" placeholder="Mother's Name">
                    &nbsp;&nbsp;<b>Occupation: </b><input type="text" name="motheroccu"
                                                          placeholder="Mother's Occupation">
                    &nbsp;&nbsp;<b>Mobile Number:</b> <input type="text" name="mothermob"
                                                             placeholder="Mother's Mobile Number">
                    <br><br><input type="submit" name="add">
                </form>
            </div>
            <?php
            if (isset($_POST['add'])) {
                $st_fname = $_POST['fname'];
                $st_lname = $_POST['lname'];
                $st_email = $_POST['email'];
                $st_mobile = $_POST['mobile'];
                $st_address = $_POST['address'];
                $st_city = $_POST['city'];
                $st_state = $_POST['state'];
                $st_pin = $_POST['postalcode'];
                $st_fee = $_POST['fees'];
                $st_dateofreg = $_POST['dateofreg'];
                $paid_fee = $_POST['paidfee'];
                $st_class = $get_class;
                $st_fathername = $_POST['fathername'];
                $st_fatheroccu = $_POST['fatheroccu'];
                $st_fathermob = $_POST['fathermob'];
                $st_mothername = $_POST['mothername'];
                $st_motheroccu = $_POST['motheroccu'];
                $st_mothermob = $_POST['mothermob'];
                $payment_date=null;
                if ($paid_fee>0){
                    $payment_date=date("Y-m-d");
                }
                $sql_get_insert = "INSERT INTO students(sid, fname, lname, email, phone, address, district, state, postalcode, fee, paidfee, status, batch, class, fathername, fathermob, fatheroccu, mothername, mothermob, motheroccu, timing, dateofreg, pid, dateofleft,payment_date) 
                VALUES ('$sid','$st_fname','$st_lname','$st_email','$st_mobile','$st_address','$st_city','$st_state','$st_pin','$st_fee','$paid_fee','yes','$batch_get','$st_class','$st_fathername','$st_fathermob','$st_fatheroccu','$st_mothername','$st_mothermob','$st_motheroccu','$get_timing','$st_dateofreg','$pid','0000-00-00','$payment_date')";
                $sql_get_insert_quary= mysqli_query($conn, $sql_get_insert);
                $insert_into_users = "INSERT INTO users (username, password, type) VALUES ('$sid','$sid','student')";
                $insert_into_users_check = mysqli_query($conn,$insert_into_users);
                $insert_into_users_p = "INSERT INTO users (username, password, type) VALUES ('$pid','$pid','parent')";
                $insert_into_users_check_p = mysqli_query($conn,$insert_into_users_p);
                if ($sql_get_insert_quary AND $insert_into_users_check AND $insert_into_users_check_p) {
                    echo '<script>location.href="student.php?res=success"</script>';
                } else {
                    echo '<script>location.href="student.php?res=fail"</script>';
                }
            }
        }else{
            echo '<script>alert("Please Select batch")</script>';
        }
    }
}
if(isset($_GET['updatestudent']) OR isset($_GET['studentid'])){?>
    <div align="center">
        <form method="get">
            Student Id (SID): <input type="text" name="studentid" placeholder="Enter Student Id">
            <input type="submit" name="update">
        </form>
    </div>

<?php
if(isset($_GET['studentid'])){
    $get_studentid = mysqli_real_escape_string($conn,$_GET['studentid']);

$sql_query_search = "SELECT * FROM students WHERE sid='$get_studentid'";
$sql_query_search_result = mysqli_query($conn,$sql_query_search);
$sql_query_search_result_check = mysqli_num_rows($sql_query_search_result);
if($sql_query_search_result_check>0)
{
$rowss = mysqli_fetch_assoc($sql_query_search_result);

?>
    <div align="center">
        <h3>Update Details - <span style="color: blue"><?php echo $get_studentid?></span></h3>
        <form method="post">
            <b>SID:</b> <input type="text" name="sid" value="<?php echo $rowss['sid'];?>" disabled>
            &nbsp;&nbsp;<b>PID:</b> <input type="text" name="pid" value="<?php echo $rowss['pid']; ?>" disabled><br>
            <b>Fname:</b> <input type="text" name="fname" value="<?php echo $rowss['fname'];?>">
            &nbsp;&nbsp;<b>Lname:</b> <input type="text" name="lname" value="<?php echo $rowss['lname']; ?>">
            <br><b>Email:</b> <input type="email" name="email" value="<?php echo $rowss['email']; ?>">
            &nbsp;&nbsp;<b>Mobile:</b> <input type="text" name="mobile" value="<?php echo $rowss['phone']; ?>"><br>
            <b>Address:</b> <input type="text" name="address" value="<?php echo $rowss['address']; ?>">
            &nbsp;&nbsp;<b>City:</b> <input type="text" name="city" value="<?php echo $rowss['district']; ?>">
            <br><b>Division:</b> <input type="text" name="state" value="<?php echo $rowss['state']?>">
            &nbsp;&nbsp;<b>Pin code:</b> <input type="text" name="postalcode" value="<?php echo $rowss['postalcode']; ?>">
            <br><b>Fees:</b> <input type="text" name="fees" value="<?php echo $rowss['fee']; ?>" disabled>
            &nbsp;&nbsp;<b>Paid Fees:</b> <input type="text" name="paidfee" value="<?php echo $rowss['paidfee']?>" disabled>
            &nbsp;&nbsp;<b>Batch:</b> <input type="text" name="batch" value="<?php echo $rowss['batch']?>" disabled>
            <br><b>Class:</b> <input type="text" name="class" value="<?php echo $rowss['class']?>">
            <br><b>Father's Name:</b> <input type="text" name="fathername" value="<?php echo $rowss['fathername']?>">
            &nbsp;&nbsp;<b>Occupation: </b><input type="text" name="fatheroccu" value="<?php echo $rowss['fatheroccu']?>">
            &nbsp;&nbsp;<b>Mobile Number:</b> <input type="text" name="fathermob" value="<?php echo $rowss['fathermob']?>">
            <br><b>Mother's Name:</b> <input type="text" name="mothername" value="<?php echo $rowss['mothername']?>">
            &nbsp;&nbsp;<b>Occupation: </b><input type="text" name="motheroccu" value="<?php echo $rowss['motheroccu']?>">
            &nbsp;&nbsp;<b>Mobile Number:</b> <input type="text" name="mothermob" value="<?php echo $rowss['mothermob']?>">
            <br><br><input type="submit" name="update">
        </form>
        <br><a href="student.php?res=fail"><button>Cancel</button></a>

    </div>

<?php
if(isset($_POST['update'])){
    $st_fname = $_POST['fname'];
    $st_lname = $_POST['lname'];
    $st_email = $_POST['email'];
    $st_mobile = $_POST['mobile'];
    $st_address = $_POST['address'];
    $st_city = $_POST['city'];
    $st_state = $_POST['state'];
    $st_pin = $_POST['postalcode'];
    $st_class = $_POST['class'];
    $st_fathername = $_POST['fathername'];
    $st_fatheroccu = $_POST['fatheroccu'];
    $st_fathermob = $_POST['fathermob'];
    $st_mothername = $_POST['mothername'];
    $st_motheroccu = $_POST['motheroccu'];
    $st_mothermob = $_POST['mothermob'];

    $sql_q_update = "UPDATE students SET fname='$st_fname',lname='$st_lname',email='$st_email',phone='$st_mobile',address='$st_address',district='$st_city',state='$st_state',postalcode='$st_pin',class='$st_class',fathername='$st_fathername',fathermob='$st_fathermob',fatheroccu='$st_fatheroccu',mothername='$st_mothername',mothermob='$st_mothermob',motheroccu='$st_motheroccu' WHERE sid='$get_studentid'";
    $sql_q_update_query = mysqli_query($conn, $sql_q_update);
    if($sql_q_update_query){
        echo '<script>location.href="student.php?res=success"</script>';
    }else{
        echo '<script>location.href="student.php?res=fail"</script>';
    }

}

}
}
}?>
<?php if(isset($_GET['studentfees'])){?>
<div style="padding-left:20px; float: left;border-left: 6px solid red;background-color: lightgrey;width: 100%;">
        <h1 align="center">Fees - <span style="color: blue"><?php echo $fname.' '.$lname; ?></span></h1>
        <table border="2" align="center" cellpadding="5px">
            <tr>
                <th>SID</th>
                <th>Batch</th>
                <th>Total Fees</th>
                <th>Total Fee To Pay</th>
                <th>Total Paid Fees</th>
                <th>Fees To Pay</th>
            </tr>
            <?php
                $sqli = "SELECT * FROM students";
            $resulti = mysqli_query($conn, $sqli);
            $resultchecki = mysqli_num_rows($resulti);
            while ($rows = mysqli_fetch_assoc($resulti)) {
                $sid = $rows['sid'];
                $batch = $rows['batch'];
                $fees = $rows['fee'];
                $paid_fees = $rows['paidfee'];
                $newfee = $fees;
                $user_status="SELECT status from users where username='$sid'";
                $user_status_query=mysqli_query($conn,$user_status);
                $status=mysqli_fetch_assoc($user_status_query);
                ?>
                <tr align="center">
                    <td><?php echo strtoupper($sid); ?></td>
                    <td><?php echo ucfirst($batch); ?></td>
                    <td><?php echo $fees; ?></td>
                    <td><?php echo $newfee; ?></td>
                    <td><?php echo $paid_fees ?></td>
                   
                    <td> <form method="POST">
                    <?php if($status['status']=='Yes'){
                        echo '<input type="submit" value="Ban" name="ban" style="color: red">
                        <input type="hidden" value="'.$sid.'" name="sid">';}

                    else{
                         echo '<input type="submit" value="Unban" name="unban" style="color: red">
                         <input type="hidden" value="'.$sid.'" name="sid">';
                    }
                    ?>
                    </form>
                    </td>
                </tr>
            <?php } ?>
            <?php
if(isset($_POST['ban'])){
    $s=$_POST['sid'];
    $user_ban="UPDATE users set status='No' where username='$s'";
    $user_ban_query=mysqli_query($conn,$user_ban);
    if($user_ban_query){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="student.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="student.php"</script>';
                        }
}
if(isset($_POST['unban'])){
    $s=$_POST['sid'];
    $user_unban="UPDATE users set status='Yes' where username='$s'";
    $user_unban_query=mysqli_query($conn,$user_unban);
    if($user_unban_query){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="student.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="student.php"</script>';
                        }
}
?>
        </table><?php }?>
</div>

</body>
    </html>
    <?php
}

}else{
    header("Location: ../../index.php");
}

?>