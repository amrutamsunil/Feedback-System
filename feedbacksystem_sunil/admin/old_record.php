<?php
include ('dbconfig.php');
include ('Admin_Class.php');
$admin_obj_=new admin_ns\Admin_Class($conn);
?>
<html>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
    <style>
        .sunil_custom_pdf {
            background-image: url( '../images/PDF-icon-small-231x300.png' ) ;
            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
            display: block;
            height: 80px;
            width: 80px;
        }

    </style>

</head>
<body>
<div class="jumbotron">
    <form method="post" >
        <div class="row  d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="stf_">Select Faculty</label></div>
            <div class="col-md-8">
                <select class="form-control mdb-select md-form chosen" name="staffselect_" id="stf_" required>
                    <?php
                    echo $admin_obj_->faculty_lists($_SESSION['dept_id']);
                    ?>
                </select></div>
        </div>
    </form>
</div>
<div id ="facultytable" class="col-lg-12 col-md-6 ">
</div>
<script>
    $(".chosen").select2();
    $('#stf_').on('change',function () {
        var staff_selected=$(this).val();
        if(staff_selected) {
            $.ajax({
                type:'post',
                url:'ajax_faculty_report.php',
                data:"staff_id="+staff_selected,
                success:function (response)
                {
                    $('#facultytable').html(response);
                }

            });
        }



    });
</script>
</body>
</html>

