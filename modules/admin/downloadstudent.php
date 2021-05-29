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
    $sql_get_complaint = "SELECT * FROM students";
    $sql_get_complaint_check = mysqli_query($conn,$sql_get_complaint);
    $sql_get_complaint_check_result = mysqli_num_rows($sql_get_complaint_check);
    if($sql_get_complaint_check_result>0){
        ?>
        <div align="center">
            <h4>Students</h4>
            <table border="2px">
                <tr>
                    <th>Sid</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Student Phone Number</th>
                    <th>Address</th>
                    <th>District</th>
                    <th>State</th>
                    <th>Postcode</th>
                    <th>Fee</th>
                    <th>paid Fee</th>
                    <th>Status</th>
                    <th>Batch</th>
                    <th>Class</th>
                    <th>Father Name</th>
                    <th>Father Phone Number</th>
                    <th>father Occupation</th>
                    <th>Mother Name</th>
                    <th>Mother Phone Number</th>
                    <th>Mother Occupation</th>
                    <th>Date Of Reg</th>
                    <th>Pyment Date</th> 
                </tr>
            <?php while($rown = mysqli_fetch_assoc($sql_get_complaint_check)){
                    $id_get = $rown['id'];
                ?>
                <tr align="center">
                <td><?php echo $rown['sid']?></td>
                <td><?php echo $rown['fname']?></td>
                <td><?php echo $rown['lname']?></td>
                <td><?php echo $rown['email']?></td>
                <td><?php echo $rown['phone']?></td>
                <td><?php echo $rown['address']?></td>
                <td><?php echo $rown['district']?></td>
                <td><?php echo $rown['state']?></td>
                <td><?php echo $rown['postalcode']?></td>
                <td><?php echo $rown['fee']?></td>
                <td><?php echo $rown['paidfee']?></td>
                <td><?php echo $rown['status']?></td>
                <td><?php echo $rown['batch']?></td>
                <td><?php echo $rown['class']?></td>
                <td><?php echo $rown['fathername']?></td>
                <td><?php echo $rown['fathermob']?></td>
                <td><?php echo $rown['fatheroccu']?></td>
                <td><?php echo $rown['mothername']?></td>
                <td><?php echo $rown['mothermob']?></td>
                <td><?php echo $rown['motheroccu']?></td>
                <td><?php echo $rown['dateofreg']?></td>
                <td><?php echo $rown['payment_date']?></td>
               


                </tr>
            <?php } ?>
            </table>
        <?php }
        }
    
    ?>