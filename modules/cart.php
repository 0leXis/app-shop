<?php
    session_start();
    require_once("error_pages.php");
    require_once("DB_utils.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){
        if(!isset($_SESSION['user_id'])){
            error401(true);
        }
        if($_SESSION['user_isadmin'])
            error403(true);
        execProcedure('DeleteFromCart', $_SESSION['user_id'], $_POST['id']);
        echo "REFRESH";
        die();
    }
    else
        error400(true);
?>