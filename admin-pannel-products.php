<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление товарами</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form class="search-form" method="GET">
                    <h2>Поиск</h2>
                    <?php
                        if(isset($_GET['search_product_string'])){
                    ?>
                        <input type="text" name="search_product_string" placeholder="Введите артикул или название..." value="<?=$_GET['search_product_string']?>"/>
                    <?php
                        }
                        else{
                    ?>
                        <input type="text" name="search_product_string" placeholder="Введите артикул или название..."/>
                    <?php
                        }
                    ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="products-table">
				<tr>
                    <th>Товар</th>
                    <th>Артикул</th>
                    <th>Цена без скидок</th>
                    <th>Цена со скидкой</th>
                    <th>Производитель</th>
                    <th>Тип</th>
                    <th>Редактировать</th>
					<th>Удалить</th>
				</tr>
                <?php
                    if(!isset($_GET['page']))
                        $_GET['page'] = 1;
					if(isset($_GET['search_product_string'])){
						if(!formTableRows('SELECT image, name, id, description, cost, discount_cost, manufacturer, type FROM appliances WHERE id = \'' . $_GET['search_product_string'] . '\' or Name like \'%' . $_GET['search_product_string'] . '%\' limit ' . (10 * ($_GET['page'] - 1)) . ', 10', true, true, [ 6 => 'SELECT id, name FROM manufacturers', 7 => 'SELECT id, name FROM appliancestypes'], [3], true))
							showNoDataMessage(8);
					}
					else{
						if(!formTableRows('SELECT image, name, id, description, cost, discount_cost, manufacturer, type FROM appliances limit ' . (10 * ($_GET['page'] - 1)) . ', 10', true, true, [ 6 => 'SELECT id, name FROM manufacturers', 7 => 'SELECT id, name FROM appliancestypes'], [3], true))
							showNoDataMessage(8);
					}
                ?>
            </table>
            <?php
                require_once("modules/DB_utils.php");
                if(isset($_GET['page']))
                    formPagesButtons(getRowsCount('appliances'), 10, $_GET['page']);
                else
                    formPagesButtons(getRowsCount('appliances'), 10);
            ?>
            <form enctype="multipart/form-data" class="admin-form" method="POST">
                <input type="hidden" name="form" value="product_form"/>
                <h2 class="big-txt">Добавить/Изменить товар</h2>
                <h2 class="big-txt">(при добавлении товара необходимо загрузить его изображение)</h2>
                <label>Название<span class="required-field"></span></label>
                <input type="text" required name="name"/>
                <label>Артикул<span class="required-field"></span></label>
                <input type="text" required name="id"/>
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                <label>Изображение</label>
                <input type="file" name="image" accept="image/*"/>
                <label>Описание<span class="required-field"></span></label>
                <textarea name="description" required></textarea>
                <label>Цена<span class="required-field"></span></label>
                <input type="text" required name="price"/>
                <label>Цена со скидкой</label>
                <input type="text" name="discount_price"/>
                <label>Производитель<span class="required-field"></span></label>
                <select name="manufacturer" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id, name FROM manufacturers");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
                <label>Тип<span class="required-field"></span></label>
                <select name="type" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id, name FROM appliancestypes");
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
                    Добавить/редактировать
                </button>
            </form>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/AdminChangeDB.js"></script>
    <script src="scripts/PageControl.js"></script>
</body>
</html>