<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$categ_type=$_GET['categories'];
?>

<?php
    if(isset($_SESSION['login_require']) || $_SESSION['login_require']==true){
        echo('<div style="margin-bottom: 1px;" class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>You need to login first.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['login_require']);
?>

<?php
    if(isset($_SESSION['wrong_password']) || $_SESSION['wrong_password']==true){
        echo('<div style="margin-bottom: 1px;" class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Invalid Password.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['wrong_password']);
?>

<?php
    session_start();
    if(isset($_SESSION['no_user']) || $_SESSION['no_user']==true){
        echo('<div style="margin-bottom: 1px;" class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>No user account exists with this email.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['no_user']);
?>

<!-- Dev Forums - Home Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums - Home</title>
</head>

<body>
    <div id="notloginned" style="margin-bottom: 1px;display: none;" class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>You need to login first.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="expired" style="margin-bottom: 1px;display: none;" class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Your session has expired and you need to login again..</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div id="special" style="margin-bottom: 1px;display: none;" class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Logged Out Successfully.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    <?php
    include('partials/_navbar.php');
    ?>
    
    <div class="container welcome">
        <h3 class="text-center">Welcome to <span style="color:#ff914D;"><</span> Dev Forums <span style="color:#ff914D;">></span></h3>
        <p class="text-center">An Only Developer's Discussion Place</p>
    </div>
    <div class="container categories my-2">
        <h3 class="text-center">Our Categories</h3>
        <h4 class="text-center">Here are same of our Major Discussion Categories</h4>
        <div class="container">
            <div class="row">
                <?php
                if($categ_type=='all'){
                    $fetch_categories='SELECT * FROM `categories`';
                }
                else{
                    $fetch_categories='SELECT * FROM `categories` LIMIT 5';
                }
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
                <?php
                if($categ_type=='all'){   
                }
                else{
                    echo('
                    <div class="col my-4">
                        <div class="card last-card">
                            <div class="card-body">
                                <p class="card-text"><a class="text-dark" href="/Dev Forums/?categories=all">All Categories</a></p>
                            </div>
                        </div>
                    </div>
                    ');
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

    if(window.location.href=='http://localhost/Dev%20Forums/'){
        document.getElementById('home').classList.add('active')
        document.getElementById('home').classList.add('disabled')
    }

    // Logout
    if(window.location.href=='http://localhost/Dev%20Forums/?logout'){
        document.getElementById('special').style.display='block'
        if(window.history.replaceState){
            window.history.replaceState(null,null,'http://localhost/Dev%20Forums/')
        }
    }

    // Not Login
    if(window.location.href=='http://localhost/Dev%20Forums/?not_loginned'){
        document.getElementById('notloginned').style.display='block'
        if(window.history.replaceState){
            window.history.replaceState(null,null,'http://localhost/Dev%20Forums/')
        }
    }

    // Login Expired
    if(window.location/href=="http://localhost/Dev%20Forums/?login_expired"){
        document.getElementById('expired').style.display='block'
        if(window.history.replaceState){
            window.history.replaceState(null,null,'http://localhost/Dev%20Forums/')
        }
    }
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>