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
    $sql_get_complaint = "SELECT * FROM teachers";
    $sql_get_complaint_check = mysqli_query($conn,$sql_get_complaint);
    $sql_get_complaint_check_result = mysqli_num_rows($sql_get_complaint_check);
    if($sql_get_complaint_check_result>0){
        ?>
        <div align="center">
            <h4>Teachers</h4>
            <table border="2px">
                <tr>
                    <th>Tid</th>
                    <th>First Name</th>
                    <th>last Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Postalcode</th>
                    <th>Salary</th>
                    <th>Position</th>
                    <th>Subject</th>
                    <th>date Of joining</th>
                    <th>Experience</th>
                    <th>Highest Qualification</th>
                    <th>Highest Qualification Marks</th>

                </tr>
            <?php while($rown = mysqli_fetch_assoc($sql_get_complaint_check)){
                    $id_get = $rown['id'];
                ?>
                <tr align="center">
                <td><?php echo $rown['eid']?></td>
                <td><?php echo $rown['fname']?></td>
                <td><?php echo $rown['lname']?></td>
                <td><?php echo $rown['email']?></td>
                <td><?php echo $rown['mobile']?></td>
                <td><?php echo $rown['address']?></td>
                <td><?php echo $rown['city']?></td>
                <td><?php echo $rown['state']?></td>
                <td><?php echo $rown['postalcode']?></td>
                <td><?php echo $rown['salary']?></td>
                <td><?php echo $rown['position']?></td>
                <td><?php echo $rown['subject']?></td>
                <td><?php echo $rown['dateofjoining']?></td>
                <td><?php echo $rown['experience']?></td>
                <td><?php echo $rown['highestqualification']?></td>
                <td><?php echo $rown['highestqualificationmarks']?></td>
               

                </tr>
            <?php } ?>
            </table>
        <?php }
        }
    
    ?>