<?php
include("config/database.php");
$successful = "false";
session_start();
$error = "";
if(isset($_POST['login'])){
	$error = "none";
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	 $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(empty($username) || empty($password)){
		sleep(1);
        $error = "! Username Or password is empty";
    }
    else{
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1){
			sleep(1);
          $error = "! User does not exist";
        }else{
            if($row = mysqli_fetch_assoc($result)){
                if(!($password == $row['password'])){
					sleep(1);
                    $error = "! Password is incorrect";
                }
                else if ($row['status']=='No'){
                  $error="Your account is not activated conncet to admin or superadmin";
                }
                else if($password == $row['password']){
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];

						$successful = "done";
						$error = "none";
						sleep(7);
						if($row['type']=="sadmin"){
                            header("Location: modules/sadmin/");
                            exit(0);
						}
						if($row['type']=="admin"){
							header("Location: modules/admin/");
                            exit(0);
						}
						if($row['type']=="teacher"){
							header("Location: modules/teacher/");
                            exit(0);
						}
						if($row['type']=="student"){
							header("Location: modules/student/");
                            exit(0);
						}
						if($row['type']=="parent"){
						    header("Location: modules/parent/");
                            exit(0);
                        }
                }
            }
        }
    }
}
if(isset($_SESSION['id'])){
    $username1 = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username = '$username1'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    if($row['type']=="sadmin"){
        header("Location: modules/sadmin/");
        exit(0);
    }
    if($row['type']=="admin"){
        header("Location: modules/admin/");
        exit(0);
    }
    if($row['type']=="teacher"){
        header("Location: modules/teacher/");
        exit(0);
    }
    if($row['type']=="student"){
        header("Location: modules/student/");
        exit(0);
    }
    if($row['type']=="parent"){
        header("Location: modules/parent/");
        exit(0);
    }
}else{
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Coaching Management System</title>


        <link rel='stylesheet prefetch'
              href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>

        <link rel="stylesheet" href="css/style.css">
           <!-- Required meta tags -->
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="fonts/icomoon/style.css" />

    <link rel="stylesheet" href="css/owl.carousel.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css" />

    </head>

    <body>
    <?php if ($successful == "false") {
        ?>
        <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img
            
            src="images/undraw_remotely_2j6y.svg"
              alt="Image"
              class="img-fluid"
            />
          </div>
          <div class="col-md-6 contents">
            <div class="row justify-content-center">
              <div class="col-md-8">
                <div class="mb-4">
                  <h3>Sign In</h3>
                  <p class="mb-4">
                    We are the best coaching center in our area with our experts teachers.
                  </p>
                </div>
                <form action="#" method="post">
                <span style="color:red"><?php echo $error; ?></span> 
                  <div class="form-group first">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username"/>
                  </div>
                  <div class="form-group last mb-4">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" />
                  </div>

                 

                  <input
                    type="submit"
                    value="Log In"
                    name="login"
                    class="btn btn-block btn-primary"
                  />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        
    <?php } ?>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>


    </body>

    </html>

<?php } ?>