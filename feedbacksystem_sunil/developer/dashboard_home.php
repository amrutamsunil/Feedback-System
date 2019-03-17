<html>
    <!-- Favicons-->
    <?php
     $cse_count=0;$eee_count=0;$eee_count=0;$civil_count=0;$mech_count=0;$mba_count=0;$freshers=0;$ece_count=0;
    function dep_feed_count($conn,$dept_id){
        $count=0;
        $class_list = mysqli_query($conn, "select id from classes where department_id=$dept_id and isActive=1");
        while($classes=mysqli_fetch_assoc($class_list)){
            $sa_list=mysqli_query($conn,"select id from subject_allocations where class_id=".$classes['id']." ");
            while($sa_lists=mysqli_fetch_assoc($sa_list)){
                $feedbacks=mysqli_query($conn,"select count(*) from feedbacks where sa_id=".$sa_lists['id'] ."   ");
                $count_=mysqli_fetch_array($feedbacks);
                $count+= $count_[0];
    }
    }
    return $count;
    }

    function render_graph($conn){
        global $cse_count,$eee_count,$eee_count,$civil_count,$mech_count,$mba_count,$freshers,$ece_count;
        $cse_count=dep_feed_count($conn,1);
        $ece_count=dep_feed_count($conn,2);
        $mech_count=dep_feed_count($conn,3);
        $civil_count=dep_feed_count($conn,4);
        $eee_count=dep_feed_count($conn,5);
        $mba_count=dep_feed_count($conn,6);
        $freshers=dep_feed_count($conn,7);

    $feedback_list =mysqli_query($conn,"select count(*) from feedbacks where sa_id in (select id from subject_allocations
    where class_id in (select  id from classes where  isActive=1))");

    $feedback_count = mysqli_fetch_array($feedback_list);
        $dataPoints=array();
        array_push($dataPoints,array("y"=>$cse_count,"label"=>"CSE","indexLabel"=>"CSE : $cse_count","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$ece_count,"label"=>"ECE","indexLabel"=>"ECE : $ece_count","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$mech_count,"label"=>"MECH","indexLabel"=>"MECH : $mech_count","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$civil_count,"label"=>"CIVIL","indexLabel"=>"CIVIL : $civil_count","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$eee_count,"label"=>"EEE","indexLabel"=>"EEE : $eee_count","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$mba_count,"label"=>"MBA","indexLabel"=>"MBA : $mba_count","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$freshers,"label"=>"S&H","indexLabel"=>"S&H : $freshers","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));
        array_push($dataPoints,array("y"=>$feedback_count[0],"label"=>"TOTAL COUNT","indexLabel"=>"TOTAL : $feedback_count[0]","indexLabelFontSize"=>15,"indexLabelFontColor"=>"white","indexLabelPosition"=>"inside"));

      /*  $dataPoints = array(
        array("y" => $cse_count, "label" => "CSE"),
        array("y" => $ece_count, "label" => "ECE"),
        array("y" => $mech_count, "label" => "MECH"),
        array("y" => $civil_count, "label" => "CIVIL"),
        array("y" => $eee_count, "label" => "EEE"),
        array("y" => $mba_count, "label" => "MBA"),
            array("y" => $freshers, "label" => "FRESHERS"),
            array("y" => $feedback_count[0], "label" => "Total Number of Feedback Given"),
    );*/
    return $dataPoints;
    }
    ?>
    <head>
    <title>Admin</title>

    </head>
<h1 align="center" style=" color: dodgerblue;text-shadow: 4px 4px 6px lightblue;"><a href="">DEVELOPER DASHBOARD</a></h1>


<body>

<?php
$conn=mysqli_connect("localhost","root","","try");
$dataPoints=render_graph($conn);
?>
<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "STATISTICS"
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
<h6><b>**Graph Renders the data of current semester</b></h6>
<div style="margin-left: 30%">
<script src="../css/canvasjs.min.js"></script>
<?php
echo "<h6 style='color:black'>Total Number of Feedbacks of CSE  :    $cse_count</h6>";
echo "<h6 style='color:black'>Total Number of Feedbacks of ECE: $ece_count</h6>";
echo "<h6 style='color:black'>Total Number of Feedbacks of MECH : $mech_count</h6>";
echo "<h6 style='color:black'>Total Number of Feedbacks of CIVIL   : $civil_count</h6>";
echo "<h6 style='color:black'>Total Number of Feedbacks of EEE: $eee_count</h6>";
echo "<h6 style='color:black'>Total Number of Feedbacks of MBA: $mba_count</h6>";
echo "<h6 style='color:black'>Total Number of Feedbacks of 1st YEAR: $freshers</h6>";?>
</div>
</body>
</html>
