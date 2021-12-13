<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$search=$_GET['search'];
// echo($search);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums</title>
</head>

<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <h2 class="text-center my-3">Search Result</h2>
    <div class="container my-4">
        <?php
        $sql="SELECT * FROM `categories` WHERE `category_description` LIKE '%$search%'";
        $result=mysqli_query($conn,$sql);
        echo('
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="accordion" id="accordioncategs">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecategs" aria-expanded="true" aria-controls="collapseOne">
                    Categories Search Result
                    </button>
                    </h2>
                    <div id="collapsecategs" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordioncategs">');
        if(mysqli_num_rows($result)==0){
            echo('
            <h4 class="px-3 py-4">No search result found for this query in categories.</h4>
            </div>
            </div>
            </div>
            </div>
            ');
        }
        else{
            echo('
                        <div class="accordion-body py-1">
                             <div class="container categories my-2">
                                <div class="row">
                                    
            ');
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
            echo('                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>');
        }
        ?>
    </div>

    <div style="margin-bottom: 25px;" class="px-5 mx-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="accordion" id="accordionDiscussions">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiscussions" aria-expanded="true" aria-controls="collapseOne">
                        Threads Search Result
                    </button>
                    </h2>
                    <div id="collapseDiscussions" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionDiscussions">
                        <?php
                        $sql="SELECT * FROM `threads` WHERE `question` LIKE '%$search%'";
                        $result=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $dat=$row['dateTime'];
                                $dt=new DateTime($dat);
                                $thread_date=$dt->format('d-m-Y, g:i a');
                                echo('
                                <div class="accordion-body py-1">
                                    <div class="post-preview">
                                        <a class="text-dark" href="thread.php?tid='.$row['thread_id'].'">
                                            <h2 class="post-title my-1">'.$row['title'].'</h2>
                                        </a>
                                        <h5 class="my-3">'.$row['question'].'</h5>
                                        <p style="text-align: end;" class="post-meta">Posted by <a class="text-dark" style="text-decoration: none;"> <strong> ' . $row['postedby'] .' </strong> </a>
                                            on <span class="text-dark">'.$thread_date.'</span>
                                        </p>
                                    </div>');
                                    if(mysqli_num_rows($result)>1){
                                        echo('
                                        <!-- Divider-->
                                        <hr style="margin-bottom: 0px">
                                        </div>
                                        ');
                                    }
                                    else{
                                        echo('</div>');
                                    }
                            }
                        }
                        else{
                            echo('<h4 class="px-3 py-4">No search result found for this query in our threads.</h4>');
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 50px;" class="px-5 mx-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="accordion" id="accordionThreads">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreads" aria-expanded="true" aria-controls="collapseOne">
                        Discussions Search Result
                    </button>
                    </h2>
                    <div id="collapseThreads" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionThreads">
                        <?php
                        $sql="SELECT * FROM `threadsreponse` WHERE `response` LIKE '%$search%'";
                        $result=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $trid=$row['threadresponse_id'];
                                $dat=$row['dateTime'];
                                $dt=new DateTime($dat);
                                $resp_date=$dt->format('d-m-Y, g:i a');
                                echo('
                                <div class="accordion-body py-1">
                                    <div class="post-preview">
                                        <div class="text-dark">
                                            <h2 class="post-title my-1">'.$row['response'].'</h2>
                                        </div>
                                        <p class="my-4" style="font-size: 18px"> 
                                        <span style="text-align : start" class="post-meta">Rating : <strong>'.$row['rating'].'</strong></span>
                                        <span style="float: right;" class="post-meta">Responded by <a class="text-dark" style="text-decoration: none;"> <strong> ' . $row['responseby'] .' </strong> </a>
                                            on <span class="text-dark">'.$resp_date.'</span>
                                        </p>
                                    </div>
                                    <p style="margin-top: 3px;margin-bottom: 0px; font-size:18px"><strong>Rate this response</strong></p>
                                    ');
                                    echo('
                                    <style>
                                    .rating {
                                        display: inline-block;
                                        position: relative;
                                        height: 50px;
                                        line-height: 50px;
                                        font-size: 30px;
                                      }
                                      
                                      .rating label {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        height: 100%;
                                        cursor: pointer;
                                      }
                                      
                                      .rating label:last-child {
                                        position: static;
                                      }
                                      
                                      .rating label:nth-child(1) {
                                        z-index: 5;
                                      }
                                      
                                      .rating label:nth-child(2) {
                                        z-index: 4;
                                      }
                                      
                                      .rating label:nth-child(3) {
                                        z-index: 3;
                                      }
                                      
                                      .rating label:nth-child(4) {
                                        z-index: 2;
                                      }
                                      
                                      .rating label:nth-child(5) {
                                        z-index: 1;
                                      }
                                      
                                      .rating label input {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        opacity: 0;
                                      }
                                      
                                      .rating label .icon {
                                        float: left;
                                        color: transparent;
                                      }
                                      
                                      .rating label:last-child .icon {
                                        color: #000;
                                      }
                                      
                                      .rating:not(:hover) label input:checked ~ .icon,
                                      .rating:hover label:hover input ~ .icon {
                                        color: green;
                                      }
                                      
                                      .rating label input:focus:not(:checked) ~ .icon:last-child {
                                        color: #000;
                                        text-shadow: 0 0 5px greenyellow;
                                      }
                                    </style>
                                    
                                        <form action="__starrating.php?tid='.$trid.'" method="post">
                                            <div class="rating">
                                                <label>
                                                    <input type="radio" name="stars" id="s" value="1">
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="stars" id="s" value="2">
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="stars" id="s" value="3">
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="stars" id="s" value="4">
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                                <label>
                                                    <input type="radio" name="stars" id="s" value="5">
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                    <span class="icon">★</span>
                                                </label>
                                            </div>
                                            <button class="btn btn-success" style="margin-bottom: 35px;margin-left: 10px">Submit</button>
                                        </form>
                                        ');

                                    if(mysqli_num_rows($result)>1){
                                        echo('
                                        <!-- Divider-->
                                        <hr style="margin-bottom: 0px">
                                    </div>
                                        ');
                                    }
                                    else{
                                        echo('
                                </div>
                                ');
                                    }
                            }
                        }
                        else{
                            echo('<h4 class="px-3 py-4">No search result found for this query in our discussions.</h4>');
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('partials/_footer.php');
    ?>
     <script>
        
    </script>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>