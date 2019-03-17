<?php
session_start();
include('../dbconfig.php');
include ('User_Class.php');
$user= $_SESSION['user'];
if($user=="")
{header('location:../index.php');}
$user_class=new user_ns\User_Class($conn);
$user_data=$user_class->fetch_user($user);
?>

<?php
@$page= $_GET['page'];
if($page!="")
{

    if($page=="change_password"){
        include('change_password.php');
    }
    if($page=="phase1"){
        $_SESSION['phase']=1;
        include ('feedback.php');
    }
    elseif($page=="phase2"){
        $_SESSION['phase']=2;
        include ('feedback.php');
    }

}
else
{

?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>STUDENT DASHBOARD</title>
    <link href="../img/miet.png" rel="icon">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .boxed {
            border: 2px solid red ;
            width: 200px;
            background-color: blanchedalmond;
        }
    </style>
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="../assets/css/iconfont.css">
    <link rel="stylesheet" href="../assets/css/slick/slick.css">
    <link rel="stylesheet" href="../assets/css/slick/slick-theme.css">
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/jquery.fancybox.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <!--        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">




    <!--For Plugins external css-->
    <link rel="stylesheet" href="../assets/css/plugins.css" />

    <!--Theme custom css -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <!--Theme Responsive css-->
    <link rel="stylesheet" href="../assets/css/responsive.css" />

    <script src="../assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body data-spy="scroll" data-target=".navbar-collapse">

<div class='preloader'><div class='loaded'>&nbsp;</div></div>
<div class="culmn">
    <header id="main_menu" class="header navbar-fixed-top">
        <div class="main_menu_bg">
            <div class="container">
                <div class="row">
                    <div class="nave_menu">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand">
                                        <a class="navbar-brand" style="color:#FFFFFF" href="#">Hello <?php echo $user_data['name'];?></a>
                                    </a>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->



                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href="home_page.php?page=change_password"><i class="fa fa-key fa-lg"><b>Change Password</b></i></a></li>
                                        <li><a href="logout.php"><i class="fa fa-sign-out fa-lg"> <b>LOGOUT</b></i></a></li>
                                    </ul>
                                </div>

                            </div>
                        </nav>
                    </div>
                </div>

            </div>

        </div>
    </header> <!--End of header -->



    <!--home Section -->
    <section id="home" class="home">
        <div class="overlay">
            <div class="home_skew_border">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div class="main_home_slider text-center">
                                <div class="single_home_slider">
                                    <div class="main_home wow fadeInUp" data-wow-duration="700ms">

                                        <h1 style="text-shadow: 2px 4px 6px black;">SELECT PHASE</h1>
                                        <center><a href="#history" ><blink><div class="arrow"></div></blink></a></center>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--End of home section -->




    <!-- History section -->

    <section id="history" class="history sections">
        <div class="container" id="go">
            <form method="post">
                <div class="row">
                    <div class="col-sm-4 col-lg-6">
                        <center><a href="home_page.php?page=phase1" data-toggle="tooltip" title="PHASE 1 (SEMESTER STARTING)" class="bigbtn_1"></a> </center>
                    </div>
                    <div class="col-sm-4 col-lg-6">
                        <center>   <a href="home_page.php?page=phase2" data-toggle="tooltip" title="PHASE 2 (SEMESTER END)" class="bigbtn_2"></a>   </center>
                    </div>
                </div>

            </form>
        </div>
        <!--End of container -->
    </section>
 ><!--End of history -->


    <!-- service Section -->
    <section id="service" class="service">
        <div class="container-fluid">
            <div class="row">
                <div class="main_service">
                    <div class="col-md-6 col-sm-12 no-padding">

                        <div class="single_service single_service_text text-right">
                            <div class="head_title">
                                <h2>WHY FEEDBACK ?</h2>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-10 col-xs-10 margin-bottom-60">
                                    <div class="row">

                                        <div class="col-sm-10 col-sm-offset-1 col-xs-9 col-xs-offset-1">
                                            <article class="single_service_right_text">
                                                <h4>1. Feedback is always there</h4>
                                                <p>If you ask someone in your organization when feedback occurs, they
                                                    will typically mention an employee survey, performance appraisal, or
                                                    training evaluation. In actuality, feedback is around us all the
                                                    time. </p>
                                            </article>
                                        </div>
                                        <div class="col-sm-1 col-xs-1">
                                            <figure class="single_service_icon">
                                                <i class="fa fa-heart"></i>
                                            </figure><!-- End of figure -->
                                        </div>
                                    </div>
                                </div><!-- End of col-sm-12 -->

                                <div class="col-md-12 col-sm-10 col-xs-10 margin-bottom-60">
                                    <div class="row">

                                        <div class="col-sm-10 col-sm-offset-1 col-xs-9 col-xs-offset-1">
                                            <article class="single_service_right_text">
                                                <h4>2. Feedback is a tool for continued learning</h4>
                                                <p>Invest time in asking and learning about how others experience
                                                    working with your organization.</p>
                                            </article>
                                        </div>
                                        <div class="col-sm-1 col-xs-1">
                                            <figure class="single_service_icon">
                                                <i class="fa fa-heart"></i>
                                            </figure><!-- End of figure -->
                                        </div>
                                    </div>
                                </div><!-- End of col-sm-12 -->

                                <div class="col-md-12 col-sm-10 col-xs-10 margin-bottom-60">
                                    <div class="row">

                                        <div class="col-sm-10 col-sm-offset-1 col-xs-9 col-xs-offset-1 margin-bottom-20">
                                            <article class="single_service_right_text">
                                                <h4>3. Feedback is effective listening</h4>
                                                <p>Whether the feedback is done verbally or via a feedback survey, the
                                                    person providing the feedback needs to know they have been
                                                    understood (or received) and they need to know that their feedback
                                                    provides some value.</p>
                                            </article>
                                        </div>
                                        <div class="col-sm-1 col-xs-1">
                                            <figure class="single_service_icon">
                                                <i class="fa fa-heart"></i>
                                            </figure><!-- End of figure -->
                                        </div>
                                    </div>
                                </div><!-- End of col-sm-12 -->

                            </div>
                        </div>
                    </div><!-- End of col-sm-6 -->

                    <div class="col-md-6 col-sm-12 no-padding">
                        <figure class="single_service single_service_img">
                            <div class="overlay-img"></div>
                            <img src="../rawpixel-651333-unsplash.jpg" alt=""/>
                        </figure><!-- End of figure -->
                    </div><!-- End of col-sm-6 -->

                </div>
            </div><!-- End of row -->
        </div><!-- End of Container-fluid -->
    </section><!-- End of service Section -->


    <!--Footer section-->
    <section class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main_footer">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">

                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="copyright_text">
                                    <a href="http://miet.edu">@MIET COLLEGE OF ENGINEERING</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End off footer Section-->
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</div>
<?php
}
?>
<!-- START SCROLL TO TOP  -->

<div class="scrollup">
    <a href="#"><i class="fa fa-chevron-up"></i></a>
</div>


<script src="../assets/js/vendor/jquery-1.11.2.min.js"></script>
<script src="../assets/js/vendor/bootstrap.min.js"></script>

<script src="../assets/js/jquery.magnific-popup.js"></script>
<script src="../assets/js/jquery.mixitup.min.js"></script>
<script src="../assets/js/jquery.easing.1.3.js"></script>
<script src="../assets/js/jquery.masonry.min.js"></script>

<!--slick slide js -->
<script src="../assets/css/slick/slick.js"></script>
<script src="../assets/css/slick/slick.min.js"></script>


<script src="../assets/js/plugins.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>
