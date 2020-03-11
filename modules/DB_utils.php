<?php
    function searchID($table, $id){
        require('connection.php');
        $result = $mysqli->query("SELECT * FROM $table WHERE id = $id");
        if ($mysqli->errno){
            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        if ($row = mysqli_fetch_row($result)){
            mysqli_free_result($result);
            return $row;
        }
        mysqli_free_result($result);
        return null;
    }

    function getRowsCount($table){
        require('connection.php');
        $result = $mysqli->query("SELECT COUNT(*) FROM $table");
        if ($mysqli->errno){
            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        if ($row = mysqli_fetch_row($result)){
            mysqli_free_result($result);
            return $row[0];
        }
        mysqli_free_result($result);
        return null;
    }
    
    function execProcedure($procedureName, ...$params){
        require('connection.php');
        $quary = "call $procedureName(";
        $first = true;
        foreach($params as $param){
            if(!$first){
                $quary .= ',';
            }
            $first = false;
            if($param === null)
                $quary .= 'null';
            else
                $quary .= '\'' . htmlentities(mysqli_real_escape_string($mysqli, $param)) . '\'';
        }
        $quary .= ")";
        $result = $mysqli->query($quary);
        if ($mysqli->errno){
            die('Procedure Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        return $result;
    }
?>