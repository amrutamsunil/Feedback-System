<?php
extract($_POST);
if(isset($_POST['bat']))
{
    $op="<h1>Entered condition !!</h1>";
    $op.="<h1>dept : ".$_POST['bat']."</h1>";
    echo $op;
}
else{
    echo "<h1>OOPS NO DEPT I POST</h1>";
}
?>