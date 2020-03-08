<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление производителями</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form class="search-form" method="GET">
                    <h2>Поиск</h2>
                    <?php
                        if(isset($_GET['search_manufacturer_string'])){
                    ?>
                        <input type="text" name="search_manufacturer_string" placeholder="Введите id или название..." value="<?=$_GET['search_manufacturer_string']?>"/>
                    <?php
                        }
                        else{
                    ?>
                        <input type="text" name="search_manufacturer_string" placeholder="Введите id или название..."/>
                    <?php
                        }
                    ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="manufacturers-table">
				<tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Email</th>
                    <th>Страна</th>
                    <th>Редактировать</th>
					<th>Удалить</th>
				</tr>
                <?php
					if(isset($_GET['search_manufacturer_string'])){
						if(!formTableRows('SELECT * FROM manufacturers WHERE id = \'' . $_GET['search_manufacturer_string'] . '\' or Name like \'%' . $_GET['search_manufacturer_string'] . '%\'', true, true, [ 4 => 'SELECT * FROM countries'], [2]))
							showNoDataMessage(6);
					}
					else{
						if(!formTableRows('SELECT * FROM manufacturers', true, true, [ 4 => 'SELECT * FROM countries' ], [2]))
							showNoDataMessage(6);
					}
                ?>
            </table>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="manufacturer_form"/>
                <h2 class="big-txt">Добавить/Изменить производителя</h2>
                <label>ID</label>
                <input type="text" name="id"/>
                <label>Название<span class="required-field"></span></label>
                <input type="text" required name="name"/>
                <label>Описание<span class="required-field"></span></label>
                <textarea name="desc" required></textarea>
                <label>Email</label>
                <input type="email" name="email"/>
                <label>Страна<span class="required-field"></span></label>
                <select name="country" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT * FROM countries");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
                <button>
                    Редактировать
                </button>
            </form>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/AdminChangeDB.js"></script>
</body>
</html>