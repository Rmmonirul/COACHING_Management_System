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
        $subject=$row['subject'];
    }
    if($status == 'yes' || $status == 'Yes') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Admin</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
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
        <h2 align="center" style="color: blue"><?php echo "Teacher" ?></h2>

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
        <div align="center" style="background-color: aquamarine;padding: 10px">
            <a href="addexamandnotice.php?addexam=true" class="linking">Add Exam</a>
            <a href="addexamandnotice.php?addnotice=true" class="linking">Add Notice</a>
        </div>

        <?php
            if(isset($_GET['addexam'])){ ?>
                <div align="center">
                    <form method="post">
                        <b>Exam Name: </b><input type="text" name="examname" placeholder="Enter exam name">
                        <b>Batch:</b> <select name="batch">
                            <option value="none">Select Batch</option>
                        <?php
                        $sql_get_batch = "SELECT * FROM batches";
                        $sql_get_batch_query = mysqli_query($conn,$sql_get_batch);
                        while ($get_batch_name = mysqli_fetch_assoc($sql_get_batch_query)){ ?>
                            <option value="<?php echo $get_batch_name['batch']; ?>"><?php echo $get_batch_name['batch']; ?></option>
                        <?php }
                        ?>
                        </select>
                        <br><b>Timing:</b><input type="date" id="birthday" name="timings" placeholder="Enter Exam Date">
                        <br><input type="submit" name="examadd">
                    </form>
                </div>

          <?php
                if(isset($_POST['examadd'])){
                    $batch_get = mysqli_real_escape_string($conn,$_POST['batch']);
                    $timings_get = mysqli_real_escape_string($conn,$_POST['timings']);
                    $examname_get = mysqli_real_escape_string($conn,$_POST['examname']);
                    $sql_select_batch = "SELECT dateofexam FROM exams WHERE batch='$batch_get' and dateofexam='$timings_get'";
                    $sql_select_batch_query =mysqli_query($conn,$sql_select_batch);
                    $sql_select_batch_query_chekc = mysqli_num_rows($sql_select_batch_query);
                    if($sql_select_batch_query_chekc>0)
                    {
                        echo '<script>alert("Exam Already exists")</script>';
                    }else{
                        $sql_insert_into_batch = "INSERT INTO exams (examname,batch,dateofexam) VALUES ('$examname_get','$batch_get','$timings_get')";
                        $sql_insert_into_batch_query = mysqli_query($conn,$sql_insert_into_batch);
                        if($sql_insert_into_batch_query){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="addexamandnotice.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="addexamandnotice.php"</script>';
                        }
                    }
                }

            }
            ?>
            <?php
            if(isset($_GET['addnotice'])){ ?>
                <div align="center">
                    <form method="post">
                        <b>Batch:</b> <select name="batch" required>
                            <option value="none">Select Batch</option>
                        <?php
                        $sql_get_batch = "SELECT * FROM batches";
                        $sql_get_batch_query = mysqli_query($conn,$sql_get_batch);
                        while ($get_batch_name = mysqli_fetch_assoc($sql_get_batch_query)){ ?>
                            <option value="<?php echo $get_batch_name['batch']; ?>"><?php echo $get_batch_name['batch']; ?></option>
                        <?php }
                        ?>
                        </select>
                        <b>Notice: </b><input type="text" name="notice" placeholder="Enter notice here" required>
                        <br><b>Subject:</b><input type="text" value="<?php echo $subject; ?>" name="subject" placeholder="Enter Exam Date" disabled>
                        <br><input type="submit" name="noticeadd">
                    </form>
                </div>

          <?php
                if(isset($_POST['noticeadd'])){
                    $batch_get = mysqli_real_escape_string($conn,$_POST['batch']);
                    $notice_get = mysqli_real_escape_string($conn,$_POST['notice']);
                    $notice_date=date("Y-m-d");
                    echo $batch_get.$notice_get;
                        $sql_insert_into_batch = "INSERT INTO notices (batch,notice,subject,notice_date) VALUES ('$batch_get','$notice_get','$subject','$notice_date')";
                        $sql_insert_into_batch_query = mysqli_query($conn,$sql_insert_into_batch);
                        if($sql_insert_into_batch_query){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="addexamandnotice.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="addexamandnotice .php"</script>';
                        }
                }

            }
            ?>
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
    header("Location: ../../../index.php");
}

?>