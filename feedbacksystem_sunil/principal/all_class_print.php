<?php
include('../dbconfig.php');
require('../vendor/fpdf181/fpdf.php');
session_start();
class PDF extends FPDF
{
   protected  $dept_id=NULL;public $isFinished=false;
    function Header()
    {
        $isFinished=false;
        if($this->page==1) {
            $this->Image('../images/Fotoram.io12.png', 10, 10, 35, 25);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(20);
            $this->Cell(150, 10, 'M.I.E.T ENGINEERING COLLEGE,Trichy-620007', 0, 1, 'C');
            $this->Cell(20);
            $this->Cell(150, 10, 'STUDENT FEEDBACK ANALYSIS REPORT ', 0, 1, 'C');
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(20);
            $this->Cell(150, 10, 'CLASSWISE REPORT ', 0, 1, 'C');
            $this->Cell(180, 10, "{$this->dept_id}", 0, 1, 'C');

            $this->Ln(10);
        }
    }
    function set_val($conn,$dept_id){
        $this->conn=$conn;$this->dept_id=$dept_id;
        $a=mysqli_query($conn,"select name from departments where id=$dept_id");
        $dep=mysqli_fetch_array($a);
        $this->dept_id=$dep[0];
    }

    function Footer()
    {
        $this->SetFont('Arial', '', 7);
        $this->SetY(-10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        if($this->isFinished) {
            $this->SetFont('Arial', 'B', 12);
            $this->SetY(-30);
            $this->Cell(100, 10, 'HOD', 0, 0, 'C');
            $this->Cell(60, 10, 'PRINCIPAL', 0, 1, 'R');
        }
    }
    function sunil_custom($temp_font,$cell_width,$value){
        $this->SetFont('Arial', '', 8);
        while($this->GetStringWidth($value)>$cell_width){
            $this->SetFontSize($temp_font-=0.1);
        }
    }
}
$dept_id=$_SESSION['dept_id'];
$pdf = new PDF('p', 'mm', 'A4');
$pdf->set_val($conn,$dept_id);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
$_clses=mysqli_query($conn,"select id from classes where department_id=$dept_id and isActive=1 ");
while($c_id=mysqli_fetch_array($_clses)) {
    $class_select = $c_id[0];
    $batch2 = 0;
    $cls_d = mysqli_query($conn, "select department_id,name,sem,batch,id from classes where id=$class_select");
    $cls_details = mysqli_fetch_array($cls_d);
    $chk_ = mysqli_query($conn, "select id from classes where id=$cls_details[4] and (name like '%ME%' or name like '%MBA%') ");
    $check = mysqli_num_rows($chk_);
    if ($check) {
        $batch2 = $cls_details[3] + 2;
    } else {
        $batch2 = $cls_details[3] + 4;
    }
    $d = mysqli_query($conn, "select short from departments where id=$cls_details[0]");
    $dept_short = mysqli_fetch_array($d);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, "CLASS NAME :  {$cls_details[1]}", 0, 0, 'L');
    $pdf->Cell(0, 10, "SEMESTER  :   {$cls_details[2]}", 0, 1, 'R');
    $pdf->Cell(0, 10, "BATCH  : {$cls_details[3]}-{$batch2}", 0, 1, 'L');
    $pdf->Ln(10);
    $pdf->SetFillColor(217, 237, 247);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(8, 10, "#", 1, 0, 'C', 1);
    $pdf->Cell(70, 10, "SUBJECT NAME", 1, 0, 'C', 1);
    $pdf->Cell(70, 10, "FACULTY HANDLING", 1, 0, 'C', 1);
    $pdf->Cell(17, 10, "PHASE I ", 1, 0, 'C', 1);
    $pdf->Cell(17, 10, "PHASE II", 1, 0, 'C', 1);
    $pdf->Cell(15, 10, "AVG", 1, 1, 'C', 1);
    $pdf->SetTextColor(0, 0, 0);
    $s_no = 1;
    $class = mysqli_query($conn, "select * from subject_allocations where subject_allocations.class_id=$class_select ");
    while ($classes = mysqli_fetch_array($class)) {
        $subj = mysqli_query($conn, "select name from subjects where subjects.id=" . $classes['subject_id'] . " ");
        $subjects = mysqli_fetch_array($subj);
        $fn = mysqli_query($conn, "select name from faculties where faculties.id=" . $classes['faculty_id'] . " ");
        $faculties = mysqli_fetch_array($fn);
        $a = mysqli_query($conn, "select AVG(sum) from feedbacks where sa_id=" . $classes['id'] . " and phase=1 ");
        $agg = mysqli_fetch_array($a);
        $a1 = mysqli_query($conn, "select AVG(sum) from feedbacks where sa_id=" . $classes['id'] . " and phase=2 ");
        $agg1 = mysqli_fetch_array($a1);
        $class_det = mysqli_query($conn, "select name,sem,batch,department_id from classes WHERE id=" . $classes['class_id'] . " ");
        $class_detail = mysqli_fetch_assoc($class_det);
        $dept = mysqli_query($conn, "select short from departments where id=" . $class_detail['department_id'] . " ");
        $dept_short_name = mysqli_fetch_assoc($dept);
        $agg = (int)$agg[0];
        $agg1 = (int)$agg1[0];
        if ($agg == 0 && $agg1 == 0) {
            $avg = 0;
        } else {
            $avg = ($agg + $agg1) / 2;
        }
        $pdf->Cell(8, 10, "{$s_no}", 1, 0);
        $pdf->sunil_custom(8, 70, $subjects['name']);
        $pdf->Cell(70, 10, "{$subjects['name']}", 1, 0);
        $pdf->sunil_custom(8, 70, $faculties['name']);
        $pdf->Cell(70, 10, "{$faculties['name']}", 1, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(17, 10, "{$agg}%", 1, 0, 'C');
        $pdf->Cell(17, 10, "{$agg1}%", 1, 0, 'C');
        $pdf->Cell(15, 10, "{$avg}%", 1, 1, 'C');
        ++$s_no;
    }

    $pdf->AddPage();
}
$pdf->isFinished=true;
    $pdf->output('I', "class_wise_report.pdf", true);

?>