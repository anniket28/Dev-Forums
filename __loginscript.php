<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');

if($_SERVER['REQUEST_METHOD']=='POST'){
    $user_email=$_POST['email'];
    $email=mysqli_escape_string($conn,$user_email);
    $user_pass=$_POST['password'];
    $pass=mysqli_escape_string($conn,$user_pass);
    $check="SELECT * FROM `users` WHERE email='$email'";
    $check_user=mysqli_query($conn,$check);
    $num=mysqli_num_rows($check_user);
    // echo($num);
    if($num==1){
        while($row=mysqli_fetch_assoc($check_user)){
            if(password_verify($pass,$row['password'])){
                session_start();
                $_SESSION['login']=true;
                $_SESSION['username']=$row['name'];
                $_SESSION['email']=$email;
                $_SESSION['uid']=$row['sno'];
                $_SESSION['loggedin']=true;
                $_SESSION['start']=time();
                $_SESSION['expiry']=$_SESSION['start']+(60*60*24);
                // echo($_SESSION['username']);
                // echo($_SESSION['login']);
                // echo($row['name']);
                // echo("Login Successfull");
                header("location: ourcategories.php");
            }
            else{
                // echo('Wrong Password');
                session_start();
                $_SESSION['wrong_password']=true;
                header("location: /Dev Forums/");
            }
        }
    }
    elseif($num==0){
        // echo('No User Exist');
        session_start();
        $_SESSION['no_user']=true;
        header("location: /Dev Forums/");
    }
    else{
        echo(mysqli_error($conn));
    }
}

?>