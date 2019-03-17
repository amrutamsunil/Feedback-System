<?php
namespace admin_ns;
    class Admin_Class
    {
        private $conn;

        public function __construct($conn)
        {
            $this->conn = $conn;
        }
        function LoginCheck($username,$password,$err,$dept_id){
            if($username=="" || $password=="")
            {
                $err="fill all the fields first";
            }
            else
            {
                //$password=md5($password);
                if($username=="principal"){
                    $login=mysqli_query($this->conn,"select * from principal where username='$username' and password='$password' ");
                    $login_details=mysqli_num_rows($login);
                }
                else {
                    $login = mysqli_query($this->conn, "select * from admin where name='$username' and password='$password' and dept_id=$dept_id");
                    $login_details = mysqli_num_rows($login);
                }
                if($login_details==true)
                {
                    $_SESSION['user']=$username;

                    header('location:dashboard.php');

                }

                else
                {

                    $err="Invalid login details";

                }
            }
            return $err;

        }
        function Class_lists($dept_id)
        {
            $options = "<option value=''>Select Class</option> ";
            $cl = mysqli_query($this->conn, "select * from classes where department_id=$dept_id and isActive=1 ");
            while ($class_lists = mysqli_fetch_array($cl)) {
                $options .= "<option value='" . $class_lists['id'] . "'>" . $class_lists['name'] . "</option>";
            }
            return $options;
        }

        function class_wise_report($class_select)
        {
            $tbl="<table id='class_wise' class='table table-bordered'>";
        $tbl.="<tr class='primary'>";
            $tbl.="<th class='text-capitalize text-dark info'>S.NO </th>";
           $tbl.="<th class='text-capitalize text-dark info'>CLASS NAME </th>";
           $tbl.="<th class='text-capitalize text-dark info'>SUBJECT NAME </th>";
           $tbl.="<th class='text-capitalize text-dark info'>FACULTY NAME</th>";
           $tbl.="<th class='text-capitalize text-dark info'>NO. OF STUDENT</th>";
           $tbl.="<th class='text-capitalize text-dark info'>PHASE I</th>";
           $tbl.="<th class='text-capitalize text-dark info'>NO. OF STUDENT</th>";
           $tbl.="<th class='text-capitalize text-dark info'>PHASE II</th>";
           $tbl.="<th class='text-capitalize text-dark info'>AVG</th>";
        $tbl.="</tr>";
            $s_no=1;
            $class = mysqli_query($this->conn, "select * from subject_allocations where subject_allocations.class_id=$class_select ");
            while ($classes = mysqli_fetch_array($class)) {
                $subj = mysqli_query($this->conn, "select name from subjects where subjects.id=" . $classes['subject_id'] . " ");
                $subjects = mysqli_fetch_array($subj);
                $fn = mysqli_query($this->conn, "select name from faculties where faculties.id=" . $classes['faculty_id'] . " ");
                $faculties = mysqli_fetch_array($fn);
                $a = mysqli_query($this->conn, "select AVG(sum),count(sum) from feedbacks where sa_id=" . $classes['id'] . " and phase=1 ");
                $agg = mysqli_fetch_array($a);
                $st = mysqli_query($this->conn, "select count(id) from students where class_id=$class_select ");
                $st_tot = mysqli_fetch_array($st);
                $a1 = mysqli_query($this->conn, "select AVG(sum),count(sum) from feedbacks where sa_id=" . $classes['id'] . " and phase=2 ");
                $agg1 = mysqli_fetch_array($a1);
                $class_det=mysqli_query($this->conn,"select name from classes WHERE id=".$classes['class_id']." ");
                $class_detail=mysqli_fetch_assoc($class_det);
                $tbl .= "<tr >";
                $tbl .= "<td >" . $s_no . "</td>";
                $tbl .= "<td >" . $class_detail['name'] . "</td>";
                $tbl .= "<td >" . $subjects['name'] . "</td>";
                $tbl .= "<td >" . $faculties['name'] . "</td>";
                $tbl .= "<td >" . $agg[1] ."  /  ".$st_tot[0]."</td>";
                if($agg[0]=="") {
                    $tbl .= "<td > -NIL- </td>";
                }else{
                    $tbl .= "<td >" . (int)$agg[0] . "%</td>";}
                $tbl .= "<td >" . $agg1[1] . "  /  ".$st_tot[0]."</td>";
                if($agg1[0]=="") {
                    $tbl .= "<td > -NIL- </td>";
                }else{
                    $tbl .= "<td >" . (int)$agg1[0] . "%</td>";}
                $tbl .= "<td >" . (int)(($agg[0]+$agg1[0])/2) . "%</td>";
                $tbl .= "</tr>";

                ++$s_no;
            }
            $tbl.="</table>";
            return $tbl;
        }

        function all_faculty_wise_report($dept_id){
            $result="";$output="";
            $fac=mysqli_query($this->conn,"select id from faculties where department_id=$dept_id ");
            while($fac_id=mysqli_fetch_array($fac)){
               $output= $this->faculty_wise_report_($fac_id[0]);
               $result.=$output;
            }
            return $result;
        }

        public function faculty_lists($dept_id)
        {
            $options = "<option value=''>Select Faculty</option>";
            $query = "select * from faculties where department_id=$dept_id";
            $fa = mysqli_query($this->conn, $query);
            if (!$fa) {
                $options .= "<option>error</option>";
            }
            while ($fnames = mysqli_fetch_array($fa)) {
                $options .= "<option value='" . $fnames['id'] . "'>" . $fnames['name'] . "</option>";
            }
            return $options;
        }

        function faculty_wise_report($staff_select)
        {
         $tbl=  " <table id='faculty_wise' class='table table-bordered'>";
    $tbl.="<tr class='primary'>";
        $tbl.="<th  class='text-capitalize text-dark info'>S.NO</th>";
        $tbl.="<th  class='text-capitalize text-dark info'>DEPARTMENT</th>";
        $tbl.="<th  class=' text-capitalize text-dark info'>CLASS NAME </th>";
        $tbl.="<th  class=' text-capitalize text-dark info'>SEM </th>";
        $tbl.="<th  class='text-capitalize text-dark info'>SUBJECT NAME </th>";
        $tbl.="<th class='text-capitalize text-dark info' >NO. OF STUDENT</th>";
        $tbl.="<th class='text-capitalize text-dark info' > PHASE I</th>";
        $tbl.="<th class='text-capitalize text-dark info' >NO. OF STUDENT</th>";
        $tbl.="<th  class='text-capitalize text-dark info'> PHASE II </th>";
        $tbl.="<th  class='text-capitalize text-dark info'> AVG </th>";
        $tbl.=" </tr>";
            $faculty_subj = mysqli_query($this->conn, "select * from subject_allocations where subject_allocations.faculty_id=$staff_select and 
                    subject_allocations.class_id IN (select id from classes where isActive=1)");
            $s_no=1;
            while ($fs = mysqli_fetch_array($faculty_subj)) {
                $feed = mysqli_query($this->conn, "select AVG(sum),count(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=1 ");
                $feeds = mysqli_fetch_array($feed);
                $feed1 = mysqli_query($this->conn, "select AVG(sum),count(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=2 ");
                $feeds1 = mysqli_fetch_array($feed1);
                $st = mysqli_query($this->conn, "select count(id) from students where class_id=".$fs['class_id']." ");
                $st_tot = mysqli_fetch_array($st);
                $cn = mysqli_query($this->conn, "select name,department_id,sem from classes where id=" . $fs['class_id'] . " ");
                $class_details = mysqli_fetch_array($cn);
                $sn = mysqli_query($this->conn, "select name from subjects where id=" . $fs['subject_id'] . " ");
                $subject_name = mysqli_fetch_array($sn);
                $dp = mysqli_query($this->conn, "select short from departments where id=" . $class_details['department_id'] . " ");
                $department_name = mysqli_fetch_array($dp);
                $tbl .= "<tr>";
                $tbl .= "<td >" . $s_no . "</td>";
                $tbl .= "<td >" . $department_name['short'] . "</td>";
                $tbl .= "<td >" . $class_details['name'] . "</td>";
                $tbl .= "<td >" . $class_details['sem'] . "</td>";
                $tbl .= "<td >" . $subject_name['name'] . "</td>";
                $tbl .= "<td >" .$feeds[1] . " / $st_tot[0] </td>";
                if($feeds[0]=="") {
                    $tbl .= "<td > -NIL- </td>";
                }else{$tbl .= "<td >" .(int)$feeds[0] . "%</td>";}
                $tbl .= "<td >" .$feeds1[1] . " / $st_tot[0]</td>";
                if($feeds1[0]==""){   $tbl .= "<td > -NIL- </td>";}
                else{$tbl .= "<td >" . (int)$feeds1[0] . "%</td>";}
                $tbl .= "<td >" . (int)(($feeds[0]+$feeds1[0])/2) . "%</td>";
                $tbl .= "</tr>";
                ++$s_no;
            }
            $tbl.="</table>";
            return $tbl;
        }
        function faculty_wise_report_($staff_select)
        {

            $tbl="";
            $fac_=mysqli_query($this->conn,"select name from faculties where id=$staff_select");
            $faculty_name=mysqli_fetch_array($fac_);
            $faculty_subj = mysqli_query($this->conn, "select * from subject_allocations where subject_allocations.faculty_id=$staff_select and 
                    subject_allocations.class_id IN (select id from classes where isActive=1)");
            $s_no=1;
            $toggle=true;
            while ($fs = mysqli_fetch_array($faculty_subj)) {
                $feed = mysqli_query($this->conn, "select AVG(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=1 ");
                $feeds = mysqli_fetch_array($feed);
                $feed1 = mysqli_query($this->conn, "select AVG(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=2 ");
                $feeds1 = mysqli_fetch_array($feed1);

                $cn = mysqli_query($this->conn, "select name,batch,department_id,sem,id from classes where id=" . $fs['class_id'] . " ");
                $class_details = mysqli_fetch_array($cn);
                $batch2=0;
                $chk_=mysqli_query($this->conn,"select id from classes where id=$class_details[4] and (name like '%ME%' or name like '%MBA%') ");
                $check=mysqli_num_rows($chk_);
                if($check){
                    $batch2=$class_details[1]+2;
                }
                else{
                    $batch2=$class_details[1]+4;
                }
                $sn = mysqli_query($this->conn, "select name from subjects where id=" . $fs['subject_id'] . " ");
                $subject_name = mysqli_fetch_array($sn);
                $dp = mysqli_query($this->conn, "select short from departments where id=" . $class_details['department_id'] . " ");
                $department_name = mysqli_fetch_array($dp);
                $tbl .= "<tr>";
                $tbl .= "<td >" . $s_no . "</td>";
                if($toggle){
                $tbl .= "<td >" . $faculty_name[0] . "</td>";}
                else{
                    $tbl .= "<td >''</td>";
                }
                $toggle=false;
                $tbl .= "<td >" . $department_name['short'] . "</td>";
                $tbl .= "<td >" . $class_details['name'] . "</td>";
                $tbl .= "<td >" . $class_details['sem'] . "</td>";
                $tbl .= "<td > " . $class_details['batch'] . "-".($batch2)."</td>";
                $tbl .= "<td >" . $subject_name['name'] . "</td>";
                if($feeds[0]=="") {
                    $tbl .= "<td > -NIL- </td>";
                }else{$tbl .= "<td >" .(int)$feeds[0] . "%</td>";}
                if($feeds1[0]==""){   $tbl .= "<td > -NIL- </td>";}
                else{$tbl .= "<td >" . (int)$feeds1[0] . "%</td>";}
                $tbl .= "<td >" . (int)(($feeds[0]+$feeds1[0])/2) . "%</td>";

                $tbl .= "</tr>";
                ++$s_no;
            }
            return $tbl;
        }


        function update_password($op,$np,$cp,$user){
            $op=mysqli_real_escape_string($this->conn,$op);
            $np=mysqli_real_escape_string($this->conn,$np);
            $cp=mysqli_real_escape_string($this->conn,$cp);
            $user=mysqli_real_escape_string($this->conn,$user);
            //$op=md5($op);
           // $np=md5($np);
           // $cp=md5($cp);
            $que=mysqli_query($this->conn,"select password from admin where name='$user' ");
            $row=mysqli_fetch_array($que);
            $pass=$row['password'];
            if($op!=$pass)
            {
                $err="<font color='red'>You Entered wrong old password</font>";
                $err_="You Entered wrong old password !!";
            }

            elseif($np!=$cp)
            {
                $err="<font color='red'>New Password and confirm password must be same</font>";
                $err_="New Password and confirm password must be same";
            }
            else
            {
                mysqli_query($this->conn,"update admin set password='$cp' where name='$user'");
                $err="<font color='green'>Password have been Changed successfully !!</font>";
                $err_="Password have been Changed successfully !!";
            }
            if($err!=""){
                echo "<script type='text/javascript'>alert('$err_');</script>
    ";}

            return $err;
        }

   function Student_status($class_id){
       $tbl="<table class='table table-responsive table-bordered table-striped table-hover' style='margin:15px;'>";
       $tbl.="<tr class='primary' >";
       $tbl.="<th class=' text-capitalize text-dark info'>S.NO </th>";
       $tbl.="<th class=' text-capitalize text-dark info'>Registration NO.</th>";
       $tbl.="<th class=' text-capitalize text-dark info'>Name</th>";
       $tbl.="<th class=' text-capitalize text-dark info'>SEM</th>";
       $tbl.="<th class=' text-capitalize text-dark info' >PHASE I</th>";
       $tbl.="<th class=' text-capitalize text-dark info' >PHASE II</th>";
       $tbl.="</tr>";

       $i=1;
       $sem_=mysqli_query($this->conn,"select sem from classes where id=$class_id");
       $sem=mysqli_fetch_assoc($sem_);
       $sem=$sem['sem'];
       $student_list=mysqli_query($this->conn,"select * from students where class_id=$class_id ");
       while($row=mysqli_fetch_array($student_list))
       {
           $id=$row['id'];
           $stat=mysqli_query($this->conn,"select  count(*) from feedbacks where student_id=$id and phase=1 and sa_id in 
                (select id from  subject_allocations where class_id in (select id from classes where isActive=1))");
           $status=mysqli_fetch_array($stat);
           $stat_=mysqli_query($this->conn,"select  count(*) from feedbacks where student_id=$id and phase=2 and sa_id in 
              (select id from subject_allocations where class_id in (select id from classes where isActive=1))");
           $status_=mysqli_fetch_array($stat_);
           $subj_details=mysqli_query($this->conn,"select count(subject_id) from subject_allocations where class_id=$class_id");
           $subj_count=mysqli_fetch_array($subj_details);
           if(($status[0])==$subj_count[0] && ($status[0]!=0)&& ($subj_count[0]!=0))
           {$color="#00FA9A";}
           else{$color="#FF9999";}
           if(($status_[0])==$subj_count[0] && ($status[0]!=0)&& ($subj_count[0]!=0))
           {$color_="#00FA9A";}
           else{$color_="#FF9999";}
           $tbl.="<tr >";
           $tbl.="<td>".$i."</td>";
           $tbl.="<td>".$row['student_reg']."</td>";
           $tbl.="<td>".$row['name']."</td>";
           $tbl.="<td>$sem</td>";
           $tbl.="<td style='background-color: $color'></td>";
           $tbl.="<td style='background-color: $color_'></td>";
           $tbl.="</tr>";
           $i++;
       }
       return $tbl;
   }
        public function subject_lists()
        {
            $options = "<option value=''>Select Subject</option>";
            $query = "select * from subjects where 1=1";
            $sub = mysqli_query($this->conn, $query);
            if (!$sub) {
                $options .= "<option>error</option>";
            }
            while ($subjects = mysqli_fetch_array($sub)) {
                $options .= "<option value='" . $subjects['id'] . "'>" . $subjects['name'] . "</option>";
            }
            return $options;
        }
        public function faculty_names()
        {
            $options = "<option value=''>Select Faculty</option>";
            $query = "select id,name from faculties where 1=1";
            $fn = mysqli_query($this->conn, $query);
            if (!$fn) {
                $options .= "<option>error</option>";
            }
            while ($faculty = mysqli_fetch_array($fn)) {
                $options .= "<option value='" . $faculty['id'] . "'>" . $faculty['name'] . "</option>";
            }
            return $options;
        }
        public function set_subj_alloc($class_id,$subj_id,$faculty_id)
        {
            $check_=mysqli_query($this->conn,"select id from subject_allocations where class_id=$class_id
            and subject_id=$subj_id and faculty_id=$faculty_id");
            $check=mysqli_num_rows($check_);
            if($check==true){
                echo "<script>alert('Record Already Exists!!');</script>";
                return " ";
            }
            $output = " ";
            $class_id = (int)$class_id;
            $subj_id = (int)$subj_id;$subj_id_copy=$subj_id;
            $faculty_id = (int)$faculty_id;
            $query = "INSERT INTO subject_allocations(class_id,subject_id,faculty_id)
                  VALUES ($class_id,$subj_id,$faculty_id)";
            $status = mysqli_query($this->conn, $query);
            if (!$status) {
                $output = "<h1 style='color: red'>FAILED TO ALLOCATE</h1>";
                return $output;
            } else {
                $a = mysqli_query($this->conn, "select * from subject_allocations where class_id=$class_id");
                while ($b = mysqli_fetch_assoc($a)) {
                    $subj_id = $b['subject_id'];
                    if($subj_id_copy==$subj_id){
                        $color="<tr class='success'>";
                    }
                    else{
                        $color="<tr class='default'>";
                    }
                    $faculty_id = $b['faculty_id'];
                    $class_id = $b['class_id'];
                    $cls = mysqli_query($this->conn, "select name from classes where id=$class_id");
                    $subj = mysqli_query($this->conn, "Select name from subjects where id=$subj_id");
                    $fac = mysqli_query($this->conn, "Select name from faculties where id=$faculty_id");
                    $subject_name = mysqli_fetch_assoc($subj);
                    $faculty_name = mysqli_fetch_assoc($fac);
                    $class_name=mysqli_fetch_assoc($cls);
                    $output .= $color;
                    $output .= "<td>" . $class_name['name'] . "</td>";
                    $output .= "<td >" . $subject_name['name'] . "</td>";
                    $output .= "<td>" . $faculty_name['name'] . "</td>";
                    $output .= "</tr>";

                }
                return $output;

            }
        }
        function old_faculty_wise_report($staff_select)
        {
            $tbl = "<table id='old_faculty_wise' class='table table-bordered'>";
            $tbl .= "<tr class='primary'>";
            $tbl .= "<th  class='text-capitalize text-dark info'>S.NO</th>";
            $tbl .= "<th  class='text-capitalize text-dark info'>DEPARTMENT</th>";
            $tbl .= "<th  class='text-capitalize text-dark info'>FACULTY NAME</th>";
            $tbl .= "<th  class=' text-capitalize text-dark info'>CLASS NAME </th>";
            $tbl .= "<th  class=' text-capitalize text-dark info'>SEM </th>";
            $tbl .= "<th class='text-capitalize text-dark info' >BATCH </th>";
            $tbl .= "<th  class='text-capitalize text-dark info'>SUBJECT NAME </th>";
            $tbl .= "<th class='text-capitalize text-dark info' ># STUDENT</th>";
            $tbl .= "<th class='text-capitalize text-dark info' > PHASE I</th>";
            $tbl .= "<th class='text-capitalize text-dark info' ># STUDENT</th>";
            $tbl .= "<th  class='text-capitalize text-dark info'> PHASE II </th>";
            $tbl .= "<th  class='text-capitalize text-dark info'> AVG </th>";
            $tbl .= "</tr>";
            $f_=mysqli_query($this->conn,"select name from faculties where id=$staff_select ");
            $faculty_name=mysqli_fetch_assoc($f_);
            $faculty_subj = mysqli_query($this->conn, "select * from subject_allocations where subject_allocations.faculty_id=$staff_select ");
            $s_no=1;
            while ($fs = mysqli_fetch_array($faculty_subj)) {
                $feed = mysqli_query($this->conn, "select AVG(sum),count(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=1 ");
                $feeds = mysqli_fetch_array($feed);
                $feed1 = mysqli_query($this->conn, "select AVG(sum),count(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=2 ");
                $feeds1 = mysqli_fetch_array($feed1);

                $cn = mysqli_query($this->conn, "select name,batch,department_id,sem from classes where id=" . $fs['class_id'] . " ");
                $class_details = mysqli_fetch_array($cn);
                $sn = mysqli_query($this->conn, "select name from subjects where id=" . $fs['subject_id'] . " ");
                $subject_name = mysqli_fetch_array($sn);
                $dp = mysqli_query($this->conn, "select short from departments where id=" . $class_details['department_id'] . " ");
                $department_name = mysqli_fetch_array($dp);


                $tbl .= "<tr>";
                $tbl .= "<td >" . $s_no . "</td>";
                $tbl .= "<td >" . $department_name['short'] . "</td>";
                $tbl .= "<td >" . $faculty_name['name'] . "</td>";
                $tbl .= "<td >" . $class_details['name'] . "</td>";
                $tbl .= "<td >" . $class_details['sem'] . "</td>";
                $tbl .= "<td > " . $class_details['batch']."</td>";
                $tbl .= "<td >" . $subject_name['name'] . "</td>";
                $tbl .= "<td >" . $feeds[1] . "</td>";
                if($feeds[0]=="") {
                    $tbl .= "<td > -NIL- </td>";
                }else{$tbl .= "<td >" . $feeds[0] . "</td>";}
                $tbl .= "<td >" . $feeds1[1] . "</td>";
                if($feeds1[0]==""){   $tbl .= "<td > -NIL- </td>";}
                else{$tbl .= "<td >" . $feeds1[0] . "</td>";}
                $tbl .= "<td >" . (int)(($feeds[0]+$feeds1[0])/2) . "%</td>";
                $tbl .= "</tr>";
                ++$s_no;
            }
            $tbl .= "</table>";
            return $tbl;
        }
        function batch_lists()
        {
            $options = "<option value=''>Select Batch </option>";
            $b = mysqli_query($this->conn, "select distinct batch from classes ");
            while ($batches = mysqli_fetch_array($b)) {
                $options .= "<option value='$batches[0]'>$batches[0]</option>";
            }
            return $options;
        }


}

?>