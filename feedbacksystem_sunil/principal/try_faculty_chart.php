<?php
include ('../dbconfig.php');
include ('../developer/Developer.php');
$p_obj=new \dev\Developer($conn);
?>
<html>
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>    <title></title>
</head>
<body>
<div class="container-fluid">
<div class="form-group">
    <label for="seldept">CHOOSE DEPARTMENT</label>
    <select class="form-control mdb-select md-form chosen" name="dept_sel" id="aabb" required>
        <?php echo $p_obj->department_list(); ?>
    </select>
</div>
</div>
<div id="content" class="container-fluid">
    
</div>
</body>
<script type="text/javascript">
    $(document).ready(
        function () {
            $('#aabb').on('change',function () {
                var batch ="<?php  ?>";
            });


</script>
</html>