<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$categ_id = $_GET['cid'];
// echo($categ_id);
$page=$_GET['page'];
// echo($page);
$limit=10;
if($page==null){
    $page=1;
}

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

<!-- Dev Forums - Thread Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        .b-example-divider {
            height: 2rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 0.5em 1.5em rgb(0 0 0 / 10%), inset 0 0.125em 0.5em rgb(0 0 0 / 15%);
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums - Thread</title>
</head>

<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <?php
        if(isset($_SESSION['response_added']) || $_SESSION['response_added']==true){
            echo('<div style="margin-bottom: 1px;" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thank You for responsing to this thread.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
        unset($_SESSION['response_added']);
    ?>

    <?php
        if(isset($_SESSION['already_rated']) || $_SESSION['already_rated']==true){
            echo('<div style="margin-bottom: 1px;" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Sorry, but you have already rated the response and you can\'t rate again.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
        unset($_SESSION['already_rated']);
    ?>
    
    <?php
        if(isset($_SESSION['cant']) || $_SESSION['cant']==true){
            echo('<div style="margin-bottom: 1px;" class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>!!! Sorry, but you can\'t rate your own response.😄</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
        unset($_SESSION['cant']);
    ?>
    
    <?php
        if(isset($_SESSION['rated']) || $_SESSION['rated']==true){
            echo('<div style="margin-bottom: 1px;" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thank You for rating the response.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
        unset($_SESSION['rated']);
    ?>

    <?php
    $th_id=$_GET['tid'];
    $threadsql="SELECT * FROM `threads` WHERE `thread_id`='$th_id'";
    $thread=mysqli_query($conn,$threadsql);
    while($row=mysqli_fetch_assoc($thread)){
        $cat_id=$row['category_id'];
        // echo($cat_id);
        $categsql="SELECT * FROM `categories` WHERE `category_id`='$cat_id'";
        $categ=mysqli_query($conn,$categsql);
        while($rowt=mysqli_fetch_assoc($categ)){
            $dat=$row['dateTime'];
            $dt=new DateTime($dat);
            $thread_date=$dt->format('d-m-Y, g:i a');
            echo('
            <div class="py-3 container">
                <h1 style="font-size: 25px" class="display-5 fw-bold">Category : '.$rowt['category_name'].'</h1>
                <div class="dropdown-divider"></div>
                <div class="mx-auto col-lg-7">
                    <h2 class="my-2"><strong>Title : </strong>'.$row['title'].'</h2>
                    <h3 style="margin-top: 10px;font-size: 26.5px;"><strong>Description : </strong>'.$row['question'].'</h3>
                    <h6 style="text-align: end;font-size: 17px"><strong>Posted By : </strong>'.$row['postedby'].'</h6>
                    <h6 style="text-align: end;font-size: 17px">Posted on '.$thread_date.'</h6>
                </div>
            </div>
            ');
        }
    }
    ?>
  <div class="b-example-divider"></div>

  <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="accordion my-5" id="accordionQuestion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuestion" aria-expanded="true" aria-controls="collapseOne">
                            Respond to this thread and start a discussion
                        </button>
                        </h2>
                        <div id="collapseQuestion" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionQuestion">
                            <div class="accordion-body">
                                <?php
                                echo('<form action="__thread.php?tid='.$th_id.'" method="post">');
                                ?>
                                    <div class="mb-3">
                                        <label for="resp" class="form-label"></label>
                                        <textarea name="response" class="form-control" id="resp" rows="3" placeholder="Your Response Here"></textarea>
                                        <div class="required" id="response-req">Response cannot be blank.</div>
                                    </div>
                                    <button class="btn btn-success" id="sub" type="submit">Submit</button>
                                    <button class="btn btn-success m x-2" type="reset">Reset</button>
                                </form>
                            </div>
                        </div>
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
                    Check out other discussions about this thread
                    </button>
                    </h2>
                    <div id="collapseThreads" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionThreads">
                        <?php
                        $originalsql="SELECT * FROM `threadsreponse` WHERE `thread_id`='$th_id'";
                        $originalres=mysqli_query($conn,$originalsql);
                        $total_pages=ceil(mysqli_num_rows($originalres)/$limit);
                        $page_result=($page-1)*$limit;

                        $sql="SELECT * FROM `threadsreponse` WHERE `thread_id`='$th_id' ORDER BY `rating` DESC LIMIT $page_result,$limit";
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
                                    <div class="container">
                                        <div class="dropdown-divider"></div>
                                    </div>
                                    <p style="margin-top: 5px;margin-bottom: 0px; font-size:18px"><strong>Rate this response</strong></p>
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
                                        <!-- Divider-->
                                        <div style="height: 3px;" class="b-example-divider"></div>
                                    </div>
                                    ');
                            }
                            if($page==1 && mysqli_num_rows($originalres)<=10){
                                echo(' <a><button class="btn btn-success disabled my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                  </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                    <a><button style="float:right" class="btn btn-success disabled my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                  </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                    ');
                            }
                            elseif($page==1){
                                echo(' <a><button class="btn btn-success disabled my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                <a href="thread.php?tid='.$th_id.'&page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                ');
                                // echo($total_pages);
                            }
                            elseif($page==$total_pages){
                                if($total_pages-1==1){
                                    echo(' <a href="thread.php?tid='.$th_id.'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                      </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                        <a><button style="float:right" class="btn btn-success disabled my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                        ');
                                }
                                else{
                                    echo(' <a href="thread.php?tid='.$th_id.'&page='. $total_pages-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                  </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                    <a><button style="float:right" class="btn btn-success disabled my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                  </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                    ');
                                }
                            }
                            else{
                                if($page-1==1){
                                    echo(' <a href="thread.php?tid='.$th_id.'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                      </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                      <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'&page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                                }
                                else{
                                    echo(' <a href="thread.php?tid='.$th_id.'&page='. $page-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                      </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                      <a href="thread.php?tid='.$th_id.'&page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                                }
                            }

                        }
                        else{
                            echo('<h4 class="px-3 py-4">No responses about this thread yet. Start a discussion by responding to this thread.</h4>');
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
        // 
        document.getElementById('sub').addEventListener('click',(event)=>{
            if(document.getElementById('resp').value==0 || document.getElementById('resp').value==null){
                document.getElementById('response-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('resp').value!=0 || document.getElementById('ques').value!=null){
                document.getElementById('response-req').style.display='none'
            }
        })

    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>