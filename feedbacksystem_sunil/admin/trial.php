<?php
include ('../dbconfig.php');
session_start();
if(isset($_SESSION['dept_id'])){
$dept_id=$_SESSION['dept_id'];}
if($_POST['batch']!=""){
    $batch=$_POST['batch'];
}
extract($_POST);

    $options = "<option value=''>Select Class</option> ";
    $cl = mysqli_query($conn, "select * from classes where department_id=$dept_id and batch=$batch ");
    while ($class_lists = mysqli_fetch_array($cl)) {
        $options .= "<option value='" . $class_lists['id'] . "'>" . $class_lists['name'] . "</option>";
    }
    echo $options;
?>
