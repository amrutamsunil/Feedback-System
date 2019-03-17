<?php
include ('dbconfig.php');
include ('Admin_Class.php');
require ('../vendor/fpdf181/fpdf.php');
$all_faculty_obj=new admin_ns\Admin_Class($conn);
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
</head>
<body style="overflow-x: hidden">
    <table id='faculty_wise' class='table table-bordered'>
        <tr class='primary'>
            <th  class='text-capitalize text-dark info'>S.NO</th>
            <th  class='text-capitalize text-dark info'>FACULTY NAME</th>
            <th  class='text-capitalize text-dark info'>DEPARTMENT</th>
            <th  class=' text-capitalize text-dark info'>CLASS NAME </th>
            <th  class=' text-capitalize text-dark info'>SEM </th>
            <th class='text-capitalize text-dark info' >BATCH </th>
            <th  class='text-capitalize text-dark info'>SUBJECT NAME </th>
            <th class='text-capitalize text-dark info' > PHASE I</th>
            <th  class='text-capitalize text-dark info'> PHASE II </th>
            <th  class='text-capitalize text-dark info'> AVG </th>

        </tr>
        <?php
        if(isset($_SESSION['dept_id']))
        {
                echo $all_faculty_obj->all_faculty_wise_report($_SESSION['dept_id']);


        }
        else {
            header('location:index.php');
        }
        ?>
    </table>

</body>



</html>

