<?php
/**
 * Created by PhpStorm.
 * User: SUNIL
 * Date: 19-01-2019
 * Time: 14:31
 */
namespace faculty;
class Faculty
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
            $login=mysqli_query($this->conn,"select * from faculties where employee_number='$username' and password='$password' ");
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
    function render_graph($emply_no)
    {
        $dataPoints = array();
        $f_=mysqli_query($this->conn,"select id from faculties where employee_number='$emply_no' ");
        $f_id=mysqli_fetch_array($f_);

        $faculty_subj = mysqli_query($this->conn, "select * from subject_allocations where subject_allocations.faculty_id=$f_id[0] and 
                    subject_allocations.class_id IN (select id from classes where isActive=1)");
        while ($fs = mysqli_fetch_array($faculty_subj)) {
            $feed = mysqli_query($this->conn, "select AVG(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=1 ");
            $feeds = mysqli_fetch_array($feed);
            $sn = mysqli_query($this->conn, "select short,name from subjects where id=" . $fs['subject_id'] . " ");
            $subject_name = mysqli_fetch_array($sn);
            $feeds_=(int)$feeds[0];
            array_push($dataPoints, array("y" => $feeds[0], "label" =>"$subject_name[1]-1","indexLabel"=>"$subject_name[0]-1 : $feeds_%","indexLabelFontColor"=>"white","indexLabelFontSize"=>15,"indexLabelPlacement"=>"inside"));
            $feed = mysqli_query($this->conn, "select AVG(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=2 ");
            $feeds = mysqli_fetch_array($feed);
            $sn = mysqli_query($this->conn, "select short,name from subjects where id=" . $fs['subject_id'] . " ");
            $subject_name = mysqli_fetch_array($sn);
            $feeds_=(int)$feeds[0];
            array_push($dataPoints, array("y" => $feeds[0], "label" =>"$subject_name[1]-2","indexLabel"=>"$subject_name[0]-2 : $feeds_%","indexLabelFontColor"=>"white","indexLabelFontSize"=>15,"indexLabelPlacement"=>"inside"));
        }

        return $dataPoints;
    }
    function class_details($subj_sel){
        $a=mysqli_query($this->conn,"select class_id,subject_id from subject_allocations where id=$subj_sel");
        $classid=mysqli_fetch_assoc($a);
        $s=mysqli_query($this->conn,"select name from subjects where id=".$classid['subject_id']." ");
        $subj_name=mysqli_fetch_array($s);
        $query="select sem,batch,name from classes where id=".$classid['class_id']." ";
        $clas_det=mysqli_query($this->conn,$query);
        $class_detail_=mysqli_fetch_assoc($clas_det);
        array_push($class_detail_,array("short"=>"$subj_name[0]"));
        return $class_detail_;
    }
    function subject_names($faculty_no)
    {
        $output="<table class='table table-responsive table-bordered table-striped table-hover' id='rank' style='margin:15px;'>";
        $output.="<tr class='table-dark'>";
        $output.="<th class='text-capitalize text-dark info'> SHORT NAME </th>";
        $output.="<th class='text-capitalize text-dark info'> FULL NAME </th>";

        $output.="</tr>";
        $f_ = mysqli_query($this->conn, "select id from faculties where employee_number='$faculty_no' ");
        $f_id = mysqli_fetch_array($f_);

        $faculty_subj = mysqli_query($this->conn, "select subject_id from subject_allocations where subject_allocations.faculty_id=$f_id[0] and 
                    subject_allocations.class_id IN (select id from classes where isActive=1)");
        while ($fs = mysqli_fetch_array($faculty_subj)) {
            $sn = mysqli_query($this->conn, "select short,name from subjects where id=" . $fs['subject_id'] . " ");
            $subject_name = mysqli_fetch_array($sn);
            $output.="<tr class='table-dark'>";
            $output.="<td >".$subject_name['short']."</td>";
            $output.="<td >".$subject_name['name']."</td>";
            $output.="</tr>";
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
        $que=mysqli_query($this->conn,"select password from faculties where employee_number='$user' ");
        $row=mysqli_fetch_array($que);
        $pass=$row['password'];
        if($op!=$pass)
        {
            $err="<font color='red'>You Entered wrong old password</font>";
            $err_="You Entered Wrong Password !";
        }

        elseif($np!=$cp)
        {
            $err="<font color='red'>New Password and confirm password must be same !!</font>";
        }
        else
        {
            mysqli_query($this->conn,"update faculties set password='$cp' where employee_number='$user'");
            $err="<font color='green'>Password have been Changed successfully !!</font>";
            $err_="Password have been Changed Successfully !!";
        }
        if($err!=""){
            echo "<script type='text/javascript'>alert('$err_');</script>
    ";}
        return $err;
    }
    function subject_lists($employee_number){
        $options="<option value=''>Class Name : Subject Name</option>";
    $f_id=mysqli_query($this->conn,"select id from faculties where employee_number='$employee_number' ");
    $faculty_id=mysqli_fetch_array($f_id);
    $sa_=mysqli_query($this->conn,"select id,class_id,subject_id from subject_allocations where faculty_id=$faculty_id[0] and 
      class_id in (select id from  classes where isActive=1)");
    while($subject_alloc=mysqli_fetch_assoc($sa_)){
        $a=mysqli_query($this->conn,"select short from subjects where id=".$subject_alloc['subject_id']." ");
        $subj_name=mysqli_fetch_array($a);
        $b=mysqli_query($this->conn,"select name from classes where id=".$subject_alloc['class_id']." ");
        $class_name=mysqli_fetch_array($b);
        $options .= "<option value='" . $subject_alloc['id'] . "'>" .$class_name['name']." : ".$subj_name['short'] . "</option>";

    }
    return $options;


    }
    function faculty_report($subj_alloc_id){
        $c_id_=mysqli_query($this->conn,"select class_id from subject_allocations where id=$subj_alloc_id");
        $c_id=mysqli_fetch_array($c_id_);
        $st_c_=mysqli_query($this->conn,"select count(id) from students where class_id=$c_id[0] ");
        $st_c=mysqli_fetch_array($st_c_);
        $q1_=mysqli_query($this->conn,"select sum(q1),count(q1) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q2_=mysqli_query($this->conn,"select sum(q2),count(q2) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q3_=mysqli_query($this->conn,"select sum(q3),count(q3) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q4_=mysqli_query($this->conn,"select sum(q4),count(q4) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q5_=mysqli_query($this->conn,"select sum(q5),count(q5) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q6_=mysqli_query($this->conn,"select sum(q6),count(q6) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q7_=mysqli_query($this->conn,"select sum(q7),count(q7) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q8_=mysqli_query($this->conn,"select sum(q8),count(q8) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q9_=mysqli_query($this->conn,"select sum(q9),count(q9) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q10_=mysqli_query($this->conn,"select sum(q10),count(q10) from feedbacks where sa_id=$subj_alloc_id and phase=1");
        $q11_=mysqli_query($this->conn,"select sum(q1),count(q1) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q12_=mysqli_query($this->conn,"select sum(q2),count(q2) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q13_=mysqli_query($this->conn,"select sum(q3),count(q3) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q14_=mysqli_query($this->conn,"select sum(q4),count(q4) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q15_=mysqli_query($this->conn,"select sum(q5),count(q5) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q16_=mysqli_query($this->conn,"select sum(q6),count(q6) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q17_=mysqli_query($this->conn,"select sum(q7),count(q7) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q18_=mysqli_query($this->conn,"select sum(q8),count(q8) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q19_=mysqli_query($this->conn,"select sum(q9),count(q9) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q20_=mysqli_query($this->conn,"select sum(q10),count(q10) from feedbacks where sa_id=$subj_alloc_id and phase=2");
        $q1=mysqli_fetch_array($q1_);
        //Using @ symbol to avoid zero divide error
        $q1_avg=(int)(@(($q1[0])/($q1[1]*10))*100);
        $q2=mysqli_fetch_array($q2_);
        $q2_avg=(int)(@(($q2[0])/($q2[1]*10))*100);
        $q3=mysqli_fetch_array($q3_);
        $q3_avg=(int)(@(($q3[0])/($q3[1]*10))*100);
        $q4=mysqli_fetch_array($q4_);
        $q4_avg=(int)(@(($q4[0])/($q4[1]*10))*100);
        $q5=mysqli_fetch_array($q5_);
        $q5_avg=(int)(@(($q5[0])/($q5[1]*10))*100);
        $q6=mysqli_fetch_array($q6_);
        $q6_avg=(int)(@(($q6[0])/($q6[1]*10))*100);
        $q7=mysqli_fetch_array($q7_);
        $q7_avg=(int)(@(($q7[0])/($q7[1]*10))*100);
        $q8=mysqli_fetch_array($q8_);
        $q8_avg=(int)(@(($q8[0])/($q8[1]*10))*100);
        $q9=mysqli_fetch_array($q9_);
        $q9_avg=(int)(@(($q9[0])/($q9[1]*10))*100);
        $q10=mysqli_fetch_array($q10_);
        $q10_avg=(int)(@(($q10[0])/($q10[1]*10))*100);
        $q11=mysqli_fetch_array($q11_);
        $q11_avg=(int)(@(($q11[0])/($q11[1]*10))*100);
        $q12=mysqli_fetch_array($q12_);
        $q12_avg=(int)(@(($q12[0])/($q12[1]*10))*100);
        $q13=mysqli_fetch_array($q13_);
        $q13_avg=(int)(@(($q13[0])/($q13[1]*10))*100);
        $q14=mysqli_fetch_array($q14_);
        $q14_avg=(int)(@(($q14[0])/($q14[1]*10))*100);
        $q15=mysqli_fetch_array($q15_);
        $q15_avg=(int)(@(($q15[0])/($q15[1]*10))*100);
        $q16=mysqli_fetch_array($q16_);
        $q16_avg=(int)(@(($q16[0])/($q16[1]*10))*100);
        $q17=mysqli_fetch_array($q17_);
        $q17_avg=(int)(@(($q17[0])/($q17[1]*10))*100);
        $q18=mysqli_fetch_array($q18_);
        $q18_avg=(int)(@(($q18[0])/($q18[1]*10))*100);
        $q19=mysqli_fetch_array($q19_);
        $q19_avg=(int)(@(($q19[0])/($q19[1]*10))*100);
        $q20=mysqli_fetch_array($q20_);
        $q20_avg=(int)(@(($q20[0])/($q20[1]*10))*100);
        $report=array($q1_avg,$q2_avg,$q3_avg,$q4_avg,$q5_avg,$q6_avg,$q7_avg,$q8_avg,$q9_avg,$q10_avg,
            $q11_avg,$q12_avg,$q13_avg,$q14_avg,$q15_avg,$q16_avg,$q17_avg,$q18_avg,$q19_avg,$q20_avg,$q1[1],$q11[1],$st_c[0]);
        return $report;
        }
        function star_wise_report($faculty_no){
            $questions=array("Does the Faculty come prepared on lessons?","Does the Faculty present the lessons clearly and orderly?","Does the Faculty speak with the voice clarity and good language?",
                "Does the Faculty keep the class under discipline and control?","Does the Faculty give response to student's doubts and questions?"," Does the Faculty possess depth of knowledge in subject?",
                " Does the Faculty give and assignments to improve the studies?","Is the Faculty available outside class hours to clarify the doubts?",
                "  Does the Faculty use the black board and modern techniques effectively?"," Is the Faculty regular and punctual to classes?");
            $output="<table class='table table-responsive table-bordered table-striped table-hover' id='rank' style='margin:15px;'>";
            $output.="<tr class='info'>";
            $output.="<th class='text-capitalize text-dark info'> S.NO </th>";
            $output.="<th class='text-capitalize text-dark info'> QUESTION</th>";
            $output.="<th class='text-capitalize text-dark info'> 5 <i class='glyphicon glyphicon-star'></i></th>";
            $output.="<th class='text-capitalize text-dark info'> 4 <i class='glyphicon glyphicon-star'></i></th>";
            $output.="<th class='text-capitalize text-dark info'> 3 <i class='glyphicon glyphicon-star'></i></th>";
            $output.="<th class='text-capitalize text-dark info'> 2 <i class='glyphicon glyphicon-star'></i></th>";
            $output.="<th class='text-capitalize text-dark info'> 1 <i class='glyphicon glyphicon-star'></i></th>";
            $output.="</tr>";
            $five_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$four_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$three_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$two_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$one_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);
            $six_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$seven_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$eight_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$nine_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);$ten_count=array(1=>0,2=>0,3=>0,4=>0,5=>0);
        $report=array(
            array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0),
            array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0),
            array(5=>0,4=>0,3=>0,2=>0,1=>0),array(5=>0,4=>0,3=>0,2=>0,1=>0));
            $f_=mysqli_query($this->conn,"select id from faculties where employee_number='$faculty_no' ");
            $faculty_id=mysqli_fetch_array($f_);
            $sa_=mysqli_query($this->conn,"select id from subject_allocations where faculty_id=$faculty_id[0] and 
                 class_id in (select id from classes where isActive=1) ");
            while($subj_alloc_id=mysqli_fetch_assoc($sa_)){
                $one_=mysqli_query($this->conn,"select count(q1) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q1=2 ");
                $one=mysqli_fetch_array($one_);
                $one_count[1]+=$one[0];
                $one_=mysqli_query($this->conn,"select count(q1) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q1=4 ");
                $one=mysqli_fetch_array($one_);
                $one_count[2]+=$one[0];
                $one_=mysqli_query($this->conn,"select count(q1) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q1=6 ");
                $one=mysqli_fetch_array($one_);
                $one_count[3]+=$one[0];
                $one_=mysqli_query($this->conn,"select count(q1) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q1=8 ");
                $one=mysqli_fetch_array($one_);
                $one_count[4]+=$one[0];
                $one_=mysqli_query($this->conn,"select count(q1) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q1=10 ");
                $one=mysqli_fetch_array($one_);
                $one_count[5]+=$one[0];
                for($i=5;$i>=1;$i--){
                    $report[0][$i]=$one_count[$i];
                }
                $two_=mysqli_query($this->conn,"select count(q2) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q2=2 ");
                $two=mysqli_fetch_array($two_);
                $two_count[1]+=$two[0];
                $two_=mysqli_query($this->conn,"select count(q2) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q2=4 ");
                $two=mysqli_fetch_array($two_);
                $two_count[2]+=$two[0];
                $two_=mysqli_query($this->conn,"select count(q2) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q2=6 ");
                $two=mysqli_fetch_array($two_);
                $two_count[3]+=$two[0];
                $two_=mysqli_query($this->conn,"select count(q2) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q2=8 ");
                $two=mysqli_fetch_array($two_);
                $two_count[4]+=$two[0];
                $two_=mysqli_query($this->conn,"select count(q2) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q2=10 ");
                $two=mysqli_fetch_array($two_);
                $two_count[5]+=$two[0];
                for($i=5;$i>=1;$i--){
                    $report[1][$i]=$two_count[$i];
                }
                $three_=mysqli_query($this->conn,"select count(q3) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q3=2 ");
                $three=mysqli_fetch_array($three_);
                $three_count[1]+=$three[0];
                $three_=mysqli_query($this->conn,"select count(q3) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q3=4 ");
                $three=mysqli_fetch_array($three_);
                $three_count[2]+=$three[0];
                $three_=mysqli_query($this->conn,"select count(q3) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q3=6 ");
                $three=mysqli_fetch_array($three_);
                $three_count[3]+=$three[0];
                $three_=mysqli_query($this->conn,"select count(q3) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q3=8");
                $three=mysqli_fetch_array($three_);
                $three_count[4]+=$three[0];
                $three_=mysqli_query($this->conn,"select count(q3) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q3=10");
                $three=mysqli_fetch_array($three_);
                $three_count[5]+=$three[0];
                for($i=5;$i>=1;$i--){
                    $report[2][$i]=$three_count[$i];
                }
                $four_=mysqli_query($this->conn,"select count(q4) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q4=2 ");
                $four=mysqli_fetch_array($four_);
                $four_count[1]+=$four[0];
                $four_=mysqli_query($this->conn,"select count(q4) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q4=4");
                $four=mysqli_fetch_array($four_);
                $four_count[2]+=$four[0];
                $four_=mysqli_query($this->conn,"select count(q4) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q4=6 ");
                $four=mysqli_fetch_array($four_);
                $four_count[3]+=$four[0];
                $four_=mysqli_query($this->conn,"select count(q4) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q4=8");
                $four=mysqli_fetch_array($four_);
                $four_count[4]+=$four[0];
                $four_=mysqli_query($this->conn,"select count(q4) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q4=10");
                $four=mysqli_fetch_array($four_);
                $four_count[5]+=$four[0];
                for($i=5;$i>=1;$i--){
                    $report[3][$i]=$four_count[$i];
                }
                $five_=mysqli_query($this->conn,"select count(q5) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q5=2");
                $five=mysqli_fetch_array($five_);
                $five_count[1]+=$five[0];
                $five_=mysqli_query($this->conn,"select count(q5) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q5=4 ");
                $five=mysqli_fetch_array($five_);
                $five_count[2]+=$five[0];
                $five_=mysqli_query($this->conn,"select count(q5) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q5=6 ");
                $five=mysqli_fetch_array($five_);
                $five_count[3]+=$five[0];
                $five_=mysqli_query($this->conn,"select count(q5) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q5=8 ");
                $five=mysqli_fetch_array($five_);
                $five_count[4]+=$five[0];
                $five_=mysqli_query($this->conn,"select count(q5) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q5=10 ");
                $five=mysqli_fetch_array($five_);
                $five_count[5]+=$five[0];
                for($i=5;$i>=1;$i--){
                    $report[4][$i]=$five_count[$i];
                }
                $six_=mysqli_query($this->conn,"select count(q6) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q6=2 ");
                $six=mysqli_fetch_array($six_);
                $six_count[1]+=$six[0];
                $six_=mysqli_query($this->conn,"select count(q6) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q6=4");
                $six=mysqli_fetch_array($six_);
                $six_count[2]+=$six[0];
                $six_=mysqli_query($this->conn,"select count(q6) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q6=6 ");
                $six=mysqli_fetch_array($six_);
                $six_count[3]+=$six[0];
                $six_=mysqli_query($this->conn,"select count(q6) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q6=8 ");
                $six=mysqli_fetch_array($six_);
                $six_count[4]+=$six[0];
                $six_=mysqli_query($this->conn,"select count(q6) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q6=10 ");
                $six=mysqli_fetch_array($six_);
                $six_count[5]+=$six[0];
                for($i=5;$i>=1;$i--){
                    $report[5][$i]=$six_count[$i];
                }
                $seven_=mysqli_query($this->conn,"select count(q7) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q7=2 ");
                $seven=mysqli_fetch_array($seven_);
                $seven_count[1]+=$seven[0];
                $seven_=mysqli_query($this->conn,"select count(q7) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q7=4 ");
                $seven=mysqli_fetch_array($seven_);
                $seven_count[2]+=$seven[0];
                $seven_=mysqli_query($this->conn,"select count(q7) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q7=6 ");
                $seven=mysqli_fetch_array($seven_);
                $seven_count[3]+=$seven[0];
                $seven_=mysqli_query($this->conn,"select count(q7) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q7=8 ");
                $seven=mysqli_fetch_array($seven_);
                $seven_count[4]+=$seven[0];
                $seven_=mysqli_query($this->conn,"select count(q7) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q7=10 ");
                $seven=mysqli_fetch_array($seven_);
                $seven_count[5]+=$seven[0];
                for($i=5;$i>=1;$i--){
                    $report[6][$i]=$seven_count[$i];
                }
                $eight_=mysqli_query($this->conn,"select count(q8) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q8=2 ");
                $eight=mysqli_fetch_array($eight_);
                $eight_count[1]+=$eight[0];
                $eight_=mysqli_query($this->conn,"select count(q8) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q8=4 ");
                $eight=mysqli_fetch_array($eight_);
                $eight_count[2]+=$eight[0];
                $eight_=mysqli_query($this->conn,"select count(q8) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q8=6 ");
                $eight=mysqli_fetch_array($eight_);
                $eight_count[3]+=$eight[0];
                $eight_=mysqli_query($this->conn,"select count(q8) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q8=8 ");
                $eight=mysqli_fetch_array($eight_);
                $eight_count[4]+=$eight[0];
                $eight_=mysqli_query($this->conn,"select count(q8) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q8=10 ");
                $eight=mysqli_fetch_array($eight_);
                $eight_count[5]+=$eight[0];
                for($i=5;$i>=1;$i--){
                    $report[7][$i]=$eight_count[$i];
                }
                $nine_=mysqli_query($this->conn,"select count(q9) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q9=2 ");
                $nine=mysqli_fetch_array($nine_);
                $nine_count[1]+=$nine[0];
                $nine_=mysqli_query($this->conn,"select count(q9) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q9=4 ");
                $nine=mysqli_fetch_array($nine_);
                $nine_count[2]+=$nine[0];
                $nine_=mysqli_query($this->conn,"select count(q9) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q9=6 ");
                $nine=mysqli_fetch_array($nine_);
                $nine_count[3]+=$nine[0];
                $nine_=mysqli_query($this->conn,"select count(q9) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q9=8 ");
                $nine=mysqli_fetch_array($nine_);
                $nine_count[4]+=$nine[0];
                $nine_=mysqli_query($this->conn,"select count(q9) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q9=10 ");
                $nine=mysqli_fetch_array($nine_);
                $nine_count[5]+=$nine[0];
                for($i=5;$i>=1;$i--){
                    $report[8][$i]=$nine_count[$i];
                }
                $ten_=mysqli_query($this->conn,"select count(q10) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q10=2 ");
                $ten=mysqli_fetch_array($ten_);
                $ten_count[1]+=$ten[0];
                $ten_=mysqli_query($this->conn,"select count(q10) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q10=4 ");
                $ten=mysqli_fetch_array($ten_);
                $ten_count[2]+=$ten[0];
                $ten_=mysqli_query($this->conn,"select count(q10) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q10=6 ");
                $ten=mysqli_fetch_array($ten_);
                $ten_count[3]+=$ten[0];
                $ten_=mysqli_query($this->conn,"select count(q10) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q10=8");
                $ten=mysqli_fetch_array($ten_);
                $ten_count[4]+=$ten[0];
                $ten_=mysqli_query($this->conn,"select count(q10) from feedbacks 
                                                      where sa_id=".$subj_alloc_id['id']." and q10=10 ");
                $ten=mysqli_fetch_array($ten_);
                $ten_count[5]+=$ten[0];
                for($i=5;$i>=1;$i--){
                    $report[9][$i]=$ten_count[$i];
                }

            }

            for($j=0;$j<10;$j++){
                $output.="<tr>";
                $output.="<td>".($j+1)."</td>";
                $output.="<td>".$questions[$j]."</td>";
                for($k=5;$k>0;$k--){
                $output.="<td>".$report[$j][$k]."</td>";
                }
                $output.="</tr>";
            }
            $output.="</table>";
            return $output;
        }
        function  subject_name($subject_alloc_id){
        $t1=mysqli_query($this->conn,"select subject_id from subject_allocations where id=$subject_alloc_id");
        $temp=mysqli_fetch_array($t1);
        $t2=mysqli_query($this->conn,"select name from subjects where id=$temp[0]");
        $temp_=mysqli_fetch_array($t2);
        return $temp_[0];
        }

}