<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');

?>

<!-- Dev Forums - Sign Up Page -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums - Sign Up</title>
</head>
<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <?php
    session_start();
    if(isset($_SESSION['exists']) || $_SESSION['exists']==true){
        echo('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>User with this email already exists.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['exists']);
    ?>


    <section class="signup">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Sign Up</h2>
                <form action="__signupscript.php" method="POST">
                    <div class="mb-3">
                        <label for="nam" class="form-label">Name :</label>
                        <input type="text" name="name" class="form-control" id="nam" placeholder="Enter your name here">
                        <div class="required" id="name-req">Name cannot be blank.</div>
                    </div>
                    <div class="mb-3">
                        <label for="mail" class="form-label">Email address :</label>
                        <input type="email" name="email" class="form-control" id="mail" placeholder="Enter your email here">
                        <div class="required" id="email-req">Email cannot be blank.</div>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Password :</label>
                        <input type="password" name="password" class="form-control" id="pass" placeholder="Enter your password here">
                        <div class="required" id="pass-req">Password cannot be blank.</div>
                        <div class="required" id="pass-format">Password should contain 8 or more than 8 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label for="cpass" class="form-label">Confirm Password :</label>
                        <input type="password" name="confirm_password" class="form-control" id="cpass" placeholder="Rewrite your password here to confirm">
                        <div class="required" id="cpass-req">Confirm Password cannot be blank.</div>
                    </div>
                    <div class="required" id="pass-match">Password and Confirm password do not match.</div>
                    <button type="submit" id="sub" class="btn btn-primary my-2">Submit</button>
                    <button type="reset" class="btn btn-primary my-1">Reset</button>
                </form>
            </div>
        </div>
    </section>
    <?php
    include('partials/_footer.php');
    ?>
    <script>
        // Active Page
        document.getElementById('signup').classList.add('active')
        document.getElementById('signup').classList.add('disabled')

        // Field Required
        document.getElementById('sub').addEventListener('click',(event)=>{
            if(document.getElementById('nam').value==0 || document.getElementById('nam').value==null){
                document.getElementById('name-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('nam').value!=0 || document.getElementById('nam').value!=null){
                document.getElementById('name-req').style.display='none'
            }
            if(document.getElementById('mail').value==0 || document.getElementById('mail').value==null){
                document.getElementById('email-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('mail').value!=0 || document.getElementById('mail').value!=null){
                document.getElementById('email-req').style.display='none'
            }
            if(document.getElementById('pass').value==0 || document.getElementById('pass').value==null){
                document.getElementById('pass-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('pass').value!=0 || document.getElementById('pass').value!=null){
                document.getElementById('pass-req').style.display='none'
            }
            if(document.getElementById('pass').value.length<=7){
                document.getElementById('pass-format').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('pass').value.length>=8){
                document.getElementById('pass-format').style.display='none'
            }
            if(document.getElementById('cpass').value==0 || document.getElementById('cpass').value==null){
                document.getElementById('cpass-req').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('cpass').value!=0 || document.getElementById('cpass').value!=null){
                document.getElementById('cpass-req').style.display='none'
            }
            if(document.getElementById('pass').value!=document.getElementById('cpass').value){
                document.getElementById('pass-match').style.display='block'
                event.preventDefault()
            }
            else if(document.getElementById('pass').value==document.getElementById('cpass').value){
                document.getElementById('pass-match').style.display='none'
            }
        })
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>