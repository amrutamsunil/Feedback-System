<!DOCTYPE HTML>
<html>
<head>
    <!-- Favicons-->
    <link href="../img/miet.png" rel="icon">
    <style>
        .vasanth {
            background-color: white;
            width: 300px;
            border: 2px solid lightgrey;
            padding: 40px;
            margin: 1px;
            border-radius:10px;
            padding-right: 30% ;
            margin-left: 65%;
        }
    </style>

    <?php
    $feedback_count_two="";$feedback_count_one="";$student_count="";$faculty_count="";
    function render_graph($conn,$dept_id){
        global $feedback_count_two,$feedback_list,$feedback_count_one,$student_count,$faculty_count;
        $faculty_list = mysqli_query($conn, "select id from faculties where department_id=$dept_id ");
    $faculty_count = mysqli_num_rows($faculty_list);


    $student_list = mysqli_query($conn, "select students.id from students  where class_id IN (select classes.id from classes where department_id=$dept_id )");
    $student_count = mysqli_num_rows($student_list);



    $feedback_list = mysqli_query($conn, "select id from feedbacks where student_id IN (select students.id from students  where class_id IN 
         (select classes.id from classes where department_id=$dept_id and isActive=1)) and phase=1 ");
    $feedback_count_one = mysqli_num_rows($feedback_list);
        $feedback_list = mysqli_query($conn, "select id from feedbacks where student_id IN (select students.id from students  where class_id IN 
         (select classes.id from classes where department_id=$dept_id and isActive=1)) and phase=2 ");
        $feedback_count_two = mysqli_num_rows($feedback_list);



    $dataPoints = array(
        array("y" => $faculty_count, "label" => "Total Number of Faculty"),
        array("y" => $student_count, "label" => "Total Number of Student "),
        array("y" => $feedback_count_one, "label" => "Total Number of Feedback for Phase-1"),
        array("y" => $feedback_count_two, "label" => "Total Number of Feedback for Phase-2"),

    );
    return $dataPoints;

    }
    ?>
    <title>Admin</title>
<h1 align="center" style=" color: dodgerblue;text-shadow: 4px 4px 6px lightblue;font-family: 'Adobe Caslon Pro'" ><a href="">ADMIN DASHBOARD</a></h1>


</head>
<body>

<?php

if($_SESSION['dept_id']) {
$conn=mysqli_connect("localhost","root","","try");
$dept_id=(int)$_SESSION['dept_id'];
$dataPoints=render_graph($conn,$dept_id);}

else {
echo "<h1 style='color:red;'>YOU HAVE NOT SELECTED ANY DEPARTMENT</h1>";
include ('../index.php');
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

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<br/>
<div style="font-family: 'Adobe Caslon Pro';font-size: 20px;border: dashed 2px lightgrey;">
    <center>
<p><b>**Graph renders the aggregate of current semester </b></p>
<?php  echo "<h5 style='color:black'>Total Number feedback given in INITIAL PHASE  : $feedback_count_one</h5>";
    echo "<h5 style='color:black'>Total Number feedback given in FINAL PHASE  : $feedback_count_two</h5>";
    echo "<h5 style='color:black'>Total Number of Student : $student_count</h5>";
    echo "<h5 style='color:black'>Total Number of Faculty : $faculty_count</h5>";?>

<script src="../css/canvasjs.min.js"></script></center>
</div>
</body>
</html>
