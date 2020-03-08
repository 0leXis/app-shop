<?php
    //[ 'column' => 'join query' ]
    function formTableRows($selectQuery, $addChangeBtn, $addDeleteBtn, $replaceJoinsCols = null, $hiddenRows = null){
        require('connection.php');
        $result = $mysqli->query($selectQuery);
        if ($mysqli->errno){
            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        $has_rows = false;
        while ($row = mysqli_fetch_row($result)) {
            $has_rows = true;
            echo '<tr>';
            for($col = 0; $col < count($row); $col++){
                echo "<td";
                if(!is_null($hiddenRows) && in_array($col, $hiddenRows))
                    echo ' style="display: none;"';
                if(is_null($row[$col]))
                    echo ' data-id="null">Нет данных';
                else
                if(!is_null($replaceJoinsCols) && array_key_exists($col, $replaceJoinsCols)){
                    $joinResult = $mysqli->query($replaceJoinsCols[$col]);
                    if ($mysqli->errno){
                        die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                    }
                    while($join_row = mysqli_fetch_row($joinResult))
                        if($join_row[0] == $row[$col]){
                            echo ' data-id="' . $row[$col] . '">' . $join_row[1];
                            break;
                        }
                }
                else
                    echo ">" . $row[$col];
                echo "</td>";
            }
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