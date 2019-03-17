<html>
<head>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Change Feedback Record</title>
</head>
<body>
<div class="jumbotron">
<form method="post">
<div class="row">
    <div class="col-md-6">
        <label for="Student_id" >ENTER STUDENT ROLL NUMBER </label>
    </div>
    <div class="col-md-6">
        <input id="Student_id" name="student_reg" placeholder="E1XXXXXX" required>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br/><br/><br/><br/>
            <center><input type="submit" class="btn btn-primary" name="submit" value="SUBMIT" > </center></div>
    </div>
    <div class="row">
        <center>
            <?php echo @$err; ?>
        </center>
    </div>
</div>
</form>
</div>
</body>
</html>
<?php
include ('../dbconfig.php');
include ('Developer.php');
extract($_POST);
$alter_feed_obj=new \dev\Developer($conn);
if(isset($submit)) {
    if ($submit == "") {
        echo "
        <script>
        alert('Enter the student roll number !!');
        </script>
        ";
    } else {
        $err = $alter_feed_obj->delete_feedback_report($_POST['student_reg']);
    }
}
?>