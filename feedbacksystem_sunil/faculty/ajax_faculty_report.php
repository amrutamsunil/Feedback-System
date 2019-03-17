<?php
include ('../dbconfig.php');
include ('Faculty.php');
extract($_POST);
$fac_rep_obj= new \faculty\Faculty($conn);
$batch= "-NIL";$sem="-NIL-";$name= "-NIL";$batch="-NIL-";$subj_name="-NIL-";
$que_wise_report = $fac_rep_obj->faculty_report($_POST['subj_id']);
$cls_details=$fac_rep_obj->class_details($_POST['subj_id']);
$batch=$cls_details['batch'];$sem=$cls_details['sem'];$name=$cls_details['name'];
$subj_name=$cls_details[0]['short'];
$avg_report=array();
for($i=0;$i<10;$i++){
$avg_report[$i]=($que_wise_report[$i]+$que_wise_report[$i+10])/2;
}
$phase1_st_count=$que_wise_report[20];
$phase2_st_count=$que_wise_report[21];
$class_strength=$que_wise_report[22];
echo "<hr style='border-top: dotted 1px;' />";
echo "
<table style='margin-left: 17%;width: 80%'>
<tr>
<td width: 50%><h3 style='font-family: Arial'><b>SUBJECT NAME :<span style='color: #337ab7'>$subj_name</span></b></h3></td>
<td style='width: 40%'><h3  style='font-family: Arial'><b>CLASS NAME :<span style='color: #337ab7'> $name</span></b></h3> </td></tr>
<tr>
<td width: 50%><h3  style='font-family: Arial'><b> BATCH :<span style='color: #337ab7'>$batch</span></b></h3></td>
 <td style='width: 40%'><h3  style='font-family: Arial'><b>SEMESTER :<span style='color: #337ab7'>$sem</span></b></h3></td></tr></table>";
echo "<hr style='border-top: dotted 1px;' />";

echo "<br/>";
$a="<table class='table table-bordered' id='question_wise' width='100%'>
            <thead>
            <tr class='primary'>
                <th style='font-size: 17px; background-color: #d9edf7'>S.NO</th>
                <th  style=' font-size: 17px; background-color: #d9edf7'>QUESTION</th>
                <th style=' font-size: 17px; background-color: #d9edf7'>NO. OF STUDENTS</th>
                <th  style='font-size: 17px; background-color: #d9edf7'>PHASE I</th>
                <th style=' font-size: 17px; background-color: #d9edf7'>N0. OF STUDENTS</th>
                <th  style='font-size: 17px; background-color: #d9edf7'>PHASE II</th>
                <th  style='font-size: 17px; background-color: #d9edf7'> AVERAGE </th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <th>1</th>
                <td>Does the Faculty come prepared on lessons?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[0]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[10]%</td>
                <td  style='align-items: center'> $avg_report[0]%</td>

            </tr>
            <tr>
                <th>2</th>
                <td>Does the Faculty present the lessons clearly and orderly?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[1]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[11]%</td>
                <td  style='align-items: center'> $avg_report[1]%</td>
            </tr>
            <tr>
                <th>3</th>
                <td>Does the Faculty speak with the voice clarity and good language?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[2]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[12]%</td>
                <td  style='align-items: center'> $avg_report[2]%</td>
            </tr>
            <tr>
                <th>4</th>
                <td>Does the Faculty keep the class under discipline and control?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[3]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[13]%</td>
                <td  style='align-items: center'> $avg_report[3] %</td>
            </tr>
            <tr>
                <th>5</th>
                <td>Does the Faculty give response to student's doubts and questions?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[4]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[14]%</td>
                <td  style='align-items: center'> $avg_report[4]%</td>
            </tr>
            <tr>
                <th>6</th>
                <td>Does the Faculty possess depth of knowledge in subject?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[5]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[15]%</td>
                <td  style='align-items: center'> $avg_report[5]%</td>
            </tr>
            <tr>
                <th>7</th>
                <td>Does the Faculty give and assignments to improve the studies?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[6]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[16]%</td>
                <td  style='align-items: center'>$avg_report[6]%</td>

            </tr>
            <tr>
                <th>8</th>
                <td>Is the Faculty available outside class hours to clarify the doubts?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[7]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[17]%</td>
                <td  style='align-items: center'> $avg_report[7]%</td>

            </tr>
            <tr>
                <th>9</th>
                <td>Does the Faculty use the black board and modern techniques effectively?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td style='padding-left: 3%'> $que_wise_report[8]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[18]%</td>
                <td  style='align-items: center'> $avg_report[8]%</td>

            </tr>
            <tr>
                <th>10</th>
                <td>Is the Faculty regular and punctual to classes?</td>
                <td  style='padding-left: 3%'> $phase1_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[9]%</td>
                <td  style='padding-left: 3%'> $phase2_st_count / $class_strength </td>
                <td  style='padding-left: 3%'> $que_wise_report[19]%</td>
                <td  style='align-items: center'> $avg_report[9]%</td>
            </tr>
            </tbody>
        </table>";
 echo $a;

?>