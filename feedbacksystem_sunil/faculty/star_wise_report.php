<?php
include('../dbconfig.php');
include('Faculty.php');
$report_star_obj=new faculty\Faculty($conn);
?>
<html>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
    <script src="../vendor/Export2Excel.js"></script>
    <script src="../vendor/tableexport-2.1.min.js"></script>
</head>
<body style="overflow-x: hidden">

<?php
if($_SESSION['user']!=""){
    echo $report_star_obj->star_wise_report($_SESSION['user']);}
else {
    include ('home_page.php');
}
?>
<br/><br/><center>
<P style="font-family: 'Adobe Caslon Pro';font-size: 20px;border: dashed 2px lightgrey"><b>**Record includes all the subject handled in the current semester</b></P>
</center>
</body>

</html>
