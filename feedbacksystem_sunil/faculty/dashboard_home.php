<html>
<!-- Favicons-->
<?php
include('../dbconfig.php');
include('Faculty.php');
$graph_obj=new faculty\Faculty($conn);
?>
<title>Faculty</title>
<head>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <style>
        .vasanth {
            background-color: white;
            border: 2px solid lightgrey;
            padding: 40px;
            margin: 1px;
            border-radius:10px;
            padding-right: 30% ;
            margin-left: 65%;
        }
    </style>
</head>
<h1 align="center" style=" color: dodgerblue;text-shadow: 4px 4px 6px lightblue;font-family: Rockwell"><a href="">FACULTY DASHBOARD</a></h1>

<body>

<?php
if(isset($_SESSION['user'])){
    $dataPoints=$graph_obj->render_graph($_SESSION['user']);}
else{
    header('location:index.php');
}

?>
<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "COUNT"
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>
<br/>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<br/>
<div style="border: dashed 2px lightgrey;font-family: 'Adobe Caslon Pro';font-size: 15px">
    <center>
<P><b>**Graph renders the aggregate score of each subject</b></P>
<P><b>** 1-Semester starting and 2-Semester End</b></P></center>
</div><br/>
<?php
if(isset($_SESSION['user'])){
    echo $graph_obj->subject_names($_SESSION['user']);}
else { header('location:index.php');}
?>

<script src="../css/canvasjs.min.js"></script>

</body>
</html>
