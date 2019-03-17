<?php
/**
 * Created by PhpStorm.
 * User: SUNIL
 * Date: 16-03-2019
 * Time: 14:48
 */
include ('dbconfig.php');
include ('Admin_Class.php');
$admin_obj=new admin_ns\Admin_Class($conn);
extract($_POST);
$staff_id=$_POST['staff_id'];
$fac=mysqli_query($conn,"select name from faculties where id=$staff_id");
$faculty_name=mysqli_fetch_array($fac);
echo "<hr style='border-top: dotted 1px;' />";
echo "
<table style='margin-left: 17%;width: 80%'>
<tr>
<td width: 50%><h3 style='font-family: Arial'><b>FACULTY NAME :<span style='color: #337ab7'> $faculty_name[0]</span></b></h3></td>
</tr></table>";
echo "<hr style='border-top: dotted 1px;' />";
echo "<br/>";
echo $admin_obj->faculty_wise_report($staff_id);

