<?php
/**
 * Created by PhpStorm.
 * User: SUNIL
 * Date: 16-03-2019
 * Time: 15:39
 */
include ('dbconfig.php');
include ('Admin_Class.php');
extract($_POST);
$admin_obj=new admin_ns\Admin_Class($conn);
$clasSelect=$_POST['class_id'];
echo $admin_obj->Student_status($clasSelect);
