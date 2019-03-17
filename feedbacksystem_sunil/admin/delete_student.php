<script>
    a=confirm("Are you sure?");
    if(!a){
        <?php
        header('location:dashboard.php?info=display_student');
        ?>
    }
</script>
<?php
include('../dbconfig.php');
	$info=$_GET['id'];
	echo"<h1>Value of Info = ".$info."</h1>";
	mysqli_query($conn,"delete from students where students.id='$info'");
	header('location:dashboard.php?info=display_student');
?>