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
        <div align='center'>
        <form  method="post"  
enctype="multipart/form-data">
<input type="file" name="file" />
<input type="submit" value="UPLOAD" name="upload" />

</form>
        </div>

<?php

if (isset($_POST['upload'])){

$name = $_FILES['file']['name'];

$tmp = $_FILES['file']['tmp_name'];

$exist="SELECT * from videos where name='$name'";
$q =  mysqli_query($conn, $exist);
$re = mysqli_num_rows($q);
if ($re>=1){
     echo "<div align='center'><h1> Video file already exists </h1></div>";
}
else{
move_uploaded_file($tmp,"videos/" . $name);

$sql = "INSERT INTO videos (name) VALUES ('$name')";

$res =  mysqli_query($conn, $sql);

if ($res == 1){

    echo "<div align='center'><h1> video inserted successfully </h1></div>";
}
}

}
?>
<?php

$sql = "select * from videos";

$res = mysqli_query($conn,$sql);

echo "<h1>Class Videos</h1>";
while ($row = mysqli_fetch_assoc($res)) {
    
    $id = $row['id'];
    $name = $row['name'];

    echo  "<h4><a href='watch.php?id=$id' > ". $name . 
          "</a></h4>";
    ?>
    <video width="600" height="316" controls>
        
        <source src="videos/<?php  echo $name; ?>" 
                type="video/mp4">
    </video>
    <form method="post" action="">
        <input type="submit" name="delete" color="red" value="Delete"/>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
      </form>
    <?php
}
?>
<?php 
if(isset($_POST['delete'])){
        $del_id=$_POST['id'];
        $delete_video="DELETE FROM videos where id='$del_id'";
        $del =  mysqli_query($conn, $delete_video);
         if($del){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="addvideo.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="addvideo.php"</script>';
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