<?php
include('../dbconfig.php');
include ('Faculty.php');
require('../vendor/fpdf181/fpdf.php');
$fac_rep_obj= new \faculty\Faculty($conn);
$batch= "-NIL";$sem="-NIL-";$name= "-NIL";$batch="-NIL-";$subj_name="-NIL-";
session_start();
class PDF extends FPDF
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
            $this->Cell(60, 10, ' FACULTY', 0, 0, 'L');
            $this->Cell(60, 10, 'HOD', 0, 0, 'C');
            $this->Cell(60, 10, 'PRINCIPAL', 0, 1, 'R');
        }
    }
    function sunil_custom($temp_font,$cell_width,$value){
        $this->SetFont('Arial', '', 10);
        while($this->GetStringWidth($value)>$cell_width){
            $this->SetFontSize($temp_font-=0.1);
        }
    }
    function sunil_add($a,$b){
        if(($a==0) && ($b==0)){
            return 0;

        }
        else {
            return (($a+$b)/2);
        }
    }
}

$pdf = new PDF('p', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
extract($_POST);
$sa_id=$_POST['subjSelect'];
if ($sa_id == "" ) {
    echo "
        <script>
        alert('Select any Subject!!');
        </script>
        ";
} else {
    $que_wise_report = $fac_rep_obj->faculty_report($sa_id);
    $cls_details=$fac_rep_obj->class_details($sa_id);
    $batch=$cls_details['batch'];$sem=$cls_details['sem'];$name=$cls_details['name'];
    $subj_name=$cls_details[0]['short'];
    $f_id=mysqli_query($conn,"select faculty_id from subject_allocations where id=$sa_id");
    $faculty_id=mysqli_fetch_array($f_id);
    $fac_det=mysqli_query($conn,"select name from faculties where id=$faculty_id[0]");
    $faculty_name=mysqli_fetch_array($fac_det);
}

$s_no = 1;
if($pdf->PageNo()==1) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 10, "FACULTY NAME :  {$faculty_name[0]}", 0, 0, 'L');
    $pdf->Cell(90, 10, "", 0, 0);
    $pdf->Cell(30, 10, "CLASS NAME : {$name}", 0, 1, 'R');
    $pdf->Cell(50, 10, "SUBJECT :  {$subj_name}", 0, 0, 'L');
    $pdf->Cell(90, 10, "", 0, 0);
    $pdf->Cell(30, 10, "SEMESTER/BATCH: {$sem}/{$batch}", 0, 1, 'R');
}
$pdf->Ln(10);
$pdf->SetFillColor(217, 237, 247);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(8, 10, "#", 1, 0, 'C', 1);
$pdf->Cell(130, 10, "QUESTION", 1, 0, 'C', 1);
$pdf->Cell(18, 10, "PHASE I", 1, 0, 'C', '1');
$pdf->Cell(18, 10, "PHASE II", 1, 0, 'C', 1);
$pdf->Cell(18, 10, "AVG ", 1, 1, 'C', 1);

$questions=array("Does the Faculty come prepared on lessons?","Does the Faculty present the lessons clearly and orderly?","Does the Faculty speak with the voice clarity and good language?",
                "Does the Faculty keep the class under discipline and control?","Does the Faculty give response to student's doubts and questions?"," Does the Faculty possess depth of knowledge in subject?",
                " Does the Faculty give and assignments to improve the studies?","Is the Faculty available outside class hours to clarify the doubts?",
                "  Does the Faculty use the black board and modern techniques effectively?"," Is the Faculty regular and punctual to classes?");

$pdf->Cell(8, 10, "1", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[0]);
$pdf->Cell(130, 10, "{$questions[0]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[0]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[10]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[0],$que_wise_report[10]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "2", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[1]);
$pdf->Cell(130, 10, "{$questions[1]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[1]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[11]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[1],$que_wise_report[11]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "3", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[2]);
$pdf->Cell(130, 10, "{$questions[2]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[2]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[12]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[2],$que_wise_report[12]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "4", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[3]);
$pdf->Cell(130, 10, "{$questions[3]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[3]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[13]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[3],$que_wise_report[13]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "5", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[4]);
$pdf->Cell(130, 10, "{$questions[4]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[4]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[14]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[4],$que_wise_report[14]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "6", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[5]);
$pdf->Cell(130, 10, "{$questions[5]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[5]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[15]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[5],$que_wise_report[15]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "7", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[6]);
$pdf->Cell(130, 10, "{$questions[6]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[6]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[16]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[6],$que_wise_report[16]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "8", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[7]);
$pdf->Cell(130, 10, "{$questions[7]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[7]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[17]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[7],$que_wise_report[17]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "9", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[8]);
$pdf->Cell(130, 10, "{$questions[8]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[8]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[18]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[8],$que_wise_report[18]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->Cell(8, 10, "10", 1, 0, 'C');
$pdf->sunil_custom(10,100,$questions[9]);
$pdf->Cell(130, 10, "{$questions[9]}", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 10, "{$que_wise_report[9]}%", 1, 0, 'C' );
$pdf->Cell(18, 10, "{$que_wise_report[19]}%", 1, 0, 'C');
$agg=$pdf->sunil_add($que_wise_report[9],$que_wise_report[19]);
$pdf->Cell(18, 10, "{$agg}%", 1, 1, 'C');

$pdf->isFinished=true;
$pdf->output('D', "faculty_que_wise_rep.pdf", true);
?>