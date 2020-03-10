<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление складом</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form class="search-form" method="GET">
                    <h2>Поиск</h2>
                    <?php
                        if(isset($_GET['search_warehouse_string'])){
                    ?>
                        <input type="text" name="search_warehouse_string" placeholder="Введите номер склада..." value="<?=$_GET['search_warehouse_string']?>"/>
                    <?php
                        }
                        else{
                    ?>
                        <input type="text" name="search_warehouse_string" placeholder="Введите номер склада..."/>
                    <?php
                        }
                    ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="warehouses-table choosable">
				<tr>
                    <th>Номер склада</th>
                    <th>Адрес</th>
                    <th>Зав. Складом</th>
                    <th>Редактировать</th>
					<th>Удалить</th>
				</tr>
                <?php
					if(isset($_GET['search_warehouse_string'])){
						if(!formTableRows('SELECT * FROM warehouses WHERE id = \'' . $_GET['search_warehouse_string'] . '\'', true, true, [ 2 => 'SELECT id, CONCAT(name, \' \', surname, \' \', lastname) FROM workers'], []))
							showNoDataMessage(5);
					}
					else{
						if(!formTableRows('SELECT * FROM warehouses', true, true, [ 2 => 'SELECT id, CONCAT(name, \' \', surname, \' \', lastname) FROM workers'], []))
							showNoDataMessage(5);
					}
                ?>
            </table>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="warehouse_form"/>
                <h2 class="big-txt">Добавить/Изменить склад</h2>
                <label>Номер<span class="required-field"></span></label>
                <input type="text" required name="id"/>
                <label>Адрес<span class="required-field"></span></label>
                <input type="text" required name="address"/>
                <label>Зав. складом<span class="required-field"></span></label>
                <select name="manager" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query('SELECT id, CONCAT(name, \' \', surname, \' \', lastname) FROM workers');
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
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="warehouse_product_form"/>
                <h2 class="big-txt">Изменить кол-во товара на складе</h2>
                <label>ID товара<span class="required-field"></span></label>
                <input type="text" required name="id"/>
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
                <label>Кол-во (0 - удалить товар со склада)<span class="required-field"></span></label>
                <input type="number" required name="count" min="0"/>
                <button name="add_product">
                    Редактировать
                </button>
            </form>
            <h2>Товары на складе</h2>
            <table class="products-table">
				<tr>
                    <th>Товар</th>
                    <th>Артикул</th>
                    <th>Кол-во</th>
				</tr>
                <?php
                    if(isset($_GET['choosed'])){
                        if(!formTableRows('SELECT a.image, a.name, a.id, wa.count FROM appliances as a, warehousesappliances as wa WHERE a.id = wa.product and wa.warehouse = \'' . $_GET['choosed'] . '\'', false, false, [], [], true))
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