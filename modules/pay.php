<?php
    session_start();
    require_once("error_pages.php");
    require_once("DB_utils.php");
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone']) && isset($_POST['country']) && isset($_POST['city']) && isset($_POST['address']) && isset($_POST['post_code']) && isset($_POST['method']) && isset($_POST['card'])){
        if(!isset($_SESSION['user_id'])){
            error401(true);
        }
        if($_SESSION['user_isadmin'])
            error403(true);
        execProcedure('AddOrder', $_SESSION['user_id'], null, null, date('Y-m-d'), $_POST['phone'], $_POST['country'], $_POST['city'], $_POST['address'], $_POST['post_code'], $_POST['method'], $_POST['card']);
        echo json_encode(array("location" => HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/pay-confirm.php"));
        die();
    }
    else
        error400(true);
?>