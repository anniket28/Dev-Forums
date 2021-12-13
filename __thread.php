<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$thread_id = $_GET['tid'];
$email=$_SESSION['email'];
$uid=$_SESSION['uid'];

// echo($email);

if(isset($_SESSION['login']) || $_SESSION['login']==true){
    // echo('ok');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $tresponse=$_POST['response'];
        $response=mysqli_escape_string($conn,$tresponse);
        $response = str_replace("<", "&lt;", $response);
        $response = str_replace(">", "&gt;", $response); 
        // echo($question);
        $threadsql="SELECT * FROM `threads` WHERE `thread_id`='$thread_id'";
        $thread=mysqli_query($conn,$threadsql);
        while($row=mysqli_fetch_assoc($thread)){
            $cat_id=$row['category_id'];
            $categ = "SELECT * FROM `categories` WHERE `category_id`='$cat_id'";
            $result = mysqli_query($conn, $categ);
            $user="SELECT * FROM `users` WHERE sno='$uid'";
            $fetch_user=mysqli_query($conn,$user);
            // echo(mysqli_num_rows($fetch_user));
            $random=rand(0,1000);
            // echo($random);
            $id=password_hash($random,PASSWORD_DEFAULT);
            while ($rowc = mysqli_fetch_assoc($result)){
                $categ_name=$rowc['category_name'];
                while($row=mysqli_fetch_assoc($fetch_user)){
                    $username=$row['name'];
                    $insert="INSERT INTO `threadsreponse` (`threadresponse_id`, `thread_id`, `response`, `responseby`, `user_id`, `rating`, `dateTime`) VALUES ('$id', '$thread_id', '$response', '$username', '$uid',0 , current_timestamp());";
                    $res=mysqli_query($conn,$insert);
                    if($res){
                        // echo('Done');
                        session_start();
                        // echo($categ_id);
                        $_SESSION['response_added']=true;
                        header('location: thread.php?tid='.$thread_id);
                    }
                    else{
                        echo(mysqli_error($conn));
                    }
                }
            }
        }
    }
}
elseif(!isset($_SESSION['login']) || $_SESSION['login']!=true){
    echo('Login');
    session_start();
    $_SESSION['login_require']=true;
    header('location: thread.php?tid='.$thread_id);
}

?>