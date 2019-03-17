<?php
include('dbconfig.php');
	$info=$_GET['id'];
	echo "<script>
    a=confirm('Delete this record ? ');
    if(!a){
        header('location:dashboard.php?info=show_faculty');
            }
</script> ";

	mysqli_query($conn,"delete from faculties where faculties.id=$info ");
	header('location:dashboard.php?info=show_faculty');
?>