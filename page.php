<?php
require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();
$originalsql="SELECT * FROM `threads` WHERE `category_id`='$categ_id' LIMIT 0,10";
$originalres=mysqli_query($conn,$originalsql);
?>