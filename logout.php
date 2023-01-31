<?php
    //Import config and initialize session
    require_once "./config.php";
    session_start();

    //Clear all the session variables
    $_SESSION = array();

    //Destroy session and take the user to the home page
    session_destroy();
    header("location: ./");
    exit;
?>