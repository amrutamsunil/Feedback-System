<?php
/**
 * Created by PhpStorm.
 * User: SUNIL
 * Date: 01-03-2019
 * Time: 14:22
 */

class principal
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
            $login=mysqli_query($this->conn,"select * from principal where username='$username' and password='$password' ");
            $login_details=mysqli_num_rows($login);

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
    function update_password($op,$np,$cp,$user){
        $op=mysqli_real_escape_string($this->conn,$op);
        $np=mysqli_real_escape_string($this->conn,$np);
        $cp=mysqli_real_escape_string($this->conn,$cp);
        $user=mysqli_real_escape_string($this->conn,$user);
        //$op=md5($op);
        // $np=md5($np);
        // $cp=md5($cp);
        $que=mysqli_query($this->conn,"select password from principal where username='$user' ");
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
            mysqli_query($this->conn,"update principal set password='$cp' where username='$user'");
            $err="<font color='green'>Password have been Changed successfully !!</font>";
            $err_="Password have been Changed Successfully !!";
        }
        if($err!=""){
            echo "<script type='text/javascript'>alert('$err_');</script>
    ";}
        return $err;
    }
}