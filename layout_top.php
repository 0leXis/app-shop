<?php
    //TODO: session here
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= "OFFLINER - " . $TITLE?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css" type="text/css" />
</head>

<body>
    <header>
        <div class="header-login">
            <div class="centered-container">
                <a href="login.php">Вход/Регистрация</a>
            </div>
        </div>
        <div class="header-main">
            <div class="centered-container">
                <div class="header-logo">
                    <image src="images/Logo.png" alt="Logo" />
                    <span class="big-txt">Offliner</span>
                </div>
                <div class="header-search-and-cart">
                    <div class="header-search">
                        <form name="search" method="GET" action="#">
                            <input type="text" name="search_string" placeholder="Искать..." />
                            <select name="category">
                                <option>Все категории</option>
                                <option>Стиральные машины</option>
                            </select>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <div class="header-cart">
                        <button>
                            <img src="images/Cart.png" />
                        </button>
                        <div class="header-cart-sum">
                            <span>0 Товаров:</span>
                            <pre> </pre>
                            <span class="blue-text">$0.00</span>
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
                        <li><a href="#" class="big-txt white-txt">Магазин</a></li>
                        <li><a href="#" class="big-txt white-txt">Наши контакты</a></li>
                        <li><a href="#" class="big-txt white-txt">О нас</a></li>
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