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

if(time()>$_SESSION['expiry']){
  session_unset();
  session_destroy();
  header('location:/Dev Forums/?login_expired');
}

?>

<?php
    if(!isset($_SESSION['login']) || $_SESSION['login']!=true){
        $_SESSION['notlogin']==true;
        header('location:/Dev Forums/?not_loginned');
    }
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
    <title>Dev Forums - My Threads</title>
</head>

<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <?php
        if(isset($_SESSION['delete']) || $_SESSION['delete']==true){
            echo('<div style="margin-bottom: 1px;" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Your thread has been deleted successfully.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }
        unset($_SESSION['delete']);
    ?>

    <div class="container my-5">
        <div class="card">
            <h2 class="text-center card-title my-5" style="margin-bottom: 10px !important">My Threads</h2>
            <div class="py-3 container">
                <!-- <div class="dropdown-divider"></div> -->
            <?php
            $email=$_SESSION['email'];
            $uid=$_SESSION['uid'];
            // echo($email);
            // echo($th_id);
            $sql="SELECT * FROM `users` WHERE `sno`='$uid'";
            $result=mysqli_query($conn,$sql);
            while($row=mysqli_fetch_assoc($result)){
                // echo($userid);
                $originalsql="SELECT * FROM `threads` WHERE `user_id`='$uid'";
                $originalres=mysqli_query($conn,$originalsql);
                $total_pages=ceil(mysqli_num_rows($originalres)/$limit);
                $page_result=($page-1)*$limit;
                // echo($page_result);
                $mythreads="SELECT * FROM `threads` WHERE `user_id`='$uid' LIMIT $page_result,$limit";
                $myt=mysqli_query($conn,$mythreads);
                // echo(mysqli_num_rows($myt));
                if(mysqli_num_rows($myt)==0){
                    echo('
                    <style>
                        footer{
                            position: absolute;
                            bottom: 0px;
                            width: 100%;
                        }
                    </style>
                    <h4 class="px-3 py-4">You have not added any threads yet.</h4>');
                }
                else{
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
                        <a href="my-threads.php?page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                        ');
                        // echo($total_pages);
                    }
                    elseif($page==$total_pages){
                        if($total_pages-1==1){
                            echo(' <a href="my-threads.php"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                <a><button style="float:right" class="btn btn-success disabled my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                ');
                        }
                        else{
                            echo(' <a href="my-threads.php?page='. $total_pages-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
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
                            echo(' <a href="my-threads.php"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                              <a href="my-threads.php?page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                        }
                        else{
                            echo(' <a href="my-threads.php?page='. $page-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                              <a href="my-threads.php?page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                        }
                    }
                    echo('<div class="dropdown-divider"></div>');
                    while($row=mysqli_fetch_assoc($myt)){
                        $dat=$row['dateTime'];
                        $dt=new DateTime($dat);
                        $thread_date=$dt->format('d-m-Y, g:i a');
                        // echo(mysqli_num_rows($myt));
                        echo('
                        <div class="post-preview container my-3">
                            <a class="text-dark" href="thread.php?tid='.$row['thread_id'].'">
                                <h2 class="post-title my-1">'.$row['title'].'</h2>
                            </a>
                            <h5 class="my-3">'.$row['question'].'</h5>
                            <div style="text-align: end;"><a href="__deletethread.php?tid='.$row['sno'].'"><button onclick="return confirmation()" class="btn btn-danger">Delete Thread</button></div></a>
                            <p style="text-align: end;" class="post-meta my-2">Posted on <span class="text-dark">'.$thread_date.'</span>
                            </p>
                            <div class="dropdown-divider"></div>
                        </div>');
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
                        <a href="my-threads.php?page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                      </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                        ');
                        // echo($total_pages);
                    }
                    elseif($page==$total_pages){
                        if($total_pages-1==1){
                            echo(' <a href="my-threads.php"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                                <a><button style="float:right" class="btn btn-success disabled my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>
                                ');
                        }
                        else{
                            echo(' <a href="my-threads.php?page='. $total_pages-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
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
                            echo(' <a href="my-threads.php"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                              <a href="my-threads.php?page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                        }
                        else{
                            echo(' <a href="my-threads.php?page='. $page-1 .'"><button class="btn btn-success my-3 mx-4"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg><i class="bi bi-arrow-left-circle-fill"></i> Previous Threads</button></a>
                              <a href="my-threads.php?page='. $page+1 .'"><button style="float:right" class="btn btn-success my-3 mx-4">Next Threads <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                              </svg><i class="bi bi-arrow-right-circle-fill"></i> </button></a>');
                        }
                    }
                }
            }
            ?>
            </div>
        </div>
    </div>
    <?php
    include('partials/_footer.php');
    ?>
    <script>
        // 
        document.getElementById('mythreads').classList.add('active')
        document.getElementById('mythreads').classList.add('disabled')
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
        function confirmation(){
            return confirm("Are you sure you want to delete this thread?");
        }
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>