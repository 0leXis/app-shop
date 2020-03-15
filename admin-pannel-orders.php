<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление заказами</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form class="search-form" method="GET">
                    <h2>Поиск</h2>
                    <?php
                        if(isset($_GET['search_order_string'])){
                    ?>
                        <input type="text" name="search_order_string" placeholder="Введите номер заказа..." value="<?=$_GET['search_order_string']?>"/>
                    <?php
                        }
                        else{
                    ?>
                        <input type="text" name="search_order_string" placeholder="Введите номер заказа..."/>
                    <?php
                        }
                    ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="orders-table choosable">
				<tr>
                    <th>ID</th>
                    <th>Дата</th>
                    <th>Email покупателя</th>
                    <th>Телефон</th>
                    <th>Адрес доставки</th>
                    <th>Почтовый индекс</th>
                    <th>Итоговая стоимость</th>
                    <th>Статус</th>
                    <th>ID администратора</th>
				</tr>
                <?php
					if(isset($_GET['search_order_string'])){
						if(!formTableRows('SELECT o.id, o.date, (SELECT c.email FROM customers as c WHERE o.customer = c.id) as customer, o.phone, CONCAT((SELECT co.name FROM countries as co WHERE co.id = o.deliverycountry), \', \', o.deliverycity, \', \', o.deliveryaddress) as address, o.postcode, (SELECT SUM(IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * oa.count) FROM ordersappliances as oa, appliances as a WHERE o.id = oa.order and oa.product = a.id) as price, (SELECT os.name FROM orderstatuses as os WHERE o.status = os.id) as status, o.manager FROM orders as o WHERE o.id = \'' . $_GET['search_product_string'] . '\'', false, false))
							showNoDataMessage(9);
					}
					else{
						if(!formTableRows('SELECT o.id, o.date, (SELECT c.email FROM customers as c WHERE o.customer = c.id) as customer, o.phone, CONCAT((SELECT co.name FROM countries as co WHERE co.id = o.deliverycountry), \', \', o.deliverycity, \', \', o.deliveryaddress) as address, o.postcode, (SELECT SUM(IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * oa.count) FROM ordersappliances as oa, appliances as a WHERE o.id = oa.order and oa.product = a.id) as price, (SELECT os.name FROM orderstatuses as os WHERE o.status = os.id) as status, o.manager FROM orders as o', false, false))
							showNoDataMessage(9);
					}
                ?>
            </table>
            <h2>Товары в заказе</h2>
            <table class="products-table">
				<tr>
                    <th>Товар</th>
                    <th>Артикул</th>
                    <th>Цена со скидкой</th>
                    <th>Кол-во</th>
				</tr>
				<?php
                    if(isset($_GET['choosed'])){
                        if(!formTableRows('SELECT a.image, a.name, a.id, IF(a.discount_cost IS NULL, a.cost, a.discount_cost) as cost, oa.count FROM appliances as a, ordersappliances as oa WHERE a.id = oa.product and oa.order = \'' . $_GET['choosed'] . '\'', false, false, [], [], true))
                            showNoDataMessage(4);   
                    }
                    else
                        showNoDataMessage(4);
                ?>
            </table>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="order_form"/>
                <h2 class="big-txt">Изменить статус заказа</h2>
                <label>ID<span class="required-field"></span></label>
                <input type="text" required name="id" <?= isset($_GET['choosed']) ? 'value="' . $_GET['choosed'] . '"' : ''?>/>
                <label>Статус<span class="required-field"></span></label>
                <select name="status" required>
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id, name FROM orderstatuses");
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