<?php
    //Предоставляет соединение с БД
    $host = 'localhost';
    $database = 'appliancesshop';
    $user = 'root';
    $password = '12345';

    $mysqli = new mySQLi($host, $user, $password, $database);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
?>