<?php
    session_start();
    require("error_pages.php");
    if(!isset($_SESSION["user_id"]) || $_SESSION["user_isadmin"]){
        echo json_encode(array("location" => HTTP_METHOD . $_SERVER['HTTP_HOST'] . "/login.php"));
        die();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["id"])){
            require("connection.php");
            require("DB_utils.php");
            $result = $mysqli->query("SELECT id FROM carts WHERE product = '" . htmlentities(mysqli_real_escape_string($mysqli, $_POST["id"])) . "' and customer = '" . $_SESSION["user_id"] . "'");
            if ($mysqli->errno){
                die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
            }
            if(mysqli_fetch_array($result)){
                echo "ALREDY";
                die();
            }
            mysqli_free_result($result);

            $result = $mysqli->query("SELECT stockavailability FROM appliances WHERE id = '" . htmlentities(mysqli_real_escape_string($mysqli, $_POST["id"])) . "'");
            if ($mysqli->errno){
                die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
            }
            if($row = mysqli_fetch_array($result)){
                if(!$row['stockavailability']){
                    echo "OUT";
                    die();
                }
            }
            else
                error400(true);
            mysqli_free_result($result);

            if(isset($_POST["count"]))
                execProcedure('AddToCart', $_SESSION["user_id"], $_POST["id"], $_POST["count"]);
            else
                execProcedure('AddToCart', $_SESSION["user_id"], $_POST["id"], 1);
            echo "ADDED";
            die();
        }
        else
            error400(true);
    }
    else
        error400(true);
?>