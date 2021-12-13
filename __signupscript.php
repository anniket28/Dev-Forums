<?php

    require('partials/_dbconnection.php');
    require('partials/_dbconnectioncheck.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $user_name=$_POST['name'];
        $name=mysqli_escape_string($conn,$user_name);
        $user_email=$_POST['email'];
        $email=mysqli_escape_string($conn,$user_email);
        $user_pass=$_POST['password'];
        $pass=mysqli_escape_string($conn,$user_pass);
        $password=password_hash($pass,PASSWORD_DEFAULT);
        $user_cpass=$_POST['confirm_password'];
        $cpass=mysqli_escape_string($conn,$user_cpass);
        $check="SELECT * FROM `users` WHERE email='$email'";
        $check_user=mysqli_query($conn,$check);
        $num=mysqli_num_rows($check_user);
        // echo($num);
        if($num==0){
            $insert="INSERT INTO `users` (`name`, `email`, `password`, `dateTime`) VALUES ('$name', '$email', '$password', NOW());";
            $insert_user=mysqli_query($conn,$insert);
            session_start();
            $_SESSION['login']=true;
            $_SESSION['username']=$name;
            $_SESSION['email']=$email;
            $_SESSION['created']=true;
            $_SESSION['start']=time();
            $_SESSION['expiry']=$_SESSION['start']+(60*60*24);
            // echo("Account Created Successfully.");
            header("location: ourcategories.php");
        }
        elseif($num>0){
            session_start();
            $_SESSION['exists']=true;
            header("location: signup.php");
            // echo('Already user');
        }
        else{
            echo(mysqli_error($conn));
        }
    }

?>