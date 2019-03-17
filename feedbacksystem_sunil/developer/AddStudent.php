<?php
include ('../dbconfig.php');
include ('Developer.php');
include('../admin/Admin_Class.php');
$admin_obj= new admin_ns\Admin_Class($conn);
$add_student_obj=new \dev\Developer($conn);
extract($_POST);
if(isset($ok)) {
    if (($reg_no != "") && ($classSelect != "") && ($name != "") && ($pswd != "")) {
        $err = $add_student_obj->AddStudent($reg_no, $classSelect, $name, $pswd);
    } else {
        echo "<script>alert('Fill all the fields with valid characters !!');</script>";
    }
}
    if(isset($_POST['upload'])){
        if($_FILES['insert']['name']){
            $filename=explode(".",$_FILES['insert']['name']);
            if(end($filename)=="csv"){
                $flag=true;
                $list=array();
                $class_id=$_POST['classSelect2'];
                $f=fopen($_FILES['insert']['tmp_name'],"r");
                while($data=fgetcsv($f)) {
                    $student_reg = mysqli_real_escape_string($conn, $data[0]);
                    $name = mysqli_real_escape_string($conn, $data[1]);
                    $password = mysqli_real_escape_string($conn, $data[2]);
                    if($password[0])
                    $check_ = mysqli_query($conn, "select id from students where student_reg='$student_reg' ");
                    $check = mysqli_num_rows($check_);
                    if ($check == true) {
                        echo "<script>alert('Record Already Exists!!');</script>";
                        array_push($list, $student_reg);
                        $flag = false;
                    } else {
                        $query = "INSERT INTO students(class_id, student_reg, name, password) 
                          values ($class_id,'$student_reg','$name','$password')";
                        $ins = mysqli_query($conn, $query);
                        if (!$ins) {
                            echo "<script>alert('Insertion failed for student :$name');</script>";
                            array_push($list, $student_reg);
                            $flag = false;
                        }

                    }
                }
                if($flag){
                    echo "<script>alert('Record Inserted Successfully !!');</script>";
                }
                else{
                    foreach ($list as $a) {
                        echo "Error in Adding Student $a <br/>";
                    }
                }
                fclose($f);

            }

            else{
                    $err="<label class='text-danger'>Please Select a Valid CSV file Only</label>";

            }
        }
    }
?>
<html >
<head>
    <script src="../lib/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/dist/css/select2.css">
    <script src="../vendor/select2/dist/js/select2.full.js"></script>
    <script src="../vendor/Export2Excel.js"></script>
    <script src="../vendor/tableexport-2.1.min.js"></script></head>
<body>
<div class="jumbotron">
<form method="post" style="margin-left: 3%; margin-bottom: 5%">
    <div class="form-group row">
        <label for="sel_cls" class="col-sm-6 col-form-label ">Select Student Class</label>
        <div class="col-sm-6">
            <select class="form-control mdb-select md-form chosen" id="sel_cls" name="classSelect" >
                <?php
                echo $admin_obj->Class_lists($_SESSION['dept_id']);
                ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="roll_no" class="col-sm-6 col-form-label">Enter Student Roll Number</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="reg_no" id="roll_no" placeholder="Registration Number" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="stud_name" class="col-sm-6 col-form-label">Enter Student Name</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="name" id="stud_name" placeholder="Student Name" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="pswds" class="col-sm-6 col-form-label">Enter Student login password</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" name="pswd" id="pswds" placeholder="Password" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="pswdc" class="col-sm-6 col-form-label">Confirm password</label>
        <div class="col-sm-4">
            <input type="password" class="form-control" id="pswdc" placeholder="Confirm Password" required>
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
            <center><button type="submit" name="ok" class="btn btn-primary">SUBMIT</button></center>

        </div>
    </div>
</form>
    <form method="post" enctype="multipart/form-data" style="margin-left: 3%">
        <div class="form-group row">
            <label for="sel_cls" class="col-sm-6 col-form-label ">Select Student Class</label>
            <div class="col-sm-6">
                <select class="form-control mdb-select md-form chosen" id="sel_cls" name="classSelect2" required>
                    <?php
                    echo $admin_obj->Class_lists($_SESSION['dept_id']);
                    ?>
                </select>
            </div>
        </div><br/>
        <div class="form-group row" style="margin-left: 50%">
        <label for="sel_cls" class="col-sm-4 col-form-label ">Upload here</label>
            <div class="col-sm-4">
            <input type="file" name="insert" />
        <br/>
        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
        </div>
        </div>

</form>
</div>
<div class="container">
    <img style="width: 80%;height: 20%;" src="../images/demo_csv.png">
</div>
<?php echo @$err;?>
</body>
<script>
    $(".chosen").select2();
    </script>
</html>