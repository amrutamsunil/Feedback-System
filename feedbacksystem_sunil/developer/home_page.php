<?php
session_start();
if(!isset($_SESSION['user']))
{
    header('location:index.php');
}
include('../dbconfig.php');
@$info1=$_GET['info'];
if($info1=="alter_dep"){
    header('location:select_dep.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <link href="../img/miet.png" rel="icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>

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
    <a href="home_page.php"><i class="fa fa-home" aria-hidden="true"></i> HOME</a>
    <div class="subnav_miet">
        <button class="subnavbtn_miet"><i class="fa fa fa-graduation-cap" aria-hidden="true"></i> MANAGE STUDENT <i class="fa fa-caret-down"></i></button>
        <div class="subnav_miet-content">
            <a href="home_page.php?info=add_student" style="margin-left:8%"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ADD STUDENT</a>
            <a href="home_page.php?info=remove_student" ><i class="fa fa-hand-o-right" aria-hidden="true"></i> DELETE STUDENT</a>
            <a href="home_page.php?info=alter_feedback"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ALTER FEEDBACK SUBMISSION</a>
        </div>
    </div>
    <div class="subnav_miet">
        <button class="subnavbtn_miet"><i class="fa fa-user" aria-hidden="true"></i> MANAGE FACULTY <i class="fa fa-caret-down"></i></button>
        <div class="subnav_miet-content">
            <a href="home_page.php?info=add_faculty" style="margin-left:22%"><i class="fa fa-hand-o-right" aria-hidden="true"></i> ADD FACULTY</a>

        </div>
    </div>
    <div class="subnav_miet" style="float: right">
            <a href="home_page.php?info=update_password"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>SignOut</a>
    </div>
    <a href="home_page.php?info=alter_dep"><i class="fa fa-wrench" aria-hidden="true"></i> CHANGE DEPARTMENT</a>
    <a href="home_page.php?info=promote"><i class="fa fa-forward" aria-hidden="true"></i> PR0MOTE </a>
</div>

 <div class="row  d-flex p-3 bg-secondary">
            <div class="col-lg-12">

                        <?php
                        @$id=$_GET['id'];
                        @$info=$_GET['info'];
                        if($info!="")
                        {
                            if($info=="add_student")
                            {
                                include('AddStudent.php');
                            }


                            elseif($info=="remove_student")
                            {
                                include('DeleteStudent.php');
                            }

                            elseif($info=="alter_feedback")
                            {
                                include('AlterFeedbackReport.php');
                            }
                            elseif ($info=="add_faculty")
                            {
                                include('addFaculty.php');
                            }
                            else if($info=="update_password")
                            {
                                include('update_password.php');
                            }
                            elseif ($info=="promote")
                            {
                                include('pramote.php');
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
