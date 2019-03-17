<?php
include ('dbconfig.php');
include ('Admin_Class.php');
$admin_obj=new admin_ns\Admin_Class($conn);
?>

<html>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
</head>
<body style="overflow-x: hidden">
<div class="jumbotron">
    <form method="post">
        <div class="row row d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 4px;padding-left:22px;font-size:16px" class="col-md-2">
                <label for="selcls" style="font-family: 'Arial';font-size: 20px" >SELECT CLASS</label></div>
            <div class="col-md-10">
                <select class="form-control mdb-select md-form chosen" id="selcls" name="clasSelect" required>
                    <?php
                    echo $admin_obj->Class_lists($_SESSION['dept_id']);
                    ?>
                </select></div>
    </form></div>
</body>
<div id ="studenttable" class="col-lg-12 col-md-6 ">
</div>

</html>
<script type="text/javascript">
    $(".chosen").select2();
    $("#selcls").on('change',function () {
        var class_id=$(this).val();
        if(class_id) {
            $.ajax(
                {
                    type:'post',
                    url:'ajax_manage_student.php',
                    data:'class_id='+class_id,
                    success:function (response) {
                        if(response){
                            $('#studenttable').html(response);
                        }
                    }
                }
            );
        }
    });


</script>