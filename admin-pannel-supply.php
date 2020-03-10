<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление поставками</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form class="search-form" method="GET">
                    <h2>Поиск</h2>
                    <?php
                        if(isset($_GET['search_supply_string'])){
                    ?>
                        <input type="text" name="search_supply_string" placeholder="Введите id или дату..." value="<?=$_GET['search_supply_string']?>"/>
                    <?php
                        }
                        else{
                    ?>
                        <input type="text" name="search_supply_string" placeholder="Введите id или дату..."/>
                    <?php
                        }
                    ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="supplies-table choosable">
				<tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Номер склада</th>
                    <th>Поставщик</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
				</tr>
                <?php
					if(isset($_GET['search_supply_string'])){
						if(!formTableRows('SELECT * FROM supplies WHERE id = \'' . $_GET['search_supply_string'] . '\' or date = \'' . $_GET['search_supply_string'] . '\'', true, true))
							showNoDataMessage(7);
					}
					else{
						if(!formTableRows('SELECT * FROM supplies', true, true, [3 => 'SELECT id, name FROM suppliers']))
							showNoDataMessage(7);
					}
                ?>
            </table>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="supply_form"/>
                <h2 class="big-txt">Добавить поставку</h2>
                <label>ID</label>
                <input type="text" name="id"/>
                <label>Дата<span class="required-field"></span></label>
                <input type="date" required name="date"/>
                <label>Склад<span class="required-field"></span></label>
                <select name="warehouse" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id FROM warehouses");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
                <label>Поставщик<span class="required-field"></span></label>
                <select name="supplier" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query('SELECT id, name FROM suppliers');
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
                    Добавить поставку
                </button>
            </form>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="supply_product_form"/>
                <h2 class="big-txt">Изменить кол-во товара в поставке</h2>
                <label>ID товара<span class="required-field"></span></label>
                <input type="text" required name="id"/>
                <label>Поставка<span class="required-field"></span></label>
                <select name="supply" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id FROM supplies");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
                <label>Кол-во (0 - удалить товар из поставки)<span class="required-field"></span></label>
                <input type="number" required name="count" min="0"/>
                <button name="add_product">
                    Редактировать
                </button>
            </form>
            <h2>Товары в поставке</h2>
            <table class="products-table">
				<tr>
                    <th>Товар</th>
                    <th>Артикул</th>
                    <th>Кол-во</th>
				</tr>
                <?php
                    if(isset($_GET['choosed'])){
                        if(!formTableRows('SELECT a.image, a.name, a.id, sa.count FROM appliances as a, suppliesappliances as sa WHERE a.id = sa.product and sa.supply = \'' . $_GET['choosed'] . '\'', false, false, [], [], true))
                            showNoDataMessage(3);   
                    }
                    else
                        showNoDataMessage(3); 
                ?>
            </table>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/AdminChangeDB.js"></script>
</body>
</html>