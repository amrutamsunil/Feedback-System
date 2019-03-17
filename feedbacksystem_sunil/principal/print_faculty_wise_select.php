<?php
include ('../dbconfig.php');
include ('../admin/Admin_Class.php');
$admin_obj=new admin_ns\Admin_Class($conn);
?>
<html>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
    <script src="../vendor/Export2Excel.js"></script>
    <script src="../vendor/tableexport-2.1.min.js"></script>
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
    <form method="post" action="final_report_trial.php">
        <div class="row  d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-top: 8px;font-size:16px" class="col-md-2">
                <label for="stfsel">Select Faculty</label></div>
            <div class="col-md-8">
                <select class="form-control mdb-select md-form chosen" name="staffselect" id="stfsel" required>
                    <?php
                    if(isset($_SESSION['dept_id'])){
                    echo $admin_obj->faculty_lists($_SESSION['dept_id']);}
                    else {
                        header('location:admin');
                    }
                    ?>
                </select></div>
            <div class="col-md-2">
                <input name="go" type="submit" value="" class="sunil_custom_pdf"/></div>
        </div>

    </form>

</div>
<div class="container">
    <form method="post" action="All_faculty_pdf.php">

        <label>PRINT ALL FACULTY : <input name="go" type="submit" value="ALL FACULTY" class="btn btn-primary"/></label>
    </form>
</div>

<script>
    $(".chosen").select2();
</script>
</body>
</html>

