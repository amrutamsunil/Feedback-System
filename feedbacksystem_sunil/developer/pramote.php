<?php
include ('../dbconfig.php');
include ('Developer.php');
$promote_obj=new \dev\Developer($conn);
set_time_limit(0);
extract($_POST);
if(isset($pramote)){
    $promote_obj->pramote_first_to_sec();

}
if(isset($pramote_nxt)){
    $promote_obj->pramote_sec_to_first();
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
</head>
<body>
<div class="jumbotron">

    <form method="post">
        <div class="form-group row">
            <div class="col-sm-6">
                <center><button type="submit" name="pramote" class="btn btn-danger">PROMOTE ODD-EVEN SEM </button></center>
            </div>
            <div class="col-sm-6">
                <center><button type="submit" name="pramote_nxt" class="btn btn-danger">PROMOTE EVEN-ODD SEM</button></center>
            </div>
        </div>
    </form>
</div>
</body>
</html>