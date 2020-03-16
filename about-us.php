<?php
    $TITLE = "Главная";
    include("layout_top.php");
?>
    <div class="main">
        <div class="centered-container">
            <div class="main-header">
                <h1 class="big-txt">О нас</h1>
            </div>
            <div class="team-container">
                <img src="images/Team.jpg" alt="Our team"/>
                <div class="team-info">
                    <h2>Мы ваще топ магазин!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione fugiat quod odio inventore, rerum doloribus sapiente! Nesciunt, facere? Ad nihil deserunt illum error autem fugit sint accusantium dolore velit in!</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa similique libero, dolorum ex nobis nostrum ipsum, consectetur error laboriosam porro voluptates. Ut quam quaerat eveniet repudiandae aliquam veniam ex explicabo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quasi, ad, molestiae alias voluptatibus dignissimos dolorum et exercitationem, nisi eius beatae adipisci quia dicta! Beatae ipsam quas consectetur quia rem?</p>
                    <a href="#">Наши контакты</a>
                </div>
            </div>
        </div>
        <div class="team-features">
            <ul class="centered-container">
                <li>
                    <div class="img-container">
                        <img src="images/TeamStrategy.png" alt="Strategy"/>
                    </div>
                    <span class="feature-header big-txt">Стратегия и маркетинг</span>
                    <span class="feature-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum alias perferendis eos fugiat corporis possimus officia eligendi totam! Necessitatibus alias molestias doloremque deserunt dolore delectus laboriosam atque cum consequuntur facere?</span>
                </li>
                <li>
                    <div class="img-container">
                        <img src="images/TeamDesign.png" alt="Design"/>
                    </div>
                    <span class="feature-header big-txt">Интерактивный дизайн</span>
                    <span class="feature-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid quidem aperiam, voluptate temporibus perferendis eveniet minus praesentium ipsam corrupti? Ab aspernatur ea reiciendis doloribus excepturi facilis soluta quia quam adipisci?</span>
                </li>
                <li>
                    <div class="img-container">
                        <img src="images/TeamWeb.png" alt="Web"/>
                    </div>
                    <span class="feature-header big-txt">Веб разработка</span>
                    <span class="feature-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, fuga totam neque impedit rem modi, velit, suscipit veritatis sit quia alias expedita maxime. Alias distinctio ducimus molestiae iusto accusamus facere?</span>
                </li>
            </ul>
        </div>
        <div class="team-stats">
            <ul class="centered-container white-txt">
                <li>
                    <span class="stats-stat">2343</span>
                    <span class="stats-text">Сотрудников</span>
                </li>
                <li>
                    <span class="stats-stat">100</span>
                    <span class="stats-text">% качества товара</span>
                </li>
                <li>
                    <span class="stats-stat">4214</span>
                    <span class="stats-text">Кружек кофе</span>
                </li>
                <li>
                    <span class="stats-stat">420014</span>
                    <span class="stats-text">Покупателей</span>
                </li>
            </ul>
        </div>
        <div class="meet-the-team centered-container">
            <div class="meet-header">
                <h2>Наша команда</h2>
                <span>Yare Yare Daze</span>
            </div>
            <ul class="meet-team">
                <li>
                    <img src="images/Jotaro.png" alt="Team lead">
                    <span class="big-txt">Jotaro Kujo</span>
                    <span>Руководитель команды</span>
                </li>
                <li>
                    <img src="images/Rohan.png" alt="Creative director">
                    <span class="big-txt">Rohan Kishibe</span>
                    <span>Креативный директор</span>
                </li>
                <li>
                    <img src="images/Dio.png" alt="Marketing director">
                    <span class="big-txt">Dio Brando</span>
                    <span>Директор по маркетингу</span>
                </li>
            </ul>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
</body>
</html>