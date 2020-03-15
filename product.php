<?php
    $TITLE = "Главная";
    include("layout_top.php");

    require("modules/connection.php");
    require("modules/error_pages.php");
    require_once("modules/DB_utils.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_SESSION['user_id']) && !isset($_SESSION['user_isadmin']) && $_SESSION['user_isadmin'] == true)
            error401();
        if(isset($_POST['id']) && isset($_POST['user_score']) && isset($_POST['message'])){
            execProcedure('AddReview', $_POST['id'], $_SESSION['user_id'], $_POST['user_score'] + 1, date('Y-m-d'), $_POST['message']);
            header('Location: product.php?id=' . $_POST['id']);
            die();
        }
        else
            error400();
    }

    if(!isset($_GET['id'])){
        error400();
    }

    $result = $mysqli->query("SELECT a.id, a.image, a.name, a.cost, a.discount_cost, a.description, (SELECT ROUND(SUM(score) / COUNT(score)) FROM reviews WHERE product = a.id) as score, (SELECT COUNT(score) FROM reviews WHERE product = a.id) as score_count, (SELECT name FROM appliancestypes where id = a.type) as category, (SELECT name FROM manufacturers where id = a.manufacturer) as manufacturer, a.stockavailability, (SELECT SUM(count) FROM warehousesappliances WHERE product = a.id) as p_count FROM appliances as a WHERE id='" . htmlentities(mysqli_real_escape_string($mysqli, $_GET['id'])) . "'");
    if ($mysqli->errno){
        die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
    }
    $product = mysqli_fetch_array($result);
    if(!$product){
        error404();
    }
    mysqli_free_result($result);
?>
    <div class="main">
        <div class="centered-container">
            <div class="main-header">
                <h1 class="big-txt">Страница товара</h1>
            </div>
            <p class="error-str"></p>
            <div class="product-desc-block">
                <img src="<?=$product['image']?>" alt="Product image"/>
                <div class="product-desc">
                    <h2><?=$product['name']?></h2>
                    <div class="product-raiting-block">
                        <?php
                            if(is_null($product['score']))
                                echo '<span>Нет отзывов</span>';
                            else{
                                echo '<ul class="product-stars">';
                                for($star = 0; $star < 5; $star++)
                                    if($star < $product['score'])
                                        echo '<li class="yellow-star"></li>';
                                    else
                                        echo '<li class="dark-star"></li>';
                                echo '</ul>';
                                echo '<span>(' . $product['score_count'] . ' отзывов)</span>';
                            }
                        ?>
                    </div>
                    <div class="product-price-block">
                        <?php
                            if(is_null($product['discount_cost'])){
                                echo '<span class="new-price">$' . $product['cost'] . '</span>';
                            }
                            else{
                                echo '<span class="old-price">$' . $product['cost'] . '</span>';
                                echo '<span class="new-price">$' . $product['discount_cost'] . '</span>';
                            }
                        ?>
                    </div>
                    <div class="product-shortdesc">
                        <?=$product['description']?>
                    </div>
                    <div class="product-additionalinfo">
                        <div class="info-element">
                            <span class="info-header">Артикул:</span>
                            <span><?=$product['id']?></span>
                        </div>
                        <div class="info-element">
                            <span class="info-header">Категория:</span>
                            <span><?=$product['category']?></span>
                        </div>
                        <div class="info-element">
                            <span class="info-header">Производитель:</span>
                            <span><?=$product['manufacturer']?></span>
                        </div>
                    </div>
                    <?php
                        if($product['stockavailability'])
                            echo '<span class="in-stock">В наличии ' . $product['p_count'] . ' единиц</span>';
                        else
                            echo '<span class="out-stock">Нет в наличии</span>';
                    ?>
                    <form name="order" method="POST">
                        <label>Кол-во:</label>
                        <?php
                            if($product['stockavailability']){
                                echo '<input type="number" name="count" min="1" max="' . $product['p_count'] . '" value="1"/>';
                                echo '<input type="submit" name="to_cart_with_count" value="В корзину"/>';
                            }
                            else{
                                echo '<input type="number" name="count" disabled/>';
                                echo '<input type="submit" name="to_cart_with_count" value="В корзину" disabled/>';  
                            }
                        ?>
                    </form>
                </div>
            </div>
            <div class="product-reviews-block">
                <div class="product-reviews">
                    <h2>Отзывы покупателей</h2>
                    <?php
                        $result = $mysqli->query("SELECT r.date, r.score, r.comment, c.name, c.surname FROM reviews as r left join customers as c on r.customer = c.id WHERE r.product='" . htmlentities(mysqli_real_escape_string($mysqli, $_GET['id'])) . "' ORDER BY date desc");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        $no_data = true;
                        while($row = mysqli_fetch_array($result)){
                            $no_data = false;
                            echo '<div class="customer-review">';
                            echo '<div class="review-header">';
                            echo '<div class="review-data">';
                            echo '<span class="customer-name">' . $row['name'] . ' ' . $row['surname'] . '</span>';
                            echo '<span class="review-date">' . date("d.m.Y", strtotime($row['date'])) . '</span>';
                            echo '</div>';
                            echo '<ul class="product-stars">';
                            for($star = 0; $star < 5; $star++)
                                if($star < $row['score'])
                                    echo '<li class="yellow-star"></li>';
                                else
                                    echo '<li class="dark-star"></li>';
                            echo '</ul>';
                            echo '</div>';
                            echo '<p>' . $row['comment'] . '</p>';
                            echo '</div>';
                        }
                        if($no_data){
                            echo '<p class="no-data">Нет отзывов</p>';
                        }
                    ?>
                </div>
                <?php
                    if(isset($_SESSION['user_id'])){
                        $result = $mysqli->query("SELECT id FROM reviews WHERE customer='" . htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['user_id'])) . "' and product='" . htmlentities(mysqli_real_escape_string($mysqli, $_GET['id'])) . "'");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        $has_review = mysqli_fetch_array($result);
                        mysqli_free_result($result);
                    }
                    else
                        $has_review = false;
                    if(isset($_SESSION['user_id']) && isset($_SESSION['user_isadmin']) && $_SESSION['user_isadmin'] == false && !$has_review){
                ?>
                <form name="add_review" method="POST" action="product.php">
                    <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
                    <h2>Добавить отзыв</h2>
                    <label>Оценка<span class="required-field"></span></label>
                    <ul class="product-stars-choose">
                        <li class="dark-star"></li>
                        <li class="dark-star"></li>
                        <li class="dark-star"></li>
                        <li class="dark-star"></li>
                        <li class="dark-star"></li>
                    </ul>
                    <input type="hidden" name="user_score" value="-1"/>
                    <label>Ваш отзыв<span class="required-field"></span></label>
                    <textarea name="message"></textarea>
                    <input type="submit" value="Отправить"/>
                </form>
                <?php
                    }
                    else
                    if(isset($_SESSION['user_isadmin']) && $_SESSION['user_isadmin'] == true)
                        echo '<p class="no-data">Нельзя оставить отзыв в режиме администратора</p>';
                    else
                    if($has_review)
                        echo '<p class="no-data">Вы уже написали отзыв</p>';
                    else
                        echo '<p class="no-data">Выполните вход, чтобы оставить отзыв</p>';
                ?>
            </div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/ToCart.js"></script>
    <script src="scripts/AddReview.js"></script>
    <script>setFormListeners("add_review");</script>
</body>
</html>