<?php 

    session_start();
    session_destroy();
    header("Location:index.php?msg=YOU ARE LOGGED OUT!");
    exit();

 ?>