<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

$categ_id = $_GET['cid'];
$page=$_GET['page'];
// echo($page);
$limit=10;
if($page==null){
    $page=1;
}
// echo($categ_id);

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

<!-- Dev Forums - Forum Page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        .carousel-caption {
            bottom: 3rem;
            z-index: 10;
        }
        .carousel-item {
            height: 16.5rem;
        }
        .carousel-item>img {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            height: 32rem;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums - Forum</title>
</head>

<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <?php
        if(isset($_SESSION['thread_added']) || $_SESSION['thread_added']==true){
            echo('<div style="margin-bottom: 1px;" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Your thread has been started successfully. Please wait for someone to respond to it.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
        unset($_SESSION['thread_added']);
    ?>

    <?php
    // echo($categ_id);
    $categ = "SELECT * FROM `categories` WHERE `category_id`='$categ_id'";
    $result = mysqli_query($conn, $categ);
    while ($row = mysqli_fetch_assoc($result)) {
        $categ_name=$row['category_name'];
        echo ('<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#'.$row['category_color_code'].'"/></svg>
            <div class="container">
              <div class="carousel-caption text-start">
                <h1>' . $row['category_name'] . '</h1>
                <p class="py-1">' . $row['category_description'] . '</p>
              </div>
            </div>
          </div>
      </div>');
    }
    ?>
    <!-- Main Content-->
    <div class="container px-4 px-lg-5">
        
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="accordion my-5" id="accordionQuestion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseQuestion" aria-expanded="true" aria-controls="collapseOne">
                            Ask your Question and Start a Thread
                        </button>
                        </h2>
                        <div id="collapseQuestion" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionQuestion">
                            <div class="accordion-body">
                                <?php
                                echo('<form action="__forum.php?cid='.$categ_id.'" method="post">');
                                ?>
                                    <div class="mb-3">
                                        <label for="title" class="form-label"></label>
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Title of your Question Here"></input>
                                        <div class="required" id="title-req">Title cannot be blank.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ques" class="form-label"></label>
                                        <textarea name="question" class="form-control" id="ques" rows="3" placeholder="Your Question Here"></textarea>
                                        <div class="required" id="ques-req">Question cannot be blank.</div>
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

    <div style="margin-bottom: 50px;" class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="accordion" id="accordionThreads">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreads" aria-expanded="true" aria-controls="collapseOne">
                        Or Check Out some other threads from below
                    </button>
                    </h2>
                    <div id="collapseThreads" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionThreads">
                        <?php
                        $originalsql="SELECT * FROM `threads` WHERE `category_id`='$categ_id'";
                        $originalres=mysqli_query($conn,$originalsql);
                        $total_pages=ceil(mysqli_num_rows($originalres)/$limit);
                        $page_result=($page-1)*$limit;
                        // echo($page_result);
                        $sql="SELECT * FROM `threads` WHERE `category_id`='$categ_id' LIMIT $page_result,$limit";
                        // elseif($page==$total_pages){
                        //     $sql="SELECT * FROM `threads` WHERE `category_id`='$categ_id'";
                        // }
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
                                    </div>
                                    <!-- Divider-->
                                    <hr style="margin-bottom: 0px">
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
                                <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'&page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                ');
                                // echo($total_pages);
                            }
                            elseif($page==$total_pages){
                                if($total_pages-1==1){
                                    echo(' <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                      </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                        <a><button style="float:right" class="btn btn-success disabled my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                        ');
                                }
                                else{
                                    echo(' <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'&page='. $total_pages-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
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
                                    echo(' <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                      </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                      <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'&page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                                }
                                else{
                                    echo(' <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'&page='. $page-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                      </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                      <a href="forum.php?cid='.$categ_id.'&'.$categ_name.'&page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                                }
                            }

                        }
                        else{
                            echo('<h4 class="px-3 py-4">No threads about this topic yet. Start a thread by asking a question.</h4>');
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
        document.getElementById('sub').addEventListener('click',(event)=>{
            if(document.getElementById('title').value==0 || document.getElementById('title').value==null){
                document.getElementById('title-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('title').value!=0 || document.getElementById('title').value!=null){
                document.getElementById('title-req').style.display='none'
            }
            if(document.getElementById('ques').value==0 || document.getElementById('ques').value==null){
                document.getElementById('ques-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('ques').value!=0 || document.getElementById('ques').value!=null){
                document.getElementById('ques-req').style.display='none'
            }
        })
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>