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
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=monirul.com.xls");
    $sql_get_complaint = "SELECT * FROM complaint WHERE teacher_type='admin' OR teacher_type='Admin' ORDER BY  dateofcomp";
    $sql_get_complaint_check = mysqli_query($conn,$sql_get_complaint);
    $sql_get_complaint_check_result = mysqli_num_rows($sql_get_complaint_check);
    if($sql_get_complaint_check_result>0){
        ?>
        <div align="center">
            <h4>Incoming Complaints</h4>
            <table border="2px">
                <tr>
                <tr><th>Teacher Id</th>
                    <th>Username</th>
                    <th>Batch</th>
                    <th>Subject</th>
                    <th>Complaint</th>
                    <th>Date Of Complaint</th>
                    <th>Reply</th>
                    <th>Date Of Reply</th>
                    <th>status</th>
                </tr>
            <?php while($rown = mysqli_fetch_assoc($sql_get_complaint_check)){
                    $id_get = $rown['id'];
                ?>
                <tr align="center">
                <td><?php echo $rown['eid']?></td>
                <td><?php echo $rown['username']?></td>
                <td><?php echo $rown['batch']?></td>
                <td><?php echo $rown['subject']?></td>
                <td><?php echo $rown['complaint']?></td>
                <td><?php echo $rown['dateofcomp']?></td>
                <td><?php echo $rown['reply']?></td>
                <td><?php echo $rown['dateofreply']?></td>
                </tr>
            <?php } ?>
            </table>
        <?php }
        }
    
    ?>