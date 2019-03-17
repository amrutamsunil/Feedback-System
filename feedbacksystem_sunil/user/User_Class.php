<?php
namespace user_ns;
class User_Class{
    private $conn;
    public function __construct($conn){
        $this->conn=$conn;
    }
    function check_feedback_submit($subject_selected,$users,$phase){
        $faculty_handling=mysqli_query($this->conn,"select id,faculty_id from subject_allocations where subject_id=$subject_selected and class_id=".$users['class_id']." ");
        $faculties=mysqli_fetch_array($faculty_handling);
        $feed=mysqli_query($this->conn,"select id from feedbacks where student_id=".$users['id']." and sa_id=".$faculties['id']." and phase=$phase ");
        $feedbacks=mysqli_fetch_row($feed);
        if($feedbacks==true){
            return false ;
        } else {return true;}}

    function fill_subjects($users,$phase){
        $output="<option value=''>Select Subject </option>";
        $query="select id,short from subjects where id IN (select subject_id from subject_allocations where class_id=".$users['class_id'].") ";
        $subjects_get=mysqli_query($this->conn,$query);
        $red_flag="background-color:#FF9999;color:black;";
        $green_flag="background-color:#00FA9A;color:black;";
        while($subjects=mysqli_fetch_array($subjects_get)) {
            $f="select faculty_id from subject_allocations where class_id=".$users['class_id']." and subject_id=".$subjects['id']." ";
            $f_i=mysqli_query($this->conn,$f);
            $faculty_id=mysqli_fetch_array($f_i);
            $f_query="select name from faculties where id=$faculty_id[0] ";
            $f_n=mysqli_query($this->conn,$f_query);
            $faculty_name=mysqli_fetch_array($f_n);
            $faculty_name=$faculty_name[0];
            if(!($this->check_feedback_submit($subjects['id'],$users,$phase))){
                $output.="<option style=$red_flag value=".$subjects['id'].">".$subjects['short']."-$faculty_name</option>";
            }else{
                $output.="<option style=$green_flag value=".$subjects['id'].">".$subjects['short']."-$faculty_name</option>";}
        }
        return $output;
    }

    function submit_feedback($subject_selected,$users,$check,$ratings,$phase){
        if($subject_selected) {
            $subject_detail=mysqli_query($this->conn,"select name from subjects where id=$subject_selected");
            $subject_name=mysqli_fetch_assoc($subject_detail);
            $subject_name=$subject_name['name'];
        }
        if(!($this->check_feedback_submit($subject_selected,$users,$phase))){
            $check="You have already given feedback to $subject_name";
        }
        else{
            $faculty_handling_=mysqli_query($this->conn,"select id,faculty_id from subject_allocations where subject_id=$subject_selected and class_id=".$users['class_id']." ");
            $sub_alloc_id=mysqli_fetch_array($faculty_handling_);
            $sum_feed=array_sum($ratings);
            $sum_feed=$sum_feed*2;
            $query="INSERT INTO feedbacks(student_id, sa_id, q1, q2, q3, q4, q5, q6, q7, q8, q9, q10,sum,phase) 
            values (".$users['id'].",".$sub_alloc_id['id'].",($ratings[0]*2),
        ($ratings[1]*2),($ratings[2]*2),($ratings[3]*2),($ratings[4]*2),($ratings[5]*2),($ratings[6]*2),($ratings[7]*2),($ratings[8]*2),($ratings[9]*2),$sum_feed,$phase)";
            $feedback_submit=mysqli_query($this->conn,$query);
            if($feedback_submit){
                $check="Sucessfully submitted feedback for $subject_name";
            }
            else { $check="Something Went Worng!! Please Try Again We appreciate Your Patience ";
            }
        }
        return $check;
    }
    public function fetch_user($user){
        $sql=mysqli_query($this->conn,"select * from students where student_reg='$user' and class_id in 
              (select id from classes where classes.isActive=1) ");
        $users=mysqli_fetch_assoc($sql);
        return $users;
    }
    public function feedback_count(){
        $fc=mysqli_query($this->conn,"select count(ID) from feedbacks ");
        $count=mysqli_fetch_array($fc);
        return $count[0];
    }
    public function LoginCheck($username,$password,$err){
        if($username=="" || $password=="")
        {
            $err="fill all the fields first";
        }
        else
        {
            /*$pass=md5($p);*/


            $login=mysqli_query($this->conn,"select * from students where student_reg='$username' and password='$password' 
                and class_id in (select id from classes where classes.isActive=1)");

            $login_details=mysqli_num_rows($login);

            if($login_details==true)
            {
                $_SESSION['user']=$username;
                header('location:home_page.php');
            }

            else
            {

                $err="Invalid login details";

            }
        }
        return $err;
    }
    function update_password($op,$np,$cp,$user){
        $op=mysqli_real_escape_string($this->conn,$op);
        $np=mysqli_real_escape_string($this->conn,$np);
        $cp=mysqli_real_escape_string($this->conn,$cp);
        $user=mysqli_real_escape_string($this->conn,$user);
        //$op=md5($op);
        // $np=md5($np);
        // $cp=md5($cp);
        $que=mysqli_query($this->conn,"select password from students where student_reg='$user' ");
        $row=mysqli_fetch_array($que);
        $pass=$row['password'];
        if($op!=$pass)
        {
            $err="<font color='red'>You Entered wrong old password</font>";
            $err_="You Entered wrong old password!!";
        }

        elseif($np!=$cp)
        {
            $err="<font color='red'>New Password and confirm password must be same</font>";
            $err_="New Password and confirm password must be same!!";
        }
        else
        {
            mysqli_query($this->conn,"update students set password='$cp' where student_reg='$user'");
            $err="<font color='green'>Password have been Changed successfully !!</font>";
            $err_="Password have been Changed successfully !! New Password : $np ";
        }
            if($err!=""){
                echo "<script type='text/javascript'>alert('$err_');</script>
    ";}
                return $err;
    }
}
?>