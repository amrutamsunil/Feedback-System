
<?php
session_start();
extract($_POST);
if(isset($cse))
{
    $_SESSION['dept_id']=1; header('location:home_page.php');
}
elseif (isset($ece)){
    $_SESSION['dept_id']=2; header('location:home_page.php');
}
elseif (isset($mech)){
    $_SESSION['dept_id']=3; header('location:home_page.php');
}
elseif (isset($civil)){
    $_SESSION['dept_id']=4; header('location:home_page.php');
}
elseif (isset($eee)){
    $_SESSION['dept_id']=5; header('location:home_page.php');
}
elseif (isset($mba)){
    $_SESSION['dept_id']=6; header('location:home_page.php');
}
?>
<!DOCTYPE HTML>
<!--
    Industrious by TEMPLATED
    templated.co @templatedco
    Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
<head>
    <title>select dept</title>
    <meta charset="utf-8" />
    <link href="../img/miet.png" rel="icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="../assets/css/main_sd.css" />
</head>
<body class="is-preload">
<!-- Banner -->
<section id="banner">
    <div class="inner">
        <h1><b>select department</b></h1>
        <hr>
        <center>
            <blink>
                <div class="arrow"></div>
            </blink>
        </center>
    </div>
</section><br>
<form method="post">
    <section class="wrapper">
        <div class="inner">

            <div class="highlights">

                <div class="content">
                    <BUTTON class="button" style="
                             background-image:url('../images/cse_deaprtment.png');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 50% 50% 50% 50%;box-shadow: 3px 3px 5px 5px black;" name="cse" type="submit" class="btn btn-success">
                    </BUTTON>
                    <h1 style="padding:20px"><b>CSE</b></h1>
                </div>


                <div class="content">
                    <BUTTON class="button" style="
                             background-image:url('../images/civil_try_1.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 47% 47% 47% 47%;box-shadow: 3px 3px 5px 5px black;" name="civil" type="submit" class="btn btn-success">
                    </BUTTON>
                    <h1 style="padding:20px"><b>Civil</b></h1>
                </div>


                <div class="content">
                    <BUTTON class="button" style="
                             background-image:url('../images/mechanical_pic.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 50% 50% 50% 50%;box-shadow: 3px 3px 5px 5px black;" name="mech" type="submit" class="btn btn-success">
                    </BUTTON>
                    <h1 style="padding:20px"><b>mech</b></h1>
                </div>

                <section>
                    <div class="content">
                        <BUTTON class="button" style="
                             background-image:url('../images/eee.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 53% 53% 53% 53%;box-shadow: 3px 3px 5px 5px black;" name="eee" type="submit" class="btn btn-success">
                        </BUTTON>
                        <h1 style="padding:20px"><b>eee</b></h1>
                    </div>
                </section>
                <section>
                    <div class="content">
                        <BUTTON class="button" style="
                             background-image:url('../images/ece_try.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 53% 53% 53% 53%;box-shadow: 3px 3px 5px 5px black;" name="ece" type="submit" class="btn btn-success">
                        </BUTTON>
                        <h1 style="padding:20px"><b>ece</b></h1>
                    </div>
                </section>
                <section>
                    <div class="content">
                        <BUTTON class="button" style="
                             background-image:url('../images/mba_try.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 54% 54% 54% 54%;box-shadow: 3px 3px 5px 5px black;" name="mba" type="submit" class="btn btn-success">
                        </BUTTON>
                        <h1 style="padding:20px"><b>mba</b></h1>
                    </div>
                </section>
            </div>
        </div>
    </section>
</form>


<!-- Scripts -->
<script src="../assets/js/jquery_sd.min.js"></script>
<script src="../assets/js/browser_sd.min.js"></script>
<script src="../assets/js/breakpoints_sd.min.js"></script>
<script src="../assets/js/util_sd.js"></script>
<script src="../assets/js/main_sd.js"></script>
</body>
</html>