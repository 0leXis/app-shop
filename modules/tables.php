<?php
    function formTableRows($selectQuary, $addChangeBtn, $addDeleteBtn){
        require('connection.php');
        $result = $mysqli->query($selectQuary);
        if ($mysqli->errno){
            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
        }
        $has_rows = false;
        while ($row = mysqli_fetch_row($result)) {
            $has_rows = true;
            echo '<tr>';
            for($col = 0; $col < count($row); $col++)
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