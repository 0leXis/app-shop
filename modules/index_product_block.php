<?php
    require("error_pages.php");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!isset($_POST['id']))
            error400(true);
        require("products.php");
        formProductsForPBlock($_POST['id']);
    }   
    else{
        error400();
    }
?>