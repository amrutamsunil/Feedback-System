<?php
include('../dbconfig.php');
require('../vendor/fpdf181/fpdf.php');
session_start();
class PDF extends PDF_Diag
{
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
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(20);
            $this->Cell(150, 10, 'FACULTYWISE REPORT ', 0, 1, 'C');

            $this->Ln(10);
        }
    }
    function Footer()
    {
        $this->SetFont('Arial', '', 7);
        $this->SetY(-10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        if($this->isFinished) {
            $this->SetFont('Arial', 'B', 10);
            $this->SetY(-30);
            $this->Cell(100, 10, 'HOD', 0, 0, 'C');
            $this->Cell(60, 10, 'PRINCIPAL', 0, 1, 'R');
        }
    }
    function sunil_custom($temp_font,$cell_width,$value){
        $this->SetFont('Arial', '', 10);
        while($this->GetStringWidth($value)>=$cell_width){
            $this->SetFontSize($temp_font-=0.1);
        }
    }
}

$demo=array();
$pdf = new PDF('p', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
extract($_POST);
$staff_select=$_POST['staffselect'];
$dept_id=$_SESSION['dept_id'];
if(($staff_select!="")&&($dept_id!="")) {
    $d = mysqli_query($conn, "select short from departments where id=".$_SESSION['dept_id']." ");
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
        $feeds = (int)$feeds[0];
        $feeds1 = (int)$feeds1[0];
        if ($feeds1 == 0 && $feeds == 0) {
            $feed_avg = 0;
        } else {
            $feed_avg = ($feeds + $feed1) / 2;
        }
        $cn = mysqli_query($conn, "select name,batch,department_id,sem from classes where id=" . $fs['class_id'] . " ");
        $class_details = mysqli_fetch_array($cn);
        $sn = mysqli_query($conn, "select name,short from subjects where id=" . $fs['subject_id'] . " ");
        $subject_name = mysqli_fetch_array($sn);
        $dp = mysqli_query($conn, "select short from departments where id=" . $class_details['department_id'] . " ");
        $department_name = mysqli_fetch_array($dp);
        $pdf->Cell(8, 10, "{$s_no}", 1, 0);
        $pdf->sunil_custom(10,30,$class_details['name']);
        $pdf->Cell(30, 10, "{$class_details['name']}", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(18, 10, "{$department_name[0]}", 1, 0);
        if($pdf->GetStringWidth($subject_name['name'])>72){
            $subject_name['name']=$subject_name['short'];
        }
        $pdf->sunil_custom(10,80,$subject_name['name']);
        $pdf->Cell(80, 10, "{$subject_name['name']}", 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(18, 10, "{$feeds}%", 1, 0, 'C');
        $pdf->Cell(18, 10, "{$feeds1}%", 1, 0, 'C');
        $pdf->Cell(18, 10, "{$feed_avg}%", 1, 1, 'C');
        $demo[$subject_name['short']]=$feed_avg;
        ++$s_no;
    }
    $pdf->Ln(8);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    print_r($demo);
    $pdf->BarDiagram(190, 70, $demo, '%l : %v ', array(30,144,255));
    $pdf->SetXY($valX, $valY + 80);

    $pdf->isFinished=true;

    $pdf->output('D', 'FACULTY_WISE_REPORT.pdf', 1);
}
?>