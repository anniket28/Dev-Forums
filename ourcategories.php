<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

if(!isset($_SESSION['uid'])){
    $email=$_SESSION['email'];
    $sql="SELECT * FROM `users` WHERE `email`='$email'";
    $res=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($res)){
        $_SESSION['uid']=$row['sno'];
    }
}

if(!isset($_SESSION['login']) || $_SESSION['login']!=true){
    $_SESSION['notlogin']==true;
    header('location:/Dev Forums/?not_loginned');
}

// echo($_SESSION['start']);
// echo('<br>');
// echo($_SESSION['expiry']);
// echo('<br>');
// echo(time());
if(time()>$_SESSION['expiry']){
    session_unset();
    session_destroy();
    header('location:/Dev Forums/?login_expired');
}

?>

<!-- Dev Forums - Categories Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums - Categories</title>
</head>

<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <?php
    session_start();
    if(isset($_SESSION['created']) || $_SESSION['created']==true){
        echo('<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Account Created Successfully.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['created']);
    ?>

    <?php
    session_start();
    if(isset($_SESSION['loggedin']) || $_SESSION['loggedin']==true){
        echo('<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Login Successfull.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['loggedin']);
    ?>

    <?php
    if(isset($_SESSION['login']) || $_SESSION['login']==true){
        echo('
        <h4 class="my-2 mx-2">Welcome '.$_SESSION['username'].'</h4>
        <div style="margin-bottom: 8px !important;" class="dropdown-divider"></div>
        ');
    }
    ?>
    <div class="container welcome">
        <h3 class="text-center">Welcome to <span style="color:#ff914D;"><</span> Dev Forums <span style="color:#ff914D;">></span></h3>
        <p class="text-center">An Only Developer's Discussion Place</p>
    </div>
    <div class="container categories my-2">
        <h3 class="text-center">Our Categories</h3>
        <div class="container">
            <div class="row">
                <?php
                $fetch_categories='SELECT * FROM `categories`';
                $result=mysqli_query($conn,$fetch_categories);
                while($row=mysqli_fetch_assoc($result)){
                    $img=$row['category_image'];
                    $cat_name=$row['category_name'];
                    $cat_desc=$row['category_description'];
                    echo('
                    <div class="col my-4">
                        <div class="card">
                            <img src="'.$img.'" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">'.$cat_name.'</h5>
                                <p class="card-text">'.substr($cat_desc,0,95).'...</p>
                                <div class="text-center"><a href="forum.php?cid='.$row['category_id'].'&'.$row['category_name'].'" class="btn btn-primary">View More</a></div>
                            </div>
                        </div>
                    </div>');
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    include('partials/_footer.php');
    ?>
     <script>
        // Active Page
        document.getElementById('ourcateg').classList.add('active')
        document.getElementById('ourcateg').classList.add('disabled')
    </script>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>