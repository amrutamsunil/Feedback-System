
<?php
extract($_POST);
session_start();
include('../dbconfig.php');
include ('principal.php');
$user_obj=new principal($conn);
if(isset($save))
{
    $err=" ";
    $username=$conn->real_escape_string($uname);
    $password=$conn->real_escape_string($pass);
    $err=$user_obj->LoginCheck($username,$password,$err);
}

?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login</title>
<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
<script src="../lib/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement : 'bottom'
        });
    });
</script>
<style type="text/css">
    .bs-example{
        margin: 100px 50px;
    }
</style>

<title>Login Page</title>
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
                    <input class="input100" type="password" name="pass" placeholder="password" required data-toggle="tooltip" title="DD-MM-YYYY(Default)">
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
                <div>
                    <?php
                    echo "<font color='red'>".@$err."</font>";
                    ?>
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

