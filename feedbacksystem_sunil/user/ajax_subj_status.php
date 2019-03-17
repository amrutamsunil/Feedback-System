<?php
include ('../dbconfig.php');
include ('User_Class.php');
$user_obj4=new user_ns\User_Class($conn);
extract($_POST);
$subject_selected=$_POST['subjsel'];
$phase=$_POST['phase'];
$user=$_POST['user'];


    $users=$user_obj4->fetch_user($user);
    if(!($user_obj4->check_feedback_submit($subject_selected,$users,$phase))){
        echo "You have already Given Feedback to this Subject !!" ;

    }

?>