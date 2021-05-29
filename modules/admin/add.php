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
<h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
<h2 align="center" style="color: blue"><?php echo "Admin" ?></h2>
<body>
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
            <a href="add.php?addbatch=true" class="linking">Add Batch</a>
            <a href="add.php?addtimetable=true" class="linking">Add TimeTable</a>
            <a href="add.php?assignbatches=true" class="linking">Assign Teachers To Batch</a>
            <a href="downloadstudent.php" class="linking">Download Excel</a>
            
        </div>

        <?php
            if(isset($_GET['addbatch'])){ ?>
                <div align="center">
                    <form method="post">
                        <b>Batch: </b><input type="text" name="batch" placeholder="Enter Batch">
                        <br><b>Timings: </b><input type="text" name="timings" placeholder="Enter Batch timings">
                        <br>Select Class:<select name="class">
                            <option value="Select class">Select Class</option>
                            <option value=6>6</option>
                            <option value=7>7</option>
                            <option value=8>8</option>
                            <option value=9>9</option>
                            <option value=10>10</option>
                        </select>
                        <br><input type="submit" name="batchadd">
                    </form>
                </div>

          <?php
                if(isset($_POST['batchadd'])){
                    $batch_get = mysqli_real_escape_string($conn,$_POST['batch']);
                    $timings_get = mysqli_real_escape_string($conn,$_POST['timings']);
                    $class_get = mysqli_real_escape_string($conn,$_POST['class']);
                    $sql_select_batch = "SELECT batch FROM batches WHERE batch='$batch_get'";
                    $sql_select_batch_query =mysqli_query($conn,$sql_select_batch);
                    $sql_select_batch_query_chekc = mysqli_num_rows($sql_select_batch_query);
                    if($sql_select_batch_query_chekc>0)
                    {
                        echo '<script>alert("Batch Already exists")</script>';
                    }else{
                        $sql_insert_into_batch = "INSERT INTO batches (batch,timings,year,class) VALUES ('$batch_get','$timings_get','2021','$class_get')";
                        $sql_insert_into_batch_query = mysqli_query($conn,$sql_insert_into_batch);
                        if($sql_insert_into_batch_query){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="add.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="add.php"</script>';
                        }
                    }
                }

            }

            if(isset($_GET['addtimetable'])){ ?>
                <div align="center">
                    <form method="post">
                        Subject:<input type="text" name="subject" placeholder="Enter Subject">
                        Timings:<input type="text" name="timings" placeholder="Enter Timing of Class">
                        <br>Day:<select name="day">
                            <option value="Select Day">Select Day</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                        </select>
                        Batch: <select name="batch">
                            <option value="none">Select Batch</option>
                        <?php
                        $sql_get_batch = "SELECT * FROM batches";
                        $sql_get_batch_query = mysqli_query($conn,$sql_get_batch);
                        while ($get_batch_name = mysqli_fetch_assoc($sql_get_batch_query)){ ?>
                            <option value="<?php echo $get_batch_name['batch']; ?>"><?php echo $get_batch_name['batch']; ?></option>
                        <?php }
                        ?>
                        </select>
                        Teacher:<select name="teacher">
                            <option value="none">Select Teacher</option>
                            <?php
                                $get_teacher = "SELECT eid,fname FROM teachers where position='Teacher' order by eid";
                                $get_teacher_query = mysqli_query($conn,$get_teacher);
                                while ($get_teacher_values = mysqli_fetch_assoc($get_teacher_query)){ ?>
                                    <option value="<?php echo $get_teacher_values['eid']?>"><?php echo $get_teacher_values['fname'] ?></option>
                                <?php }
                            ?>
                        </select>
                        <br><input type="submit" name="inserttimetable" value="Add Time Table">
                    </form>
                </div>
            <?php
                if(isset($_POST['inserttimetable'])){
                 $get_batch = mysqli_real_escape_string($conn,$_POST['batch']);
                 $get_timings = $_POST['timings'];
                 $get_day = $_POST['day'];
                 $get_subject = $_POST['subject'];
                 $get_teacher_eid = $_POST['teacher'];

                 $sql_check = "SELECT * FROM timetable WHERE batch='$get_batch' AND timing='$get_timings' AND day='$get_day' AND subject='$get_subject' AND eid='$get_teacher_eid'";
                 $sql_check_query = mysqli_query($conn,$sql_check);
                 $sq_get_result = mysqli_num_rows($sql_check_query);
                 if($sq_get_result>0){
                     echo '<script>alert("Time Table Already exists")</script>';
                 }else{
                     $sqli_insert = "INSERT INTO timetable(batch, subject, timing, eid, day, year) VALUES ('$get_batch','$get_subject','$get_timings','$get_teacher_eid','$get_day','2018')";
                     $sqli_insert_check = mysqli_query($conn,$sqli_insert);
                     if($sqli_insert_check ){
                         echo '<script>alert("Successfully done")</script>';
                         echo '<script>location.href="add.php"</script>';
                     }else{
                         echo '<script>alert("Something went wrong")</script>';
                         echo '<script>location.href="add.php"</script>';
                     }
                 }
                }
            }


            if(isset($_GET['assignbatches'])){
        ?>
                <div align="center">
                    <h3>Assign Teachers to batch</h3>
                    <form method="post">
                    Batch:<input type="text" name="batch" placeholder="Enter Batch">
                    Teacher EID: <input type="text" name="teacher_eid" placeholder="Enter Teacher EID"><br>
                    Subject : <input type="text" name="teacher_subject" placeholder="Enter Subject">
                    <input type="submit" name="AssignBatch" value="Assign Batch">
                    </form>
                </div>
                <?php
                if(isset($_POST['AssignBatch'])){
                    $get_batch_for_teacher = $_POST['batch'];
                    $get_eid_for_teacher = $_POST['teacher_eid'];
                    $get_subject_for_teacher = $_POST['teacher_subject'];

                    $sql_check_batch = "SELECT * FROM tea_batche WHERE batch='$get_batch_for_teacher' AND eid='$get_eid_for_teacher' AND subject='$get_subject_for_teacher'";
                    $sql_check_batch_query = mysqli_query($conn,$sql_check_batch);
                    $get = mysqli_num_rows($sql_check_batch_query);
                    if($get>0)
                    {
                        echo '<script>alert("Already exists")</script>';
                    }else{
                        $insert_into_tea_batch = "INSERT INTO tea_batche(batch, eid, subject) VALUES ('$get_batch_for_teacher','$get_eid_for_teacher','$get_subject_for_teacher')";
                        $insert_into_tea_batch_q = mysqli_query($conn,$insert_into_tea_batch);
                        if($insert_into_tea_batch_q ){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="add.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="add.php"</script>';
                        }
                    }
                }
            }

        ?>
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