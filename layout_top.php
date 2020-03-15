<?php
    if(!isset($_SESSION))
        session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= "OFFLINER - " . $TITLE?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css" type="text/css" />
    <script src="scripts/jquery-3.4.1.js"></script>
</head>

<body>
    <header>
        <div class="header-login">
            <div class="centered-container">
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo "<span>" . $_SESSION['user_email'] . "</span>";
                        echo "<span>|</span>";
                        if($_SESSION['user_isadmin']){
                            echo '<a href="admin-pannel.php">Панель администратора</a>';
                        }
                        else{
                            echo '<a href="orders.php">Мои заказы</a>';
                        }
                        echo "<span>|</span>";
                        echo '<a href="modules/logout.php">Выйти из аккаунта</a>';
                    }
                    else{
                        echo '<a href="login.php">Вход/Регистрация</a>';
                    }
                ?>
            </div>
        </div>
        <div class="header-main">
            <div class="centered-container">
                <div class="header-logo">
                    <img src="images/Logo.png" alt="Logo" />
                    <span class="big-txt">Offliner</span>
                </div>
                <div class="header-search-and-cart">
                    <div class="header-search">
                        <form name="search" method="GET" action="shop.php">
                            <input type="text" name="search_string" placeholder="Искать..." <?= isset($_GET['search_string']) ? 'value="' . $_GET['search_string'] . '"' : '';?>/>
                            <select name="category">
                            <?php
                                require("modules/connection.php");
                                $result = $mysqli->query("SELECT id, name FROM appliancestypes order by name");

                                echo '<option value="">Все категории</option>';
                                while($row = mysqli_fetch_array($result)){
                                    if(isset($_GET['category']) && $_GET['category'] == $row['id'])
                                        echo '<option value="' . $row['id'] . '" selected>' . $row['name'] . '</option>';
                                    else
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                                mysqli_free_result($result);
                            ?>
                            </select>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <div class="header-cart">
                        <form action="cart.php">
                            <button href="cart.php">
                                <img src="images/Cart.png" />
                            </button>
                        </form>
                        <div class="header-cart-sum">
                            <?php
                                $row = null;
                                if(isset($_SESSION['user_id']) && !$_SESSION['user_isadmin']){
                                    require_once("modules/connection.php");
                                    $result = $mysqli->query('SELECT SUM(IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * c.count) as total, SUM(c.count) as count FROM appliances as a, carts as c WHERE c.product = a.id and c.customer = ' . $_SESSION['user_id']);
                                    if ($mysqli->errno){
                                        die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                                    }
                                    $row = mysqli_fetch_array($result);
                                    mysqli_free_result($result);
                                }
                            ?>
                            <span><?= is_null($row['count']) ? 0 : $row['count']?> товаров:</span>
                            <pre> </pre>
                            <span class="blue-text">$<?= is_null($row['total']) ? 0 : $row['total']?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-nav">
            <div class="centered-container">
                <nav>
                    <ul>
                        <li class="selected-menu-item"><a href="#" class="big-txt black-txt">Главная</a></li>
                        <li><a href="shop.php" class="big-txt white-txt">Магазин</a></li>
                        <li><a href="contact-us.php" class="big-txt white-txt">Наши контакты</a></li>
                        <li><a href="about-us.php" class="big-txt white-txt">О нас</a></li>
                    </ul>
                </nav>
                <div class="header-contactus">
                    <span class="big-txt white-txt">Позвоните нам:</span>
                    <pre> </pre>
                    <span class="header-contactus-phone">+375 29 22-81-337</span>
                </div>
            </div>
        </div>
    </header>