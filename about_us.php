<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();

?>

<!-- Dev Forums - About Page -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dev Forums - About</title>
</head>
<body>
    <?php
    include('partials/_navbar.php');
    ?>

    <section class="about card my-5 py-5" style="z-index: -1 !important;">
        <h2 class="text-center text-dark">About Us</h2>
        <p style="font-size: 22px;" class="my-3">Dev Forums is a forums website specially for Developers. On Dev Forums you can ask various questions and can also answer about various topics related to Development. The various development topics include HTML, CSS, JavaScript, Bootstrap, Node Js, Python Flask, PHP and much more. You can also rate other people's response. You can access all answers of various questions without any account but to rate other's people answers or to respond to other people's questions, you need to login to your account or you need to create a new account if you don;t have an account before. This is the only place where you can get all answers for your Developerproblems and you can also help others. So enjoy.</p>
    </section>
    
    <?php
    include('partials/_footer.php');
    ?>
    <script>
        // Active Page
        document.getElementById('about').classList.add('active')
        document.getElementById('about').classList.add('disabled')
    </script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>