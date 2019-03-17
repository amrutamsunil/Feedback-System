<?php
/**
 * Created by PhpStorm.
 * User: SUNIL
 * Date: 08-12-2018
 * Time: 17:34
 */
namespace dev;
class Developer
{
    private $conn;
public function __construct($conn)
{
    $this->conn=$conn;
}
    function LoginCheck($username,$password,$err){
        if($username=="" || $password=="")
        {
            $err="fill all the fields first";
        }
        else
        {
            //$password=md5($password);
            $login=mysqli_query($this->conn,"select * from developer where username='$username' and password='$password' ");
            $login_details=mysqli_num_rows($login);

            if($login_details==true)
            {
                $_SESSION['user']=$username;

                header('location:select_dep.php');

            }

            else
            {

                $err="Invalid login details";

            }
        }
        return $err;

    }
    ///////////////////////////////////////////////  sdkvjdbskvjbdsvjbdslvjbdsl not working
    function DeleteFeedbackReport($student_reg){
        $student_reg=mysqli_escape_string($this->conn,$student_reg);
        $s=mysqli_query($this->conn,"select id from students where student_reg='$student_reg' ");
        $student_id=mysqli_fetch_array($s);
        $query="DELETE from feedbacks where student_id=$student_id[0]";
        if(mysqli_query($this->conn,$query)){
            $output="<h1>SUCCESFULLY DELETED ID:$student_id</h1>";}
        else{
            $output="ERROR IN DELETING THE RECORD";}

        return $output;
            }
    function AddStudent($student_reg,$class_id,$name,$password){
    echo "<script>alert('$student_reg , $class_id , $name , $password');</script>";
            $check_stmt=mysqli_query($this->conn,"select * from students where student_reg='$student_reg' ");
            $check=mysqli_num_rows($check_stmt);
            if(!$check) {
                $query = "INSERT INTO students(class_id, student_reg, name, password) values ($class_id,'$student_reg','$name','$password')";
                if (mysqli_query($this->conn, $query)) {
                    $output = "<p style='color: green'>SUCCESFULLY ADDED NEW STUDENT</p>";
                } else {
                    $output = "<p style='color:red'>ERROR IN ADDING</p>";
                }
            }
            else{
                $output="<p style='color: #0E76A8'>STUDENT RECORD ALREADY EXISTS ! </p>";
            }
            return $output;
        }
    function RemoveStudent($student_reg){
        $check_rec=mysqli_query($this->conn,"select id from students where student_reg='$student_reg' 
          and class_id in (select id from classes where isActive=1)");
        $check=mysqli_num_rows($check_rec);
        if($check) {
            $query = "DELETE from students where student_reg='$student_reg' ";
            if (mysqli_query($this->conn, $query)) {
                $output = "<p style='color: green'>SUCCESFULLY DELETED THE STUDENT</p>";
            } else {
                $output = "<p style='color: red'>ERROR IN DELETION</p>";
            }
        }
        else{
            $output="<p style='color: #0e6498'>STUDENT RECORD DOES NOT EXISTS !</p>";
        }
        return $output;
    }
    function update_password($op,$np,$cp,$user){
        $op=mysqli_real_escape_string($this->conn,$op);
        $np=mysqli_real_escape_string($this->conn,$np);
        $cp=mysqli_real_escape_string($this->conn,$cp);
        $user=mysqli_real_escape_string($this->conn,$user);
        //$op=md5($op);
        // $np=md5($np);
        // $cp=md5($cp);
        $que=mysqli_query($this->conn,"select password from developer where username='$user' ");
        $row=mysqli_fetch_array($que);
        $pass=$row['password'];
        if($op!=$pass)
        {
            $err="<font color='red'>You Entered wrong old password</font>";
            $err_="You Entered worng olf passsword!!";
        }

        elseif($np!=$cp)
        {
            $err="<font color='red'>New Password and confirm password must be same</font>";
            $err_="New Password and confirm password must be same !!";
        }
        else
        {
            mysqli_query($this->conn,"update developer set password='$cp' where username='$user'");
            $err="<font color='green'>Password have been Changed successfully !!</font>";
            $err_="Password have been changed successfully !!";
        }
        if($err!=""){
            echo "<script type='text/javascript'>alert('$err_');</script>
    ";}
        return $err;
    }
    function update_student($new_class_id,$old_class_id){
        $students=mysqli_query($this->conn,"select * from students where class_id=$old_class_id ");
        while($student=mysqli_fetch_assoc($students)){
            $student_reg=$student['student_reg'];
            $student_name=$student['name'];
            $student_pswd=$student['password'];
            $query="INSERT INTO students(class_id, student_reg, name, password) VALUES 
                      ($new_class_id,'$student_reg','$student_name','$student_pswd')";
            $status=mysqli_query($this->conn,$query);
            if(!$status)
            {echo"<h1 style='color: red'>Error for student Roll_No :".$student_reg ."  Name ".$student_name."</h1>";}
        }
    }
    function department_list(){
        $options="<option value=''>Select Department</option>";
        $dep=mysqli_query($this->conn,"select * from departments");
        while($dept=mysqli_fetch_assoc($dep)){
            $options.="<option value='".$dept['id']."'>".$dept['short']."</option> ";
        }
        return $options;
    }
    function add_new_faculty($dept_id,$empl_id,$name,$password){
        $check_=mysqli_query($this->conn,"select id from faculties where department_id=$dept_id and employee_number='$empl_id' and name='$name' ");
        $check=mysqli_num_rows($check_);
        if($check==true){
            $status="<h4 style='color:red'>RECORD ALREADY EXISTS !!</h4>";
            return $status;

        }

        $query="INSERT INTO faculties(department_id, employee_number, name,password) VALUES ($dept_id,'$empl_id','$name','$password' )";
        $status=mysqli_query($this->conn,$query);
        if(!$status) {$status="<h4 style='color: red'>ERROR IN ADDING !!</h4>"; return $status;}
        $status="<h4 style='color:green'>SUCCESSFULLY ADDED NEW STAFF RECORD</h4>";

        return $status;
    }
    function  pramote_first_to_sec()
    {
        $class_lists = mysqli_query($this->conn, "SELECT * from classes where isActive=1 and department_id!=7");
        mysqli_query($this->conn,"UPDATE classes SET isActive=0 where classes.isActive=1 ");
        while ($class_list = mysqli_fetch_assoc($class_lists)) {
            $new_sem=$class_list['sem'];
            ++$new_sem;
            $dept_id=$class_list['department_id'];
            $name=$class_list['name'];
            $batch=$class_list['batch'];
            $sec=$class_list['sec'];
        $status=mysqli_query($this->conn,"INSERT INTO classes(department_id,name,sem,sec,batch,isActive) VALUES 
            ($dept_id,'$name',$new_sem,'$sec',$batch,1) ");
            $cls_new=mysqli_query($this->conn,"SELECT id from classes where department_id=$dept_id and 
                batch=$batch and name='$name' and isActive=1 and sem=$new_sem  ");
            $class_new=mysqli_fetch_array($cls_new);
            $this->update_student($class_new['id'],$class_list['id']);
        if(!$status)echo "<h1 style='color: red ;'>Error for class".$name."</h1>";
        }
    }

    function  pramote_sec_to_first()
    {
        $class_ids=array();
        $class_lists = mysqli_query($this->conn, "SELECT * from classes where isActive=1 and department_id!=7");
        while ($class_list = mysqli_fetch_assoc($class_lists)) {
            $id=$class_list['id'];
            mysqli_query($this->conn,"UPDATE classes SET isActive=0 where id=$id ");
            $new_sem=$class_list['sem'];--$new_sem;
            $dept_id=$class_list['department_id'];
            $name=$class_list['name'];
            $sec=$class_list['sec'];
            $batch=$class_list['batch'];++$batch;
            array_push($class_ids,$id);
            $query="INSERT INTO classes(department_id,name,sem,sec,batch,isActive) VALUES 
            ($dept_id,'$name',$new_sem,'$sec',$batch,1)";
            mysqli_query($this->conn,$query);
        }
            foreach ($class_ids as $class_id){
                $query22="select id from classes where name like '%ME%' and id=$class_id";
                $r1=mysqli_query($this->conn,$query22);
                $r=mysqli_num_rows($r1);
                if($r>0){
                    $class_detail=mysqli_query($this->conn,"select * from classes where id=$class_id");
                    $class_details=mysqli_fetch_assoc($class_detail);
                    $dept_id=$class_details['department_id'];
                    $batch=$class_details['batch'];
                    $sec=$class_details['sec'];
                    $cls_id=$class_details['id'];
                    $query12="SELECT id from classes where name like '%ME%' and department_id=$dept_id and 
                batch=$batch and  sec='$sec' and isActive=1  ";
                    $cls_new = mysqli_query($this->conn, $query12);
                    $class_new = mysqli_fetch_assoc($cls_new);
                    $cls_new22 = mysqli_query($this->conn, $query12);
                    $e=mysqli_num_rows($cls_new22);
                    if($e>0){
                        $this->update_student($class_new['id'], $cls_id);
                    }

                }
                else {
                    $p=mysqli_query($this->conn,"select * from classes where id=$class_id");
                    $q=mysqli_fetch_assoc($p);
                    $dept_id_=$q['department_id'];
                    $batch_=$q['batch'];
                    $sec_=$q['sec'];
                    $clss_id=$q['id'];
                    if ($dept_id_ != 7) {
                        $query1 = "SELECT id from classes where name not like '%ME%' and department_id=$dept_id_ and 
                batch=$batch_ and  sec='$sec_' and isActive=1  ";
                        $cls_new_ = mysqli_query($this->conn, $query1);
                        $class_new_ = mysqli_fetch_assoc($cls_new_);
                        $s=mysqli_num_rows($cls_new_);
                        if($s>0){
                            $this->update_student($class_new_['id'], $clss_id);}

                    }
                }

        }
    }

    function delete_feedback_report($student_id){
    $query="SELECT id from students where student_reg=$student_id";
    $status=mysqli_query($this->conn,$query);
    if(!$status) {$err="<h2 style='color: red'>STUDENT NOT FOUND!!</h2>";return $err;}
    $student=mysqli_fetch_array($status);
    $del="DELETE FROM students where id=$student[0] ";
    $status=mysqli_query($this->conn,$del);
    if(!$status){$err="<h2 style='color:red'>UNABLE TO DELETE !!</h2>";}
    else{
        $err="<h2 style='color:red'>DELETED SUCCESSFULLY !!</h2>";
    }
    return $err;
    }



}