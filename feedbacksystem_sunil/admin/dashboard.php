<?php
session_start();
if(!isset($_SESSION['user']))
{
    header('location:index.php');
}
include('dbconfig.php');
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <link href="../img/miet.png" rel="icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        Admin Dashboard
    </title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">



    <link href="../css/metisMenu.min.css" rel="stylesheet">



    <link href="../css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../vendor/css/nav.css" rel="stylesheet">


</head>

<body style="overflow-y: scroll">
<div class="navbar_miet float-left ">
    <a href="dashboard.php"><i class="fa fa-home" aria-hidden="true"></i> HOME</a>
    <div class="subnav_miet">
        <button class="subnavbtn_miet"><i class="fa fa fa-comments-o" aria-hidden="true"></i> FEEDBACK <i class="fa fa-caret-down"></i></button>
        <div class="subnav_miet-content">
            <a href="dashboard.php?info=class_wise" style="margin-left:7%"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Class-wise</a>
            <a href="dashboard.php?info=faculty_wise"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Faculty-wise</a>
            <a href="dashboard.php?info=all_faculty_wise"><i class="fa fa-hand-o-right" aria-hidden="true"></i>All Faculty-wise</a>

        </div>
    </div>
    <div class="subnav_miet">
        <button class="subnavbtn_miet"><i class="fa fa-graduation-cap" aria-hidden="true"></i> STUDENT <i class="fa fa-caret-down"></i></button>
        <div class="subnav_miet-content">
            <a href="dashboard.php?info=display_student" style="margin-left:18%"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Manage Student</a>
        </div>
    </div>
    <a href="dashboard.php?info=time_table"><i class="fa fa-calendar" aria-hidden="true"></i>TIME TABLE</a>
    <div class="subnav_miet">
        <button class="subnavbtn_miet"><i class="fa fa fa-history" aria-hidden="true"></i> OLD RECORDS <i class="fa fa-caret-down"></i></button>
        <div class="subnav_miet-content">
            <a href="dashboard.php?info=old_class_wise" style="margin-left:36%"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Class-wise</a>
            <a href="dashboard.php?info=old_faculty_wise"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Faculty-wise</a>

        </div>
    </div>

    <div class="subnav_miet" style="float: right">
            <a href="dashboard.php?info=update_password"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>SignOut</a>
    </div>
</div>

<div class="flex-column">

    <!-- feedback-->
    <div class="row">
        <div class="col-lg-12">

            <?php
            @$id=$_GET['id'];
            @$info=$_GET['info'];
            if($info!="")
            {


                if($info=="display_student")
                {
                    include('display_student.php');
                }

                elseif($info=="time_table")
                {
                    include('alter_time_table.php');
                }
                elseif($info=="all_faculty_wise")
                {
                    include('all_faculty_wise_report.php');
                }
                elseif($info=="all_faculty_wise")
                {
                    //include('all_faculty_wise_report.php');
                }


                elseif($info=="class_wise")
                {
                    include('class_wise_feedback.php');
                }

                elseif($info=="faculty_wise")
                {
                    include('faculty_wise_feedback.php');
                }
                else if($info=="update_password")
                {
                    include('update_password.php');
                }
                else if($info=="old_faculty_wise")
                {
                    include('old_record.php');
                }
                else if($info=="old_class_wise")
                {
                    include('old_class_wise.php');
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
</div>
<!-- /.row -->
<!-- /#page-wrapper -->

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
