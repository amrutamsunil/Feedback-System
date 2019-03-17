<?php
include ('../dbconfig.php');
if(isset($_SESSION['phase'])){
    $phase=$_SESSION['phase'];
}
if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link href="../img/miet.png" rel="icon">
    <title>FEEDBACK FORM</title>
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link href="../css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
    <!--suppress JSUnresolvedLibraryURL -->
    <script src="../js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../js/star-rating.js" type="text/javascript"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/css/nav.css" rel="stylesheet">


</head>
<body style="overflow-x: hidden">
<div id="tri">

</div>

<div class="navbar_miet float-left ">
    <a href="home_page.php"><i class="fa fa-home" aria-hidden="true"></i> HOME </a>
    <div class="subnav_miet" style="float: right">
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>SignOut</a>
        </div>
</div>
    <br>
    <form method="post" >
<fieldset>
        <div class="row row d-flex p-3 bg-secondary">
            <div class="col-md-2"><label for="subsel" style="padding-left: 30%; font-size: 20px;font-family: Rockwell">Select Subject </label></div>
            <div class="col-md-8">
                <select name="subsel" id="subsel" class="form-control">
                    <?php echo $user_class->fill_subjects($user_data,$phase); ?>
                </select></div>
        </div>
</fieldset><br/>
<div style="background-color: #d9edf7">
    <marquee>*Red implies feedback already submitted !! *Green implies feedback not submitted !!</marquee>
</div>
        <br/><br/>
        <div class="container">
    <table class="table table-bordered" width="100%">
        <thead>
        <tr class='primary'>
            <th style="padding-left: 1%; font-size:  17px ;background-color: #d9edf7">S.NO</th>
            <th style="padding-left: 10%; font-size: 17px ;background-color: #d9edf7">QUESTION</th>
            <th style="padding-left: 10%; font-size: 17px ;background-color: #d9edf7">RATING</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="5%">1</td>
            <td width="55%">Does the Faculty come prepared on lessons?</td>
            <td width="45%">
                <input name="q1" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                      id="abc" required title="">
            </td>

        </tr>
        <tr>
            <td >2</td>
            <td>Does the Faculty present the lessons clearly and orderly?</td>
            <td>
                <input name="q2" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                       required title="">
            </td>

        </tr>
        <tr>
            <td>3</td>
            <td>Does the Faculty speak with the voice clarity and good language?</td>
            <td>
                <input name="q3" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                       required title="">
            </td>

        </tr>
        <tr>
            <td>4</td>
            <td>Does the Faculty keep the class under discipline and control?</td>
            <td>
                <input name="q4" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                       required title="">
            </td>

        </tr>
        <tr>
            <td>5</td>
            <td>Does the Faculty give response to students’ doubts and questions?</td>
            <td>
                <input name="q5" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                       required title="">
            </td>

        </tr>
        <tr>
            <td>6</td>
            <td>
                 Does the Faculty possess depth of knowledge in subject?</td>
            <td><input name="q6" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                                               required title="">
            </td>

        </tr>
        <tr>
            <td>7</td>
            <td>
                 Does the Faculty give and assignments to improve the studies?</td>
            <td>
                <input name="q7" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                       required title="">
            </td>

        </tr>
        <tr>
            <td>8</td>
            <td >
                 Is the Faculty available outside class hours to clarify the doubts?
            </td>
            <td>
                <input name="q8" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                                              required title="">
            </td>

        </tr>
        <tr>
            <td >9</td>
            <td>
                Does the Faculty use the black board and modern techniques effectively?
            </td>
            <td>
                <input name="q9" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                       required title="">
            </td>

        </tr>

        <tr>
            <td>10</td>
            <td>
                    Is the Faculty regular and punctual to classes?</td>
            <td>
                    <input name="q10" type="text" class="rating" data-min=0 data-max=5 data-step=1 data-size="md"
                           required title="">
            </td>
        </tr>

        </tbody>
    </table>

            <div class="row row d-flex p-3 bg-secondary">
                <center><input type="submit" value="SUBMIT" class=" btn btn-success btn-secondary btn-lg" name="ok"> </center>
            </div>
        </div>
    </form>

<?php
extract($_POST);

if(isset($ok)) {
    if ($ok == "") {
        echo "
        <script>
        alert('Select any Subject!!');
        </script>
        ";
    } else {
        $check = '';
        $subsel = $_POST['subsel'];
        $q1 = (int)$_POST['q1'];
        $q2 = (int)$_POST['q2'];
        $q3 = (int)$_POST['q3'];
        $q4 = (int)$_POST['q4'];
        $q5 = (int)$_POST['q5'];
        $q6 = (int)$_POST['q6'];
        $q7 = (int)$_POST['q7'];
        $q8 = (int)$_POST['q8'];
        $q9 = (int)$_POST['q9'];
        $q10 = (int)$_POST['q10'];
        $ratings = [$q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10];
        $check = $user_class->submit_feedback($subsel, $user_data, $check, $ratings, $phase);
        echo "<script type='text/javascript'>alert('$check');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
    }
}
?>
<script type="text/javascript">
    $('input').on('change',
     function() {
         var check=$('#subsel').val();
         if(check==""){
         alert('Select any  subject!');
         }

     });

            $('#subsel').on('change',function () {
                var subj_id=$(this).val();
                var p="<?php echo $phase;?>";
                var u="<?php echo $user;?>";
                if(subj_id){
                    $.ajax({
                        type:'POST',
                        url:'ajax_subj_status.php',
                        data:{subjsel:subj_id,phase:p,user:u},
                        success:function (response) {
                            if(response){
                          alert(response);

                            }
                        }
                    });
                }

            });


</script>
</body>
</html>
