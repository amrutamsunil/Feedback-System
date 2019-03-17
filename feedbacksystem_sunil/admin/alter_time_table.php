<html>
<?php
include('../dbconfig.php');
include('../admin/Admin_Class.php');
$time_table_obj=new admin_ns\Admin_Class($conn);
?>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
</head>
<body>
<div class="jumbotron">
    <form method="post">
        <div class="row row d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="clsel" style="font-size: 20px;font-family: Arial;">SELECT CLASS</label></div>
            <div class="col-md-10">
                <select class="form-control mdb-select md-form chosen" id="clsel" name="classSelect" >
                    <?php
                    echo $time_table_obj->Class_lists($_SESSION['dept_id']);
                    ?>
                </select></div>
        </div>
        <br/>
        <div class="row d-flex p-3 bg-secondary ">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="selsuj" style="font-size: 20px;font-family: Arial;">SELECT SUBJECT</label></div>
            <div class="col-md-4">
                <select class="form-control mdb-select md-form chosen" id="selsuj" name="selsubj" >
                    <?php
                    echo $time_table_obj->subject_lists();
                    ?>
                </select></div>
            <div class="col-md-2">
                <label for="sf" style="font-size: 20px;font-family: Arial;">SELECT FACULTY</label></div>
            <div class="col-md-4">
                <select class="form-control mdb-select md-form chosen" id="sf" name="selfac" >
                    <?php
                    echo $time_table_obj->faculty_names();
                    ?>
                </select></div>
        <br/><br/><br/><br/>
        </div>
        <div class="row d-flex p-3 bg-secondary"><center><input type="submit" name="set_table" value="OK"> </center></div>
    </form></div>
<div class="row d-flex p-3 bg-secondary">
    <div class="col-lg-12">
    <table class='table table-responsive table-bordered table-striped table-hover' style='margin:15px;'>
        <tr class='info'>
            <th class='text-capitalize text-dark info'>CLASS NAME </th>
            <th class='text-capitalize text-dark info'>SUBJECT NAME</th>
            <th class='text-capitalize text-dark info'>FACULTY NAME</th>
            </tr>
        <?php
        extract($_POST);
        if(isset($set_table)) {
            if ($set_table == "") {
                echo "<script>alert('Select any Option!!');</script>";
            }
            elseif ($_POST['classSelect']==""){     echo "<script>alert('Select any Class!!');</script>";}
            elseif ($_POST['selsubj']==""){     echo "<script>alert('Select any Subject!!');</script>";}
            elseif ($_POST['selfac']==""){     echo "<script>alert('Select any Faculty!!');</script>";}

            else {
                echo $time_table_obj->set_subj_alloc($_POST['classSelect'], $_POST['selsubj'], $_POST['selfac']);
            }
        }
        ?>
    </table>
    </div>
</div>

</body>
</html>
<script type="text/javascript">

    $(".chosen").select2();
</script>
