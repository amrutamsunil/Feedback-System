<?php
include('../dbconfig.php');
require('../vendor/fpdf181/fpdf.php');
session_start();

$pdf = new PDF_Diag('p', 'mm', 'A4');
$demo=array();
$questions=array("Does the Faculty come prepared on lessons?","Does the Faculty present the lessons clearly and orderly?","Does the Faculty speak with the voice clarity and good language?",
    "Does the Faculty keep the class under discipline and control?","Does the Faculty give response to student's doubts and questions?"," Does the Faculty possess depth of knowledge in subject?",
    " Does the Faculty give and assignments to improve the studies?","Is the Faculty available outside class hours to clarify the doubts?",
    "  Does the Faculty use the black board and modern techniques effectively?"," Is the Faculty regular and punctual to classes?");
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$staff_select=104;
$dept_id=1;
if(($staff_select!="")&&($dept_id!="")) {
    $d = mysqli_query($conn, "select short from departments where id=$dept_id ");
    $dept_short = mysqli_fetch_array($d);
    $fac_ = mysqli_query($conn, "select name from faculties where id=$staff_select");
    $faculty_name = mysqli_fetch_array($fac_);
    $faculty_subj = mysqli_query($conn, "select * from subject_allocations where subject_allocations.faculty_id=$staff_select and
subject_allocations.class_id IN (select id from classes where isActive=1)");
    $s_no = 1;
    if($pdf->PageNo()==1) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(50, 10, "FACULTY NAME :  {$faculty_name[0]}", 0, 0, 'L');
        $pdf->Cell(90, 10, "", 0, 0);
        $pdf->Cell(30, 10, "DEPT : {$dept_short[0]}", 0, 1, 'R');
    }
    $pdf->Ln(10);
    $pdf->SetFillColor(217, 237, 247);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(8, 10, "#", 1, 0, 'C', 1);
    $pdf->Cell(30, 10, "CLASS NAME", 1, 0, 'C', 1);
    $pdf->Cell(18, 10, "DEPT", 1, 0, 'C', '1');
    $pdf->Cell(80, 10, "SUBJECT NAME", 1, 0, 'C', 1);
    $pdf->Cell(18, 10, "PHASE I ", 1, 0, 'C', 1);
    $pdf->Cell(18, 10, "PHASE II", 1, 0, 'C', 1);
    $pdf->Cell(18, 10, "AVG", 1, 1, 'C', 1);
    while ($fs = mysqli_fetch_array($faculty_subj)) {
        $feed = mysqli_query($conn, "select AVG(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=1 ");
        $feeds = mysqli_fetch_array($feed);
        $feed1 = mysqli_query($conn, "select AVG(sum) from feedbacks where sa_id=" . $fs['id'] . " and phase=2 ");
        $feeds1 = mysqli_fetch_array($feed1);
        if(mysqli_num_rows($feed)>0){
        $feedback_1 = (int)$feeds[0];}else{$feedback_1=0;}
        if(mysqli_num_rows($feed1)>0){
        $feedback_2 = (int)$feeds1[0];}else{$feedback_2=0;}
        if ($feedback_1 == 0 && $feedback_2 == 0) {
            $feed_avg = 0;
        } else {
            $feed_avg = ($feedback_1 + $feedback_2) / 2;
        }
        $cn = mysqli_query($conn, "select name,batch,department_id,sem from classes where id=" . $fs['class_id'] . " ");
        $class_details = mysqli_fetch_array($cn);
        $sn = mysqli_query($conn, "select name,short from subjects where id=" . $fs['subject_id'] . " ");
        $subject_name = mysqli_fetch_array($sn);
        $dp = mysqli_query($conn, "select short from departments where id=" . $class_details['department_id'] . " ");
        $department_name = mysqli_fetch_array($dp);
        $pdf->Cell(8, 10, "{$s_no}", 1, 0);
        $pdf->Cell(30, 10, "{$class_details['name']}", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(18, 10, "{$department_name[0]}", 1, 0);
        $pdf->Cell(80, 10, "{$subject_name['name']}", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(18, 10, "{$feedback_1}%", 1, 0, 'C');
        $pdf->Cell(18, 10, "{$feedback_2}%", 1, 0, 'C');
        $pdf->Cell(18, 10, "{$feed_avg}%", 1, 1, 'C');
        ++$s_no;
    }
    $pdf->Ln(8);
    foreach ($questions as $q){
        $cellWidth=80;$cellHeight=5;
        if($pdf->GetStringWidth($q)<$cellWidth){
            $line=1;
        }
        else{
            $textlength=strlen($q);
            $errMargin=10;
            $startChar=0;
            $maxChar=0;
            $textArray=array();
            $tempString="";
            while($startChar<$textlength){
                while($pdf->GetStringWidth($tempString)<($cellWidth - $errMargin) && ($startChar+$maxChar)<$textlength){
                    $maxChar++;
                    $tempString=substr($q,$startChar,$maxChar);
                }
                $startChar=$startChar+$maxChar;
                array_push($textArray,$tempString);
                $maxChar=0;
                $tempString='';
            }
            $line=count($textArray);

        }
        $xpos=$pdf->GetX();$ypos=$pdf->GetY();
        //$pdf->MultiCell($cellWidth,$ypos);
        $pdf->SetXY($xpos+$cellWidth,$ypos);
        $pdf->Cell(80,($line*$cellHeight),$q,1,1);
    }

    $pdf->isFinished=true;

    $pdf->output('D', 'FACULTY_WISE_REPORT.pdf', 1);
}
?>