<?php
    define("HTTP_METHOD", "http://");

    function error400($ajax = false){
        if($ajax)
            echo json_encode(array("location" => HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/ErrorPages/400.html"));
        else
            header("Location: " . HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/ErrorPages/400.html");
        die();
    }

    function error401($ajax = false){
        if($ajax)
            echo json_encode(array("location" => HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/ErrorPages/401.html"));
        else
            header("Location: " . HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/ErrorPages/401.html");
        die();
    }

    function error403($ajax = false){
        if($ajax)
            echo json_encode(array("location" => HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/ErrorPages/403.html"));
        else
            header("Location: " . HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/ErrorPages/403.html");
        die();
    }
?>