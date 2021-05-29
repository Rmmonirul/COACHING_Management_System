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
            <title>SAdmin-CIMS</title>
            <link rel="stylesheet" type="text/css" href="../admin/css/style.css">
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
                th,td{
                    width: 200px;
                }

                hr{
                    width: 60%;
                }



            </style>
        </head>
        <body>
        <h2 align="center" style="color: blue"><?php echo " Online Coaching Management System(CMS)" ?></h2>
        <h2 align="center" style="color: blue"><?php echo "Super Admin" ?></h2>
        <div class="header">
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="add.php">Add/Update</a>
            <a href="view.php">View Details</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../logout.php">Logout</a>
        </div>

        <div align="center" style="background-color: aquamarine;padding: 10px">
            <a href="add.php?addadmin=true" class="linking">Add Admin</a>
            <a href="add.php?updateadmin=true" class="linking">Update Admin</a>
        </div>


        <?php
        if(!isset($_GET['addadmin']) AND !isset($_GET['updateadmin'])){
            ?>
                <h2 style="color: red;" align="center">Select One From Top navigation Bar</h2>
            <?php
        }
            if(isset($_GET['addadmin'])){
                $sql = "SELECT eid FROM teachers ORDER BY eid DESC LIMIT 1";
                $sql_q = mysqli_query($conn, $sql);
                $ro = mysqli_fetch_assoc($sql_q);
                $eid_get_from_sql = $ro['eid'];
                function increment($sid)
                {
                    return ++$sid[1];
                }

                $eid_get_from_sql = preg_replace_callback("|(\d+)|", "increment", $eid_get_from_sql);
                ?>
                <div align="center">
                    <h3>Add Teacher</h3>
                    <form method="post">
                        <b>EID:</b> <input type="text" name="e  id" value="<?php echo $eid_get_from_sql; ?>" disabled>
                        <b>Fname:</b> <input type="text" name="fname" placeholder="First Name" required>
                        &nbsp;&nbsp;<b>Lname:</b> <input type="text" name="lname" placeholder="Last Name" required>
                        <br><b>Email:</b> <input type="email" name="email" placeholder="Email" required>
                        &nbsp;&nbsp;<b>Mobile:</b> <input type="text" name="mobile" placeholder="Mobile" required><br>
                        <b>Address:</b> <input type="text" name="address" placeholder="Address" required>
                        &nbsp;&nbsp;<b>City:</b> <input type="text" name="city" placeholder="City" required>
                        <br><b>State:</b> <input type="text" name="state" placeholder="State" required>
                        &nbsp;&nbsp;<b>Pin code:</b> <input type="text" name="postalcode" placeholder="Pin Code" required><br>
                        <b>Date Of joining:</b> <input type="date" name="dateofjoining" required>
                        <hr width="80%">
                        <br><b>Salary:</b> <input type="text" name="salary" placeholder="Salary Per Month" required>
                        <b>Position:</b> <input type="text" name="position" value="Admin" disabled>
                        <br><b>Experience:</b> <input type="text" name="experience" placeholder="Experience" required>
                        <br><b>Highest Qualification:</b> <input type="text" name="highestqualification" placeholder="Highest Qualification" required>
                        &nbsp;&nbsp;<b>Highest Qualification Marks:</b> <input type="text" name="highestqualificationmarks" placeholder="Highest Qualification Marks" required>
                        <br><br><input type="submit" name="add">
                    </form>
                </div>

            <?php
                if (isset($_POST['add'])) {
                    $te_fname = $_POST['fname'];
                    $te_lname = $_POST['lname'];
                    $te_email = $_POST['email'];
                    $te_mobile = $_POST['mobile'];
                    $te_address = $_POST['address'];
                    $te_city = $_POST['city'];
                    $te_state = $_POST['state'];
                    $te_pin = $_POST['postalcode'];
                    $te_salary = $_POST['salary'];
                    $te_dateofjoining = $_POST['dateofjoining'];
                    $te_position = 'admin';
                    $te_experience = $_POST['experience'];
                    $te_highestqualification = $_POST['highestqualification'];
                    $te_highestqualificationmarks = $_POST['highestqualificationmarks'];

                    $sql_get_insert = "INSERT INTO teachers(eid, fname, lname, email, mobile, address, city, state, postalcode, salary, position, dateofjoining, experience, highestqualification, highestqualificationmarks, status) 
                    VALUES ('$eid_get_from_sql','$te_fname','$te_lname','$te_email','$te_mobile','$te_address','$te_city','$te_state','$te_pin','$te_salary','$te_position','$te_dateofjoining','$te_experience','$te_highestqualification','$te_highestqualificationmarks','yes')";
                    $sql_get_insert_quary = mysqli_query($conn, $sql_get_insert);
                    $insert_into_users = "INSERT INTO users (username, password, type) VALUES ('$eid_get_from_sql','$eid_get_from_sql','$te_position')";
                    $insert_into_users_check = mysqli_query($conn,$insert_into_users);
                    if ($sql_get_insert_quary AND $insert_into_users_check) {
                        
                        echo '<script>alert("data success")</script>';
                        echo '<script>location.href="add.php"</script>';
                    } else {
                        echo '<script>alert("Failed Try Again")</script>';
                        echo '<script>location.href="add.php?addadmin=true"</script>';
                    }

                }
            }


            if(isset($_GET['updateadmin'])){
                if(isset($_GET['updateadmin']) AND !isset( $_GET['eid'])) {
                    $sql_get_admins = "SELECT * FROM teachers WHERE position='admin' ORDER BY eid";
                    $sql_get_admins_query = mysqli_query($conn, $sql_get_admins);
                    $sql_get_admins_query_check = mysqli_num_fields($sql_get_admins_query);
                    if ($sql_get_admins_query_check > 0) {
                        ?>
                        <div align="center">
                            <h4>All admins Details With Centers</h4>
                            <table border="2">
                                <tr>
                                    <th>Admin(EID)</th>
                                    <th>Admin(Name)</th>
                                    <th>Update Details</th>
                                </tr>
                                <?php while ($get_details = mysqli_fetch_assoc($sql_get_admins_query)) { ?>
                                    <tr align="center">
                                        <td><?php echo $get_details['eid'] ?></td>
                                        <td><?php echo $get_details['fname'] . ' ' . $get_details['lname'] ?></td>
                                        <td><a href="add.php?updateadmin=true&eid=<?php echo $get_details['eid']; ?>">Update
                                                Details</a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>

                    <?php }
                }
                if(isset($_GET['updateadmin']) AND isset($_GET['eid'])){
                    $get_eid = mysqli_real_escape_string($conn,$_GET['eid']);
                    $get_details_of_admin = "SELECT * FROM teachers WHERE eid='$get_eid' AND position='admin'";
                    $get_details_of_admin_query = mysqli_query($conn,$get_details_of_admin);
                    $get_details_of_admin_check = mysqli_num_rows($get_details_of_admin_query);
                    if($get_details_of_admin_check > 0){
                     $admin_details = mysqli_fetch_assoc($get_details_of_admin_query); ?>
                        <div align="center">
                            <h4>Update admin <span style="color: blue;">(<?php echo $get_eid?>)</span> Details</h4>
                            <br>
                            <form method="post">
                                <b>EID: </b><input type="text" name="eid_admin" value="<?php echo $admin_details['eid']; ?>" disabled><br>
                                <b>Fname: </b><input type="text" name="fname_admin" value="<?php echo $admin_details['fname']; ?>" placeholder="Enter Fname" required>
                                <b>Lname: </b><input type="text" name="lname_admin" value="<?php echo $admin_details['lname']; ?>" placeholder="Enter Lname" required><br>
                                <b>Email: </b><input type="text" name="email_admin" value="<?php echo $admin_details['email']; ?>" placeholder="Enter Email" required>
                                <b>Mobile: </b><input type="text" name="mobile_admin" value="<?php echo $admin_details['mobile']; ?>" placeholder="Enter Mobile Number" required><br>
                                <hr><b>Address: </b><input type="text" name="address_admin" value="<?php echo $admin_details['address']; ?>" placeholder="Enter Address" required >
                                <b>City: </b><input type="text" name="city_admin" value="<?php echo $admin_details['city']; ?>" placeholder="Enter City" required><br>
                                <b>State: </b><input type="text" name="state_admin" value="<?php echo $admin_details['state']; ?>" placeholder="Enter State" required>
                                <b>Pin Code: </b><input type="text" name="pin_admin" value="<?php echo $admin_details['postalcode']; ?>" placeholder="Enter pin code" required><hr>
                                <b>Position: </b><input type="text" name="position_admin" value="<?php echo $admin_details['position']; ?>" disabled>
                                <b>Salary: </b><input type="text" name="salary_admin" value="<?php echo $admin_details['salary']; ?>" placeholder="Enter Salary" required>
                                <br><b>Date Of Joining: </b><input type="date" name="date_admin" value="<?php echo $admin_details['dateofjoining']; ?>" disabled>
                                <hr>
                                <b>Experience: </b><input type="text" name="exp_admin" value="<?php echo $admin_details['experience']; ?>" required>
                                <br><b>Highest Qualification: </b><input type="text" name="hq_admin"  value="<?php echo $admin_details['highestqualification']; ?>" placeholder="Enter Highest qualification" required>
                                <b>Highest Qualification Marks: </b><input type="text" name="hqm_admin" value="<?php echo $admin_details['highestqualificationmarks']; ?>" placeholder="Enter Highest qualification Marks" required>
                                <br><input type="submit" name="update_admin" value="Update">
                                <input type="submit" name="delete_admin" value="Delete">
                            </form>
                        </div>
                    <?php }

                    if(isset($_POST['update_admin'])){
                        $admin_fname = $_POST['fname_admin'];
                        $admin_lname = $_POST['lname_admin'];
                        $admin_email = $_POST['email_admin'];
                        $admin_mobile = $_POST['mobile_admin'];
                        $admin_address = $_POST['address_admin'];
                        $admin_city = $_POST['city_admin'];
                        $admin_state = $_POST['state_admin'];
                        $admin_pin = $_POST['pin_admin'];
                        $admin_salary = $_POST['salary_admin'];
                        $admin_exp = $_POST['exp_admin'];
                        $admin_hq = $_POST['hq_admin'];
                        $admin_hqm = $_POST['hqm_admin'];

                        $admin_update = "UPDATE teachers SET fname='$admin_fname',lname='$admin_lname',email='$admin_email',mobile='$admin_email',mobile='$admin_mobile',address='$admin_address',city='$admin_city',state='$admin_state',postalcode='$admin_pin',salary='$admin_salary',experience='$admin_exp',highestqualification='$admin_hq',highestqualificationmarks='$admin_hqm' WHERE eid='$get_eid'";
                        $admin_update_q = mysqli_query($conn,$admin_update);
                        if($admin_update_q){
                            echo '<script>alert("Update success")</script>';
                            echo '<script>location.href="add.php"</script>';
                        } else {
                            echo '<script>alert("Update Failed Try Again")</script>';
                            echo '<script>location.href="add.php?addadmin=true"</script>';
                        }
                    }
                     if(isset($_POST['delete_admin'])){
                         $admin_delete = "DELETE FROM teachers WHERE eid='$get_eid'";
                        $admin_delete_q = mysqli_query($conn,$admin_delete);
                        $admin_deactivate="UPDATE users set status='No' where username='$get_eid'";
                        $admin_deactivate_q = mysqli_query($conn,$admin_deactivate);
                        if ($admin_delete_q and $admin_deactivate_q) {
                        
                        echo '<script>alert("data success")</script>';
                        echo '<script>location.href="add.php"</script>';
                    } else {
                        echo '<script>alert("Failed Try Again")</script>';
                        echo '<script>location.href="add.php?addadmin=true"</script>';
                    }
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
    header("Location: ../../index.php");
}

?>