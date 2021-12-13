<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

if(!isset($_SESSION['login']) || $_SESSION['login']!=true){
    $_SESSION['notlogin']==true;
    header('location:/Dev Forums/?not_loginned');
}

if(time()>$_SESSION['expiry']){
    session_unset();
    session_destroy();
    header('location:/Dev Forums/?login_expired');
}

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
    <title>Dev Forums -  Change Password</title>
</head>

<body>
    <?php
    include('partials/_navbar.php');
    ?>
    <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        // echo($_SESSION['email']);
        $email=$_SESSION['email'];
        $pass=$_POST['password'];
        $password=mysqli_escape_string($conn,$pass);
        $profile="SELECT * FROM `users` WHERE email='$email'";
        $result=mysqli_query($conn,$profile);
        while($row=mysqli_fetch_assoc($result)){
            // echo(var_dump(password_verify($password,$row['password'])));
            if(password_verify($password,$row['password'])){
                // echo('same');
                $_SESSION['same_as_old']=true;
            }
            else{
                $newpassword=password_hash($password,PASSWORD_DEFAULT);
                $change="UPDATE `users` SET `password` = '$newpassword' WHERE `users`.`email`='$email';";
                $changepass=mysqli_query($conn,$change);
                if($changepass){
                    // echo('ok');
                    $_SESSION['changed']=true;
                }
                else{
                    echo(mysqli_error($conn));
                }
            }
        }
    }
    ?>

    <?php
    session_start();
    if(isset($_SESSION['changed']) || $_SESSION['changed']==true){
        echo('<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Password Changed Successfully.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['changed']);
    ?>

    <?php
    session_start();
    if(isset($_SESSION['same_as_old']) || $_SESSION['same_as_old']==true){
        echo('<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>New Password cannot be same as the old password.</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>');
    }
    unset($_SESSION['same_as_old']);
    ?>

    <div class="container">
        <div class="card px-5 py-5" style="margin: 130px">
            <h2 class="card-title text-center">Change Password</h2>
            <p><strong>Your Email : </strong><?php echo($_SESSION['email']) ?></p>
            <form action="change-password.php" method="POST">
            <div class="mb-3">
                        <label for="pass" class="form-label">New Password :</label>
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
            </form>
        </div>
    </div>
    <?php
    include('partials/_footer.php');
    ?>

    <script>
    // Required
    document.getElementById('sub').addEventListener('click',(event)=>{
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

    // Active Page
    document.getElementById('changepass').classList.add('active')
    document.getElementById('changepass').classList.add('disabled')

    // 
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>