<?php

require('partials/_dbconnection.php');
if(!$conn){
    echo("<h1 style='text-align: center'>Sorry, We are facing some technical difficulties now. Please try again later.</h1>");
    exit();
}

?>