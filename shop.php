<?php
    $TITLE = "Главная";
    include("layout_top.php");
    require("modules/form_utils.php");
    require_once("modules/products.php");
?>
    <div class="main centered-container">
        <div class="main-header">
            <h1 class="big-txt">Магазин</h1>
        </div>
        <p class="error-str"></p>
        <div class="shop-container">
            <div class="shop-sidebar">
                <div class="shop-sidebar-column">
                    <div class="shop-sidebar-columnheader big-txt">Категории</div>
                    <ul id="category-list" class="shop-sidebar-list">
                        <?php
                            require_once("modules/connection.php");
                            $result = $mysqli->query("SELECT id, name FROM appliancestypes order by name");
                            while($row = mysqli_fetch_array($result)){
                                if(isset($_GET['category']) && $_GET['category'] == $row['id'])
                                    echo '<li data-id="' . $row['id'] . '" class="selected">' . $row['name'] . '</li>';
                                else
                                    echo '<li data-id="' . $row['id'] . '">' . $row['name'] . '</li>';
                            }
                            mysqli_free_result($result);
                        ?>
                    </ul>
                </div>
                <div class="shop-sidebar-column">
                    <div class="shop-sidebar-columnheader big-txt">Цена</div>
                    <label>От:</label><input type="text" name="min_price" <?= isset($_GET["min_price"]) ? 'value="' . $_GET["min_price"] . '"' : ''?>/>
                    <label>До:</label><input type="text" name="max_price" <?= isset($_GET["max_price"]) ? 'value="' . $_GET["max_price"] . '"' : ''?>/>
                </div>
                <div class="shop-sidebar-column">
                    <div class="shop-sidebar-columnheader big-txt">Производитель</div>
                    <ul id="manufacturer-list" class="shop-sidebar-list">
                        <?php
                            require_once("modules/connection.php");
                            $result = $mysqli->query("SELECT id, name FROM manufacturers order by name");
                            while($row = mysqli_fetch_array($result)){
                                if(isset($_GET['manufacturer']) && in_array($row['id'], $_GET['manufacturer']))
                                    echo '<li data-id="' . $row['id'] . '" class="selected">' . $row['name'] . '</li>';
                                else
                                    echo '<li data-id="' . $row['id'] . '">' . $row['name'] . '</li>';
                            }
                            mysqli_free_result($result);
                        ?>
                    </ul>
                </div>
                <button id="reset-filters">
                    Сбросить фильтры
                </button>
            </div>
            <div class="shop">
                <div class="shop-itemsheader">
                    <span class="big-txt">
                        <?php
                         echo 'Просмотр ';
                         if(isset($_GET['page']) && isset($_GET['item_count'])){
                            echo (($_GET['page'] - 1) * $_GET['item_count'] + 1) . '-' . (($_GET['page']) * $_GET['item_count']);
                         }
                         else
                         if(isset($_GET['page'])){
                            echo (($_GET['page'] - 1) * 12 + 1) . '-' . (($_GET['page']) * 12);
                         }
                         else{
                            echo 1 . '-' . 12;
                         }
                         echo ' товаров';
                        ?>
                    </span>
                    <div class="buttons-block">
                        <select name="item-count">
                            <option value="12" <?=isset($_GET["item_count"]) ? selected(12, $_GET["item_count"]) : 'selected'?>>12</option>
                            <option value="24" <?=isset($_GET["item_count"]) ? selected(24, $_GET["item_count"]) : ''?>>24</option>
                            <option value="32" <?=isset($_GET["item_count"]) ? selected(32, $_GET["item_count"]) : ''?>>32</option>
                        </select>
                        <select name="sort-type">
                            <option value="new" <?=isset($_GET["sort_type"]) ? selected('new', $_GET["sort_type"]) : 'selected'?>>Сначала новые</option>
                            <option value="expensive" <?=isset($_GET["sort_type"]) ? selected('expensive', $_GET["sort_type"]) : ''?>>Сначала дорогие</option>
                            <option value="cheap" <?=isset($_GET["sort_type"]) ? selected('cheap', $_GET["sort_type"]) : ''?>>Сначала дешевые</option>
                            <option value="popular" <?=isset($_GET["sort_type"]) ? selected('popular', $_GET["sort_type"]) : ''?>>Сначала популярные</option>
                        </select>
                        <button class="pressed" name="shop_gridstyle_btn" onclick="setGridStyle(this)">
                            <img src="images/ProductGrid.png" alt="Grid style"/>
                        </button>
                        <button class="released" name="shop_liststyle_btn" onclick="setListStyle(this)">
                            <img src="images/ProductList.png" alt="List style"/>
                        </button>
                    </div>
                </div>
                <div class="shop-items-grid" name="shop_2styles">
                    <?php
                        require("modules/connection.php");
                        $query_top = "SELECT a.id, a.image, a.name, a.cost, a.discount_cost, a.description, (SELECT ROUND(SUM(score) / COUNT(score)) FROM reviews WHERE product = a.id) as score FROM appliances as a";
                        $query = "";
                        $count_query = "SELECT COUNT(*) as count FROM appliances";
                        //filters
                        $is_where_added = false;
                        if(isset($_GET['search_string']) && $_GET['search_string'] != ''){
                            if($is_where_added)
                                $query .= ' and name like \'%' . $_GET['search_string'] . '%\'';
                            else{
                                $query .= ' WHERE name like \'%' . $_GET['search_string'] . '%\'';
                                $is_where_added = true;
                            }
                        }
                        if(isset($_GET['category']) && $_GET['category'] != ''){
                            if($is_where_added)
                                $query .= ' and type = \'' . $_GET['category'] . '\'';
                            else{
                                $query .= ' WHERE type = \'' . $_GET['category'] . '\'';
                                $is_where_added = true;
                            }
                        } 
                        if(isset($_GET['min_price']) && $_GET['min_price'] != ''){
                            if($is_where_added)
                                $query .= ' and (cost >= \'' . $_GET['min_price'] . '\' or discount_cost >= \'' . $_GET['min_price'] . '\')';
                            else{
                                $query .= ' WHERE (cost >= \'' . $_GET['min_price'] . '\' or discount_cost >= \'' . $_GET['min_price'] . '\')';
                                $is_where_added = true;
                            }
                        } 
                        if(isset($_GET['max_price']) && $_GET['max_price'] != ''){
                            if($is_where_added)
                                $query .= ' and (cost <= \'' . $_GET['max_price'] . '\' or discount_cost <= \'' . $_GET['max_price'] . '\')';
                            else{
                                $query .= ' WHERE (cost <= \'' . $_GET['max_price'] . '\' or discount_cost <= \'' . $_GET['max_price'] . '\')';
                                $is_where_added = true;
                            }
                        }
                        if(isset($_GET['manufacturer'])){
                            if($is_where_added)
                                $query .= ' and manufacturer in(';
                            else{
                                $query .= ' WHERE manufacturer in(';
                                $is_where_added = true;
                            }
                            while(true){
                                $query .= '\'' . array_shift($_GET['manufacturer']) . '\'';
                                if(count($_GET['manufacturer']) > 0)
                                    $query .= ', ';
                                else
                                    break;
                            }
                            $query .= ')';
                        }

                        $count_query .= $query;

                        if(isset($_GET['sort_type'])){
                            switch($_GET['sort_type']){
                                case 'new':
                                    $query .= ' ORDER BY id desc';
                                    break;
                                case 'cheap':
                                    $query .= ' ORDER BY IF(discount_cost is null, cost, discount_cost)';
                                    break;
                                case 'expensive':
                                    $query .= ' ORDER BY IF(discount_cost is null, cost, discount_cost) desc';
                                    break;
                                case 'popular':
                                    $query .= ' ORDER BY score desc';
                                    break;
                            }
                        }
                        else{
                            $query .= ' ORDER BY id desc';
                        }
                        if(isset($_GET['item_count'])){
                            if(isset($_GET['page']))
                                $query .= ' limit ' . (($_GET['page'] - 1) * $_GET['item_count']) . ', ' . $_GET['item_count'];
                            else
                                $query .= ' limit 0, ' . $_GET['item_count'];
                        }
                        else{
                            if(isset($_GET['page']))
                                $query .= ' limit ' . (($_GET['page'] - 1) * 12) . ', 12';
                            else
                                $query .= ' limit 0, 12';
                        }
                        
                        $query = $query_top . $query;
                        $result = $mysqli->query($query);
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        $no_data = true;
		                while($row = mysqli_fetch_array($result)){
                            $no_data = false;
			                formShopProduct($row['id'], $row['image'], $row['name'], $row['cost'], $row['discount_cost'], $row['score'], $row['description']);
                        }
                        if($no_data){
                            echo '<p class="no-data">Нет подходящих товаров</p>';
                        }
		                mysqli_free_result($result);
                    ?>
                </div>
                <?php
                    require_once("modules/DB_utils.php");
                    require_once("modules/tables.php");
                    $result = $mysqli->query($count_query);
                    if ($mysqli->errno){
                        die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                    }
                    if($row = mysqli_fetch_array($result)){
                        $rowscount = $row['count'];
                    }
                    else{
                        die('No data in query');
                    }
                    mysqli_free_result($result);
                    if(isset($_GET['page']))
                        formPagesButtons($rowscount, isset($_GET['item_count']) ? $_GET['item_count'] : 12, $_GET['page']);
                    else
                        formPagesButtons($rowscount, isset($_GET['item_count']) ? $_GET['item_count'] : 12);
                ?>
            </div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/ToCart.js"></script>
    <script src="scripts/ChangeShopStyle.js"></script>
    <script src="scripts/PageControl.js"></script>
    <script src="scripts/Shop.js"></script>
</body>
</html>