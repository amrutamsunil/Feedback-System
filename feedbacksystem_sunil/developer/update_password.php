<?php
extract($_POST);
include('../dbconfig.php');
include ('Developer.php');
$pswd_obj= new dev\Developer($conn);
if(isset($update_password)) {
    if ($op == "" || $cp == "" || $np == "") {
        echo "<script>alert('Fill Every Field !!');</script>";
    } else {
        $err = "";
        @$err = $pswd_obj->update_password($op, $np, $cp, $_SESSION['user']);
        echo "<script>alert('$err');
location='../index.php';
</script>";
    }
    $err = "";

}
if(isset($Go_back)){
    header('location:index.php');

}
?>
<html>
<head>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<style>
    .back {
        border-radius: 5px;
        border: solid 2px black;
        background-color: white;
        box-shadow: 2px 5px 35px 10px lightgrey;
        width: 70%;
        padding: 20px;
    }
</style>
<br/>
<form method="post" style="padding-left: 25%">
    <div class="back">
        <table style="margin-left: 10%;">
            <tr>
                <th><?php echo @$err; ?></th>
            </tr>

            <tr>
                <th height="87">OLD PASSWORD</th>
                <td style="padding-left: 25px"><input type="password" name="op" value="" placeholder="enter your old password" class="form-control" /></td>
            </tr>

            <tr>
                <th height="93">NEW PASSWORD</th>
                <td style="padding-left: 25px"><input type="password" name="np" value="" placeholder="enter your new password" class="form-control"  /></td>
            </tr>

            <tr>
                <th height="90">CONFIRM PASSWORD</th>
                <td style="padding-left: 25px"><input type="password" name="cp" value=""  placeholder="re-enter your new password" class="form-control" /></td>
            </tr>
            <tr >
                <td rowspan="2" style="padding-left: 55%"><input type="submit" value="Update Password" name="update_password" class="btn btn-success"/></td>
                <td rowspan="2" style="padding-left: 65%"><input type="submit" value="Go back" name="Go_back" class="btn btn-primary"/></td>
            </tr>
        </table>
    </div>
</form>

</body>
</html>