<?php
include ('../dbconfig.php');
include ('Faculty.php');
extract($_POST);
$fac_rep_obj= new \faculty\Faculty($conn);
$batch= "-NIL";$sem="-NIL-";$name= "-NIL";$batch="-NIL-";$subj_name="-NIL-";
if(isset($_SESSION['user'])){
    $employee_number=$_SESSION['user'];
}
else {
    header('location:index.php');
}


$que_wise_report=array();
if(isset($subjSelect)) {

    if ($subjSelect == "" ) {
        echo "
        <script>
        alert('Select any Subject!!');
        </script>
        ";
    } else {
        $que_wise_report = $fac_rep_obj->faculty_report($_POST['subjSelect']);
        $cls_details=$fac_rep_obj->class_details($_POST['subjSelect']);
        $batch=$cls_details['batch'];$sem=$cls_details['sem'];$name=$cls_details['name'];
        $subj_name=$cls_details[0]['short'];
    }
}

?>
<html>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link href="../css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <style>
        .close-image {
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
<body style="overflow-x: hidden">
<br/><br/><br/>
<div >
    <form method="post" action="print_feedback_report.php">
        <div class="row row d-flex p-3 bg-secondary">
            <div style="text-align: center;padding-left:60px;padding-top: 4px;font-size:16px" class="col-md-2">
                <label for="sbsel" style="font-family: 'Adobe Caslon Pro';font-size: 20px"> SELECT SUBJECT </label></div>
            <div class="col-md-8">
                <select class="form-control mdb-select md-form chosen" name="subjSelect" id="sbsel">
                    <?php
                    echo "<h1 style='font-family: 'Adobe Caslon Pro''><b>".$fac_rep_obj->subject_lists($employee_number)."</b></h1>";
                    ?>
                </select></div>
            <div class="col-md-2">
                <input name="go" type="submit" value=""  class="close-image"/> </div></div>
    </form></div>
<br/>
<p id="subj_name">

</p>
<div id="data">
</div>
<script type="text/javascript">
    $('.chosen').select2();
    $('#sbsel').on('change',function () {
       var subj_selected=$(this).val();
        if(subj_selected) {
        $.ajax({
            type:'post',
            url:'ajax_faculty_report.php',
            data:"subj_id="+subj_selected,
            success:function (response)
            {
                $('#data').html(response);
            }

        });
        }



    });
</script>
</body>
</html>
