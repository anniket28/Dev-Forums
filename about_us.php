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
    
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/carousel1.jpg" class="d-block w-100 carousel-images" alt="Web Development">
            </div>
            <div class="carousel-item">
                <img src="images/carousel2.jpg" class="d-block w-100 carousel-images" alt="Web Development">
            </div>
            <div class="carousel-item">
                <img src="images/carousel3.jpg" class="d-block w-100 carousel-images" alt="Web Development">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
        </button>
    </div>
    <section class="about card my-5">
        <h2 class="text-center text-dark">About Us</h2>
        <p class="my-3">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consectetur distinctio, illum animi magni dicta repudiandae ad autem praesentium architecto laboriosam quas impedit hic expedita earum dolores odit quam, magnam provident accusamus consequatur optio vitae quo est dignissimos? Natus minus, voluptatibus quod minima sint quibusdam qui error eligendi, amet molestias unde. Ea quas ab repudiandae excepturi reprehenderit laudantium provident est voluptatem exercitationem fugit? Eius ab vero necessitatibus? Atque adipisci eius fugit voluptas quaerat odio natus nam minus! Repellendus obcaecati saepe, at tenetur distinctio velit a eos, quibusdam earum non laudantium est officiis? Ipsum sequi cupiditate rerum quo corporis error dolorum nobis eligendi minus illo molestias, adipisci nemo laudantium dolor fugit et! Iusto sed illo veritatis nesciunt et? Sequi labore asperiores deserunt unde. Quasi libero tempora, veritatis iusto earum porro, quidem eos eaque numquam minus placeat rerum id esse voluptatibus, obcaecati repellat! Ducimus doloribus magni quasi explicabo, non dicta perspiciatis sequi sunt? Dicta iusto magnam placeat, delectus quis quae. Repellat obcaecati molestias, perspiciatis, veritatis laboriosam aperiam blanditiis, nam iusto tenetur quam fuga doloremque minus eligendi tempore tempora. Non distinctio accusamus deserunt sit voluptate magnam velit, laudantium rem quas dicta, sapiente, sint aliquam quo. Maxime, nobis repellat quam vero autem error voluptatem praesentium.</p>
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