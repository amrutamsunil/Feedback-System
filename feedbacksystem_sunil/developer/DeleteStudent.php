<?php
include ('../dbconfig.php');
include ('Developer.php');
$del_student=new \dev\Developer($conn);
extract($_POST);
if(isset($del)){
    if($reg_no!=""){
        echo  "<script>alert('Are You Sure ?');</script>";
    $err=$del_student->RemoveStudent($reg_no);}
    else {
        echo "<script>alert('Fill the Field with valid characters !!');</script>";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <title>DELETE STUDENT</title>
    <link href="../img/miet.png" rel="icon">
</head>
<body>
<div class="jumbotron">

    <form method="post">
    <div class="form-group row">
        <label for="roll_no" class="col-sm-6 col-form-label">Enter Student Roll Number</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="reg_no" id="roll_no" placeholder="Registration Number" required>
        </div>
    </div>
        <div class="form-group row">
            <Center><?php echo @$err;?></Center>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <center><button type="reset" name="reset" class="btn btn-primary">RESET</button></center>
            </div>
            <div class="col-sm-6">
                <center><button type="submit" name="del" class="btn btn-danger" ">DELETE</button></center>
            </div>
        </div>
    </form>
</div>
</body>
</html>