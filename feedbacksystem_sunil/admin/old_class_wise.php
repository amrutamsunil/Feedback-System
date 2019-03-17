<html>
<?php
include ('dbconfig.php');
include ('Admin_Class.php');
$_admin_obj=new admin_ns\Admin_Class($conn);
?>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link href="../css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="jumbotron">
    <form method="post">
        <div class="row row d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="btch" style="font-size: 20px;font-family: Arial;">SELECT BATCH</label></div>
            <div class="col-md-8">
                <select class="form-control mdb-select md-form " id="batch" name="batch_select" id="btch" required>
                    <?php
                        echo $_admin_obj->batch_lists();
                    ?>
                </select></div>
        </div>
        <br/>
        <div class="row row d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="clssel_" style="font-size: 20px;font-family: Arial;">SELECT CLASS</label></div>
            <div class="col-md-8">
                <select class="form-control mdb-select md-form chosen" id="class_select" name="classSelect_" id="clssel_" required>
                    <?php
                    echo "<options value='".$_POST['batch']."'>".$_POST['batch']."</options>";
                    ?>
                </select></div>
        </div>
    </form></div>
<div id ="classtable" class="col-lg-12 col-md-6 col-sm-6">
</div>
<script type="text/javascript">
    $(document).ready(
        function () {
            $('#batch').on('change',function () {
                var batch=$(this).val();
                if(batch){
                    $.ajax({
                        type:'POST',
                        url:'trial.php',
                        data:"batch="+batch,
                        success:function (html) {
                            $('#class_select').html(html);
                        }
                    });
                }
                else{
                    $('#class_select').html('<option value="">Select Batch First</option>');
                }
            });

        }
        );


    $("#class_select").on('change',function () {
        var class_id=$(this).val();
        if(class_id){
            $.ajax(
                {
                    type:'post',
                    url:'ajax_class_wise_report.php',
                    data:"class_id="+class_id,
                    success:function (response) {
                        $('#classtable').html(response);
                    }

                }
            );
        }
    });

    $(".chosen").select2();
</script>
</body>
</html>