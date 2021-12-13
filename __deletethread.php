<?php

require('partials/_dbconnection.php');
require('partials/_dbconnectioncheck.php');
session_start();
$thread_id=$_GET['tid'];
echo($thread_id);
$delete="DELETE FROM `threads` WHERE `threads`.`sno` = $thread_id";
$deleteres=mysqli_query($conn,$delete);
if($deleteres){
    session_start();
    $_SESSION['delete']=true;
    header("location: my-threads.php");
}
else{
    echo(mysqli_error($conn));
}

?>