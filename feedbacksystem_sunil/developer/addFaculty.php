<?php
include ('../dbconfig.php');
include ('Developer.php');
$obj_add=new \dev\Developer($conn);
?>
    <html>
    <head>

        <script src="../lib/jquery/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
        <script src="../vendor/select2/dist/js/select2.full.js"></script>
        <script src="../vendor/Export2Excel.js"></script>
        <script src="../vendor/tableexport-2.1.min.js"></script></head>
    <body>
    <form method="post" style="margin:7%">
        <div class="form-group">
            <label for="seldept">CHOOSE DEPARTMENT</label>
            <select class="form-control mdb-select md-form chosen" name="dept_sel" id="seldept" required>
                <?php echo $obj_add->department_list(); ?>
            </select>

        </div>
        <div class="form-group">
            <label for="emp_reg">ENTER EMPLOYEE ID</label>
            <input type="text" name="emp_id" id="emp_reg" class="form-control" placeholder="Ex : E11XXX" required>
        </div>
        <div class="form-group">
            <label for="nam">ENTER NAME</label>
            <input type="text" name="name" id="nam" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pas">ENTER PASSWORD</label>
            <input type="text" name="pass" id="pas" class="form-control" required>
        </div>
        <div class="form-group">
            <?php echo @$status; ?>
        </div>
        <button type="submit" name="sub" class="btn btn-primary">Submit</button>
    </form>
    </body>
    <script>
        $(".chosen").select2();
    </script>
    </html>
<?php
extract($_POST);
if(isset($sub)) {
    echo  $obj_add->add_new_faculty($_POST['dept_sel'], $_POST['emp_id'], $_POST['name'], $_POST['pass']);

}
?>