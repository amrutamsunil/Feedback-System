
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select department</title>
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">

    <style>
         .custom{
        background:linear-gradient(135deg, #333300, #333300 74%)
        }
        .vasa{
            size: 40px;
            color: white;

        }
    </style>
</head>
<body style="overflow-y: hidden">
    <br/>
    <div class="container-fluid custom">
       <center><u><h1 class="vasa">SELECT DEPARTMENT</h1></u></center>
    </div><br/>
    <form method="post" style="padding-left: 15%">
        <div class="row">
            <div class="col-sm-4">
                <BUTTON class="button" style="
                             background-image:url('../images/cse_deaprtment.png');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 25% 25% 25% 25%;box-shadow: 3px 3px 5px 5px black;" name="cse" type="submit" class="btn btn-success">
                </BUTTON> <h3 style="margin: 5%;padding-left: 12%">CSE</h3></div>
            <div class="col-sm-4">
                <BUTTON class="button" style="
                             background-image:url('../images/civil_try_1.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 25% 25% 25% 25%;box-shadow: 3px 3px 5px 5px black;" name="civil" type="submit" class="btn btn-success">
                </BUTTON><h3 style="margin: 5%;padding-left: 12%">CIVIL</h3>
            </div>
            <div class="col-sm-4">
                <BUTTON class="button" style="
                             background-image:url('../images/mechanical_pic.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 25% 25% 25% 25%;box-shadow: 3px 3px 5px 5px black;" name="mech" type="submit" class="btn btn-success">
                </BUTTON><h3 style="margin: 5%;padding-left: 12%">MECH</h3>
            </div>
        </div><br/><br/>
        <div class="row">
            <div class="col-sm-4">
                <BUTTON class="button" style="
                             background-image:url('../images/eee.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 25% 25% 25% 25%;box-shadow: 3px 3px 5px 5px black;" name="eee" type="submit" class="btn btn-success">
                </BUTTON><h3 style="margin: 5%;padding-left: 14%">EEE</h3>
            </div>
            <div class="col-sm-4">
                <BUTTON class="button" style="
                             background-image:url('../images/ece_try.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 25% 25% 25% 25%;box-shadow: 3px 3px 5px 5px black;" name="ece" type="submit" class="btn btn-success">
                </BUTTON><h3 style="margin: 5%;padding-left: 14%">ECE</h3>
            </div>
            <div class="col-sm-4">
                <BUTTON class="button" style="
                             background-image:url('../images/mba_try.jpg');
                             border: 2px solid darkgray;
                                background-repeat: no-repeat;
                                background-size: cover;
                                cursor: pointer;
                                text-align:-webkit-center;
                                z-index: 2;
                             padding: 25% 25% 25% 25%;box-shadow: 3px 3px 5px 5px black;" name="mba" type="submit" class="btn btn-success">
                </BUTTON><h3 style="margin: 5%;padding-left: 14%">MBA</h3>
            </div>
        </div>


    </form>

</body>
</html>