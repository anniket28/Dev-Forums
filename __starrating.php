<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$trid=$_GET['tid'];
// echo($trid);

if(isset($_SESSION['login']) || $_SESSION['login']==true){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $sqlr="SELECT * FROM `threadratings` WHERE `threadresponse_id`='$trid'";
        $resr=mysqli_query($conn,$sqlr);
        $sql1="SELECT * FROM `threadsreponse` WHERE threadresponse_id='$trid'";
        $res1=mysqli_query($conn,$sql1);
        while($row=mysqli_fetch_assoc($res1)){
            $threadid=$row['thread_id'];
            if($row['user_id']==$_SESSION['uid']){
                echo('cant');
                session_start();
                $_SESSION['cant']=true;
                header('location: thread.php?tid='.$threadid);
                die;
            }
        }
        while($rowr=mysqli_fetch_assoc($resr)){
            // echo($threadid);
            // echo($rowr['userid']);
            // echo($_SESSION['uid']);
            if($rowr['userid']==$_SESSION['uid'] && $rowr['threadresponse_id']==$trid){
                echo('already rated');
                session_start();
                $_SESSION['already_rated']=true;
                header('location: thread.php?tid='.$threadid);
                die;
            }
        }

        $star=$_POST['stars'];
        if($star==null){
            $star=0;
        }
        // echo($star);
        $sql1="SELECT * FROM `threadsreponse` WHERE threadresponse_id='$trid'";
        $res1=mysqli_query($conn,$sql1);
        while($row=mysqli_fetch_assoc($res1)){
            $rating=$row['rating'];
            $starrating=$rating+$star;
            $threadid=$row['thread_id'];
            $userid=$_SESSION['uid'];
            $sql="INSERT INTO `threadratings` (`threadresponse_id`, `rating`, `userid`, `dateTime`) VALUES ('$trid', '$star', '$userid', current_timestamp());";
            $update="UPDATE `threadsreponse` SET `rating` = '$starrating' WHERE `threadsreponse`.`threadresponse_id` = '$trid';";
            $uresult=mysqli_query($conn,$update);
            $res=mysqli_query($conn,$sql);
            if($res){
                echo('ok');
                $_SESSION['rated']=true;
                header('location: thread.php?tid='.$threadid);
            }
            else{
                echo(mysqli_error($conn));
            }
        }
    }
}

elseif(!isset($_SESSION['login']) || $_SESSION['login']!=true){
    $sql1="SELECT * FROM `threadsreponse` WHERE threadresponse_id='$trid'";
    $res1=mysqli_query($conn,$sql1);
    while($row=mysqli_fetch_assoc($res1)){
        $threadid=$row['thread_id'];
        echo('Login');
        session_start();
        $_SESSION['login_require']=true;
        header('location: thread.php?tid='.$threadid);
    }
}

?>