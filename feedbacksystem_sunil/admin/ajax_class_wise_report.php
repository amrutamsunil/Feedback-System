<?php
/**
 * Created by PhpStorm.
 * User: SUNIL
 * Date: 16-03-2019
 * Time: 15:19
 */
include ('dbconfig.php');
include ('Admin_Class.php');
$admin_obj=new admin_ns\Admin_Class($conn);
extract($_POST);
$class_id=$_POST['class_id'];
$cls_det_=mysqli_query($conn,"select * from classes where id=$class_id");
$cls_det=mysqli_fetch_array($cls_det_);
$dep=mysqli_query($conn,"select name from departments where id=$cls_det[1]");
$dep_name=mysqli_fetch_array($dep);
echo "<hr style='border-top: dotted 1px;' />";
echo "
<table style='margin-left: 17%;width: 80%'>
<tr>
<td width: 50%><h3 style='font-family: Arial'><b>CLASS NAME :<span style='color: #337ab7'> $cls_det[2]</span></b></h3></td>
<td width: 50%><h3  style='font-family: Arial'><b> BATCH :<span style='color: #337ab7'> $cls_det[5]</span></b></h3></td></tr>
<tr>
 <td style='width: 40%'><h3  style='font-family: Arial'><b>SEMESTER :<span style='color: #337ab7'> $cls_det[3]</span></b></h3></td>
 <td width: 50%><h3 style='font-family: Arial'><b>DEPARTMENT NAME :<span style='color: #337ab7'> $dep_name[0]</span></b></h3></td>

 </tr></table>";
echo "<hr style='border-top: dotted 1px;' />";

echo "<br/>";

echo $admin_obj->class_wise_report($class_id);
