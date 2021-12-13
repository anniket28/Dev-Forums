<style>
    #lemail-req,#lpass-req{
        display: none;
        color: red;
        font-size: 18px;
    }
    .categ{
        text-decoration: none;
        z-index: 2;
    }
    .categ a:hover{
        color: black !important;
    }
    .required{
        color:red;
        display: none;
    }

</style>

<?php
session_start();
    echo('<nav class="navbar mx-auto me-auto navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">');
            if(isset($_SESSION['login']) || $_SESSION['login']==true){
                echo('
                <li class="nav-item">
                <a class="nav-link" id="ourcateg" style="margin-top:3px;" href="ourcategories.php">Categories</a>
                </li>');
            }
            else{
                echo('
                <li class="nav-item">
                <a class="nav-link" id="home" style="margin-top:3px;" href="/Dev Forums">Home</a>
                </li>');
            }
            echo('
            <li class="nav-item">
            <a class="nav-link" style="margin-top:3px;" id="about" href="about_us.php">About Us</a>
            </li>
            ');
            include('_contactus.php');
        echo('
        </ul>');

            echo('<a class="navbar-brand me-auto"> <span style="color:#ff914D;"><</span> Dev Forums <span style="color:#ff914D;">></span></a>');
        
        if(isset($_SESSION['login']) || $_SESSION['login']==true){
            echo('
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" id="mythreads" href="my-threads.php">My Threads</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="changepass" href="change-password.php">Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="__logout.php" onclick="return confirmation()"> Logout</a>
                </li>

                <li class="nav-item">
                <a class="nav-link btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#searchmodal" href="javascript:void(0)">Search</a>
                </li>
                <div class="modal fade" id="searchmodal" tabindex="-1" aria-labelledby="searchmodalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchmodalLabel">Search</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form class="d-flex" action="search.php?search='.$_POST['search'].'">
                                <input class="form-control me-2" name="search" id="search" type="text" placeholder="Search">
                                <button class="btn btn-success" id="ssub" type="submit">Search</button>
                            </form>
                            <div class="required" id="search-req">Search Keyword cannot be blank.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                document.getElementById("ssub").addEventListener("click",(event)=>{
                    if(document.getElementById("search").value==0 || document.getElementById("search").value==null){
                        document.getElementById("search-req").style.display="block"
                        event.preventDefault()
                    }
                    else if(document.getElementById("search").value!=0 || document.getElementById("search").value!=null){
                        document.getElementById("search-req").style.display="none"
                    }
                })
                </script>

            </ul>   
        </div>
        </div>          
    </nav>');
}
else{
            echo(' 
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" id="signup" href="signup.php">SignUp</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#loginmodal" id="login" href="javascript:void(0)">Login</a>
                </li>
                <div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="loginmodalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginmodalLabel">LOGIN</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="__loginscript.php" method="post">
                            <div class="mb-3">
                                <label for="mail" class="form-label">Email address :</label>
                                <input type="email" name="email" class="form-control" id="lmail" placeholder="Enter your email here">
                                <div class="required" id="lemail-req">Email cannot be blank.</div>
                            </div>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Password :</label>
                                <input type="password" name="password" class="form-control" id="lpass" placeholder="Enter your password here">
                                <div class="required" id="lpass-req">Password cannot be blank.</div>
                            </div>
                            <button type="submit" class="btn btn-success" id="lsub">Submit</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

                <li class="nav-item">
                <a class="nav-link btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#searchmodal" href="javascript:void(0)">Search</a>
                </li>
                <div class="modal fade" id="searchmodal" tabindex="-1" aria-labelledby="searchmodalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchmodalLabel">Search</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form class="d-flex" action="search.php?search='.$_POST['search'].'">
                                <input class="form-control me-2" name="search" id="search" type="text" placeholder="Search">
                                <button class="btn btn-success" id="ssub" type="submit">Search</button>
                            </form>
                            <div class="required" id="search-req">Search Keyword cannot be blank.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                document.getElementById("ssub").addEventListener("click",(event)=>{
                    if(document.getElementById("search").value==0 || document.getElementById("search").value==null){
                        document.getElementById("search-req").style.display="block"
                        event.preventDefault()
                    }
                    else if(document.getElementById("search").value!=0 || document.getElementById("search").value!=null){
                        document.getElementById("search-req").style.display="none"
                    }
                })
                </script>

            </ul>

            </div>
        </div>
    </nav>
            ');
        }

?>

<script>
    
    document.getElementById('lsub').addEventListener('click',(event)=>{
        if(document.getElementById('lmail').value==0 || document.getElementById('lmail').value==null){
            document.getElementById('lemail-req').style.display='block'
            event.preventDefault()
        }
        else if(document.getElementById('lmail').value!=0 || document.getElementById('lmail').value!=null){
            document.getElementById('lemail-req').style.display='none'
        }
        if(document.getElementById('lpass').value==0 || document.getElementById('lpass').value==null){
            document.getElementById('lpass-req').style.display='block'
            event.preventDefault()
        }
        else if(document.getElementById('lpass').value!=0 || document.getElementById('lpass').value!=null){
            document.getElementById('lpass-req').style.display='none'
        }
    })

    // 
    function confirmation(){
        return confirm("Are you sure you want to logout?")
    }
    
</script> 