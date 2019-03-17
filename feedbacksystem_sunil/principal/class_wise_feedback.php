<html>
<?php
include ('../dbconfig.php');
include ('../admin/Admin_Class.php');
$admin_obj=new admin_ns\Admin_Class($conn);
?>
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
<body style="max-width:100%;overflow-x:hidden;">
<br/><br/>
<div >
    <form method="post" action="pdf_classwise_report.php">
        <div class="row row d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="clss" >Select Class</label></div>
            <div class="col-md-8">
                <select class="form-control mdb-select md-form chosen" name="classSelect" id="clss" required>
                    <?php
                    echo $admin_obj->Class_lists($_SESSION['dept_id']);
                    ?>
                </select></div>
            <div class="col-md-2">
                <input name="go" type="submit" value="" class="sunil_custom_pdf"/></div>
    </form>
</div>

<div id ="classtable" class="col-lg-12 col-md-6 col-sm-6">

</div>

<script type="text/javascript">
    $(".chosen").select2();
    $("#clss").on('change',function () {
        var class_id=$(this).val();
        if(class_id){
            $.ajax(
                {
                    type:'post',
                    url:'../admin/ajax_class_wise_report.php',
                    data:"class_id="+class_id,
                    success:function (response) {
                        $('#classtable').html(response);
                    }

                }
            );
        }
    });
</script>
</body>
</html>