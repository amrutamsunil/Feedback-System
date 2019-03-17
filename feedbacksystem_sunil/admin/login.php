
<?php
extract($_POST);
include('dbconfig.php');
include('Admin_Class.php');
$login_obj= new admin_ns\Admin_Class($conn);
session_start();
if(isset($save))
{
    $err="";
    $username=$conn->real_escape_string($uname);
    $password=$conn->real_escape_string($pass);
    $err=$login_obj->LoginCheck($username,$password,$err,$_SESSION['dept_id']);

}

?>
<title>Login Page</title>
<!-- Favicons-->
<link href="../img/miet.png" rel="icon">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../css/util.css">
<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->



<div class="limiter" >
    <div class="container-login100">
        <div class="wrap-login100 p-l-50 p-r-50 p-t-77 p-b-30">
            <form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-55">
						Login
					</span>

                <div class="wrap-input100" >
                    <input class="input100" type="text" name="uname" placeholder="username" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<span class="lnr lnr-envelope"></span>
						</span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
                    <input class="input100" type="password" name="pass" placeholder="Password" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
                </div>

                <div class="container-login100-form-btn p-t-25">
                    <button  type="submit" name="save" class="login100-form-btn">
                        Login
                    </button>
                </div>

                <div><center>
                        <?php
                        echo "<font color='red'>".@$err."</font>";
                        ?></center>
                </div>

            </form>
        </div>
    </div>
</div>




<!--===============================================================================================-->
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<!--===============================================================================================-->
<script src="../js/main.js"></script>

