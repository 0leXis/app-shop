<?php
    //[ 'column' => 'join query' ]
    function formTableRows($selectQuery, $addChangeBtn, $addDeleteBtn, $replaceJoinsCols = null){
        require('connection.php');
        $result = $mysqli->query($selectQuery);
        if ($mysqli->errno){
            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        $has_rows = false;
        while ($row = mysqli_fetch_row($result)) {
            $has_rows = true;
            echo '<tr>';
            for($col = 0; $col < count($row); $col++)
                if(!is_null($replaceJoinsCols) && array_key_exists($col, $replaceJoinsCols)){
                    $joinResult = $mysqli->query($replaceJoinsCols[$col]);
                    if ($mysqli->errno){
                        die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                    }
                    while($join_row = mysqli_fetch_row($joinResult))
                        if($join_row[0] == $row[$col]){
                            echo '<td data-id="' . $row[$col] . '">' . $join_row[1] . '</td>';
                            break;
                        }
                }
                else
                    echo "<td>" . $row[$col] . "</td>";
            if($addChangeBtn)
                echo '<td><div class="change-btn" onclick="setChangeInfo(this)">&#10001;</div></td>';
            if($addDeleteBtn)
                echo '<td><div class="delete-cross-btn" onclick="deleteInfo(this, ' . $row[0] . ')">&times;</div></td>';
            echo '</tr>';
        }
        mysqli_free_result($result);
        return $has_rows;
    }

    function showNoDataMessage($cols){
        echo '<tr><td class="table-nodata" colspan="' . $cols . '">Нет данных</td></tr>';
    }
?>