<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION["user"])){
        header('Location: '.'/login.php');
    }

    // print_r($_SESSION["user"]);
    if ($_SESSION["user"]["user_level_id"] == "3"){
        unset($_SESSION["user"]);
        header('Location: '.'/login.php');
    }
?>