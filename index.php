<?php
    $TITLE = "Главная";
    include("layout_top.php");
?>
    <div class="main centered-container">
        <p class="error-str"></p>
        <div class="mainpage-sliderblock">
            <div class="mainpage-slider-container">
                <div class="slider">
                    <ul class="slider-images">
                        <li><img src="images/SliderScreen.png" alt="Screen"></li>
                        <li class="slider-slide">
                            <img src="images/MainSlider1.png" alt="Slide 1">
                            <div class="slider-text">
                                <span class="slider-text-header">Скидки 50%</span>
                                <span class="slider-text-text">Четкие цены</span>
                                <a href="1" class="slider-text-linkbutton">Перейти в магазин</a>
                            </div>
                        </li>
                        <li class="slider-slide">
                            <img src="images/MainSlider2.png" alt="Slide 2">
                            <div class="slider-text">
                                <span class="slider-text-header">Холодильник всего за 50$</span>
                                <span class="slider-text-text">Лампочка в подарок!</span>
                                <a href="2" class="slider-text-linkbutton">Купить сейчас</a>
                            </div>
                        </li>
                        <li class="slider-slide">
                            <img src="images/MainSlider1.png" alt="Slide 1">
                            <div class="slider-text">
                                <span class="slider-text-header">Скидки 50%</span>
                                <span class="slider-text-text">Четкие цены</span>
                                <a href="3" class="slider-text-linkbutton">Перейти в магазин</a>
                            </div>
                        </li>
                    </ul>
                    <div class="slider-arrow-left"></div>
                    <div class="slider-arrow-right"></div>
                    <div class="slider-dots"></div>
                </div>
            </div>
            <div class="banner-container">
                <div class="slider-banner">
                    <div class="slider-text">
                        <span class="slider-text-header">Холодильник всего за 50$</span>
                        <span class="slider-text-text">Лампочка в подарок!</span>
                        <a href="#" class="slider-text-linkbutton">Купить сейчас</a>
                    </div>
                </div>
                <div class="slider-banner">
                    <div class="slider-text">
                        <span class="slider-text-header">Холодильник всего за 50$</span>
                        <span class="slider-text-text">Лампочка в подарок!</span>
                        <a href="#" class="slider-text-linkbutton">Купить сейчас</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            require("modules/products.php");
            formProductsBlock(6, "images/DigitalTech.png", "blue-bgc");
            formProductsBlock(4, "images/FoodTech.png", "green-bgc");
            formProductsBlock(5, "images/HomeTech.png", "yellow-bgc");
        ?>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/Slider.js"></script>
    <script src="scripts/ProductBlock.js"></script>
    <script>new Slider()</script>
</body>
</html>