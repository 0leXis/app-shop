<?php
    require_once('modules\error_pages.php');

    if(!isset($_SESSION))
        session_start();
    if(!isset($_SESSION['user_isadmin']))
        error401();
    if($_SESSION['user_isadmin'] != true)
        error403();
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= "OFFLINER ADMIN - " . $TITLE?></title>
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
                            echo '<a href="index.php">Главная</a>';
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
            </div>
        </div>
        <div class="header-blueline">
        </div>
    </header>
    <div class="admin-main">
        <aside>
            <nav>
                <ul>
                    <li><a href="admin-pannel-products.php">Товары</a></li>
                    <li><a href="admin-pannel-staff.php">Сотрудники</a></li>
                    <li><a href="admin-pannel-orders.php">Заказы</a></li>
                    <li><a href="admin-pannel-warehouses.php">Склады</a></li>
                    <li><a href="admin-pannel-suppliers.php">Поставщики</a></li>
                    <li><a href="admin-pannel-supply.php">Поставки</a></li>
                    <li><a href="admin-pannel-manufacturers.php">Производители</a></li>
                    <li><a href="admin-pannel-additional-info.php">Редактирование дополнительной информации</a></li>
                    <li><a href="admin-pannel-messages.php">Сообщения</a></li>
                </ul>
            </nav>
        </aside>