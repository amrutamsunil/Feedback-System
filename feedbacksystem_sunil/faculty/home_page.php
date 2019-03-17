<?php
session_start();
if(!isset($_SESSION['user']))
{
    header('location:index.php');
}
include('../dbconfig.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Faculty dashboard</title>
    <link href="../img/miet.png" rel="icon">

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="../css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/css/nav.css" rel="stylesheet">


</head>

<body style="overflow-y: scroll">


<div class="navbar_miet float-left ">
    <a href="home_page.php"><i class="fa fa-home" aria-hidden="true"></i> HOME </a>
    <a href="home_page.php?info=feedback_report"><i class="fa fa fa-comments-o" aria-hidden="true"></i> FEEDBACK REPORT</a>
    <a href="home_page.php?info=rating_report"><i class="glyphicon glyphicon-zoom-in" aria-hidden="true"></i>  RATING REPORT</a>
    <div class="subnav_miet" style="float: right">
            <a href="home_page.php?info=update_password"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>SignOut</a>
    </div>
</div>

 <div class="row  d-flex p-3 bg-secondary">
            <div class="col-lg-12">

                        <?php
                        @$id=$_GET['id'];
                        @$info=$_GET['info'];
                        if($info!="")
                        {
                            if($info=="feedback_report")
                            {
                                include('feedback_report.php');
                            }
                            else if($info=="rating_report")
                            {
                                include('star_wise_report.php');
                            }
                            else if($info=="update_password"){
                                include ('update_password.php');
                            }

                        }
                        else
                        {
                                include('dashboard_home.php');
                        }
                        ?>

            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- /.row -->
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../css/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../css/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../css/metisMenu.min.js"></script>


<!-- Custom Theme JavaScript -->
<script src="../css/sb-admin-2.js"></script>

</body>

</html>
