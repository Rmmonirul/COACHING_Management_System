<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../config/database.php");
    $id = $_SESSION['id'];
    $sid = $_SESSION['username'];
    $sql = "SELECT * FROM students WHERE sid = '$sid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    if ($row = mysqli_fetch_assoc($result)) {
        $fname = ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        $batch = $row['batch'];
    }
    $ydate = date('Y-m-d');
    $day = date("l");
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Marks-Students-OCTH</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
    <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
<h2 align="center" style="color: blue"><?php echo "Student" ?></h2>?></h2>
     <div class="header">
        <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($sid) . ")" ?></a>
        <a href="index.php">Home</a>
        <a href="attendance.php">Attendance</a>
        <a href="timetable.php">TimeTable</a>
        <a href="marks.php">Marks</a>
        <a href="notice.php">Notices</a>
        <a href="fees.php">Fees</a>
        <a href="complaint.php">Complaint</a>
        <a href="password_update.php">Update Password</a>
        <a href="../../logout.php">Logout</a>
    </div>
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
                $sqli = "SELECT * FROM students WHERE sid = '$sid' AND batch = '$batch'";
            $resulti = mysqli_query($conn, $sqli);
            $resultchecki = mysqli_num_rows($resulti);
            while ($rows = mysqli_fetch_assoc($resulti)) {
                $batch = $rows['batch'];
                $fees = $rows['fee'];
                $paid_fees = $rows['paidfee'];
                $newfee = $fees;

                ?>
                <tr align="center">
                    <td><?php echo strtoupper($sid); ?></td>
                    <td><?php echo ucfirst($batch); ?></td>
                    <td><?php echo $fees; ?></td>
                    <td><?php echo $newfee; ?></td>
                    <td><?php echo $paid_fees ?></td>
                    <td><?php echo $newfee-$paid_fees; ?></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><a href="fees.php?fee=true" class="feepay">Pay Fees</a></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <?php
            if(isset($_GET['fee'])){ ?>
                <div align="center">
                    <form method="post">
                        <b>Card Number: </b><input type="text" name="batch" placeholder="Enter card number" required>
                        <br><b>CVC: </b><input type="text" name="cvc" placeholder="Enter cvc number" required>
                        <br><b>Enter expired date: </b><input type="date" name="date" required>
                        <br><b>Enter amount: </b><input type="text" name="amount" required>
                        <br><input type="submit" name="payfee">
                    </form>
                </div>

          <?php
                if(isset($_POST['payfee'])){
                    $am=$_POST['amount'];
                    if(($newfee-$paid_fees)-$am<0){
                        echo '<script>alert("Invalid amount")</script>';
                    }
                    else{
                        $total_paid=$paid_fees+$am;
                        $update_fee="UPDATE students set paidfee='$total_paid', payment_date=now() WHERE sid = '$sid' AND batch = '$batch'";
                        $update_fee_query=mysqli_query($conn,$update_fee);
                        if($update_fee){
                            echo '<script>alert("Successfully done")</script>';
                            echo '<script>location.href="fees.php"</script>';
                        }else{
                            echo '<script>alert("Something went wrong")</script>';
                            echo '<script>location.href="fees.php"</script>';
                        }
                    }

                }

            }
?>
    </div>
    <style>
        .feepay{
            width: 200px;
            font-size: 20px;
            color: red;
            border-radius: 10px;
            border-color: green;
        }
        .feepay:hover{
            background-color: green;
            color: white;
        }
    </style>
    </body>
    </html>
    <?php
}else{
    header("Location: ../../index.php");
}
?>
