<?php
include('dbconfig.php');
session_start();
require('../vendor/fpdf181/fpdf.php');
class PDF extends FPDF
{
    protected $conn=NULL,$dept_id=NULL,$a = false;
    function Header()
    {
        $newPage=true;

        if ($this->PageNo() == 1) {
            $this->Image('../images/Fotoram.io12.png', 10, 10, 35, 25);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(20);
            $this->Cell(150, 10, 'M.I.E.T ENGINEERING COLLEGE,Trichy-620007', 0, 1, 'C');
            $this->Cell(20);
            $this->Cell(150, 10, 'STUDENT FEEDBACK ANALYSIS REPORT ', 0, 1, 'C');
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(20);
            $this->Cell(150, 10, 'FACULTYWISE REPORT ', 0, 1, 'C');
            $this->Cell(180, 10, "DEPARTMENT OF {$this->dept_id}", 0, 1, 'C');
            $this->Ln(4);

        }
        if($newPage){
            $this->SetFillColor(217, 237, 247);
            $this->SetFont('Arial', '', 10);
            $this->Cell(8, 10, "#", 1, 0, 'C', 1);
            $this->Cell(50,10,"FACULTY NAME",1,0,'C',1);
            $this->Cell(32, 10, "CLASS NAME", 1, 0, 'C', 1);
            $this->Cell(18, 10, "DEPT", 1, 0, 'C', '1');
            $this->Cell(66, 10, "SUBJECT NAME", 1, 0, 'C', 1);
            $this->Cell(18, 10, "AVG", 1, 1, 'C', 1);
            $this->newPage=false;
        }
    }
    function set_val($conn,$dept_id){
       $this->conn=$conn;$this->dept_id=$dept_id;
       $a=mysqli_query($conn,"select name from departments where id=$dept_id");
       $dep=mysqli_fetch_array($a);
       $this->dept_id=$dep[0];
    }
    function switcha(){
        $this->a=true;
    }
    function Footer()
    {

        if($this->a){
            $this->SetFont('Arial', 'B', 10);
            $this->SetY(-30);
            $this->Cell(100, 10, 'HOD', 0, 0, 'C');
            $this->Cell(60, 10, 'PRINCIPAL', 0, 1, 'R');
        }
        $this->SetFont('Arial', '', 7);
        $this->SetY(-10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');

    }
    function zaina(){
        $this->SetFont('Arial', 'B', 10);
        $this->SetY(-30);
        $this->Cell(100, 10, 'HOD', 0, 0, 'C');
        $this->Cell(60, 10, 'PRINCIPAL', 0, 1, 'R');
    }
    function sunil_custom($temp_font,$cell_width,$value){
        $this->SetFont('Arial', '', 10);
        while($this->GetStringWidth($value)>=$cell_width){
            $this->SetFontSize($temp_font-=0.1);
        }
    }
}
$dept_id=NULL;
if(isset($_SESSION['dept_id'])){
    $dept_id=$_SESSION['dept_id'];
}
$pdf = new PDF('p', 'mm', 'A4');
$pdf->set_val($conn,$dept_id);
$pdf->AddPage();
$s_no = 1;
$tmp=mysqli_query($conn,"select id from faculties where department_id=$dept_id ");
while($tmp_=mysqli_fetch_array($tmp)) {

    $pdf->SetFont('Arial', '', 10);
    $staff_select = $tmp_[0];

    if (($staff_select != "") && ($dept_id != "")) {
        $pdf->isFinished=true;
        $d = mysqli_query($conn, "select short from departments where id=$dept_id ");
        $dept_short = mysqli_fetch_array($d);
        $fac_ = mysqli_query($conn, "select name from faculties where id=$staff_select");
        $faculty_name = mysqli_fetch_array($fac_);
        $faculty_subj = mysqli_query($conn, "select * from subject_allocations where subject_allocations.faculty_id=$staff_select and
subject_allocations.class_id IN (select id from classes where isActive=1)");

        $toggle=true;
        $h=mysqli_num_rows($faculty_subj);
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

            if($toggle){
                $pdf->Cell(8, $h*10, "{$s_no}", 1, 0);
            $pdf->sunil_custom(10, 50, $faculty_name[0]);
            $pdf->Cell(50, $h*10, "$faculty_name[0]", '1', 0);}
            else{
            $xt=$pdf->GetX();
            $pdf->SetX($xt+58);}
            $pdf->sunil_custom(10, 32, $class_details['name']);
            $pdf->Cell(32, 10, "{$class_details['name']}", 1, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(18, 10, "{$department_name[0]}", 1, 0);
            if($pdf->GetStringWidth($subject_name['name'])>72){
                $subject_name['name']=$subject_name['short'];
            }
            $pdf->sunil_custom(10, 66, $subject_name['name']);
            $pdf->Cell(66, 10, "{$subject_name['name']}", 1, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(18, 10, "{$feed_avg}%", 1, 1, 'C');
            $toggle=false;

        }
        ++$s_no;
    }

}
$pdf->switcha();
    $pdf->output('I', 'FACULTY_WISE_REPORT.pdf', 1);
?>