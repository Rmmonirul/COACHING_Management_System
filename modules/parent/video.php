<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../config/database.php");
    $id = $_SESSION['id'];
    $pid = $_SESSION['username'];
    $sql = "SELECT * FROM students WHERE pid = '$pid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    if($row = mysqli_fetch_assoc($result)){
        $fname= ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        $batch = $row['batch'];
        $status = $row['status'];
    }
    if($status == 'yes' || $status == 'Yes') {
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
        
        <source src="../admin/videos/<?php  echo $name; ?>" 
                type="video/mp4">

    </video>
    <?php
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