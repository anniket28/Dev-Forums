<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$categ_id = $_GET['cid'];
$email=$_SESSION['email'];
$uid=$_SESSION['uid'];

// echo($email);

if(isset($_SESSION['login']) || $_SESSION['login']==true){
    // echo('ok');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $ftitle=$_POST['title'];
        $title=mysqli_escape_string($conn,$ftitle);
        // echo($title);
        $fquestion=$_POST['question'];
        $question=mysqli_escape_string($conn,$fquestion);

        $title = str_replace("<", "&lt;", $title);
        $title = str_replace(">", "&gt;", $title); 

        $question = str_replace("<", "&lt;", $question);
        $question = str_replace(">", "&gt;", $question); 

        // echo($question);
        $categ = "SELECT * FROM `categories` WHERE `category_id`='$categ_id'";
        $result = mysqli_query($conn, $categ);
        $user="SELECT * FROM `users` WHERE sno='$uid'";
        $fetch_user=mysqli_query($conn,$user);
        // echo(mysqli_num_rows($fetch_user));
        $random=rand(0,1000);
        // echo($random);
        $id=password_hash($random,PASSWORD_DEFAULT);
        while($rowc = mysqli_fetch_assoc($result)){
            $categ_name=$rowc['category_name'];
            while($row=mysqli_fetch_assoc($fetch_user)){
                $username=$row['name'];
                $insert="INSERT INTO `threads` (`category_id`, `thread_id`, `title`, `question`, `postedby`, `user_id`, `dateTime`) VALUES ('$categ_id', '$id', '$title', '$question', '$username', '$uid', current_timestamp());";
                $res=mysqli_query($conn,$insert);
                if($res){
                    // echo('Done');
                    session_start();
                    // echo($categ_id);
                    $_SESSION['thread_added']=true;
                    header('location: forum.php?cid='.$categ_id.'&'.$categ_name);
                }
                else{
                    echo(mysqli_error($conn));
                }
            }
        }
    }
}
elseif(!isset($_SESSION['login']) || $_SESSION['login']!=true){
    $categ = "SELECT * FROM `categories` WHERE `category_id`='$categ_id'";
    $result = mysqli_query($conn, $categ);
    while($rowc = mysqli_fetch_assoc($result)){
        $categ_name=$rowc['category_name'];
        echo('Login');
        session_start();
        $_SESSION['login_require']=true;
        header('location: forum.php?cid='.$categ_id.'&'.$categ_name);
    }
}

?>