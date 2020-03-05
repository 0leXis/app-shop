<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление дополнительной информацией</h1>
            </div>
            <p class="error-str"></p>
            <div class="additional-info-container">
                <div class="additional-info">
                    <h2>Страны</h2>
                    <div class="header-search">
                        <form class="search-form" method="GET">
                            <h2>Поиск</h2>
                            <?php
                                if(isset($_GET['search_country_string'])){
                            ?>
                                <input type="text" name="search_country_string" placeholder="Введите id или название..." value="<?=$_GET['search_country_string']?>"/>
                            <?php
                                }
                                else{
                            ?>
                                <input type="text" name="search_country_string" placeholder="Введите id или название..."/>
                            <?php
                                }
                            ?>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <table class="additionalinfo-table">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
							if(isset($_GET['search_country_string'])){
								if(!formTableRows('SELECT * FROM countries WHERE id = \'' . $_GET['search_country_string'] . '\' or name like \'%' . $_GET['search_country_string'] . '%\'', true, true))
									showNoDataMessage(4);
							}
							else{
								if(!formTableRows('SELECT * FROM countries', true, true))
									showNoDataMessage(4);
							}
                        ?>
                    </table>
                    <form class="additionalinfo-form" method="POST">
                        <input type="hidden" name="form" value="country_form"/>
                        <h2 class="big-txt">Добавить/Изменить страну</h2>
                        <label>ID</label>
                        <input type="text" name="id"/>
                        <label>Название<span class="required-field"></span></label>
                        <input type="text" required name="name"/>
                        <button>
                            Редактировать
                        </button>
                    </form>
                </div>
                <div class="additional-info">
                    <h2>Категории товаров</h2>
                    <div class="header-search">
                        <form name="search" method="GET" action="#">
                            <h2>Поиск</h2>
                            <?php
                                if(isset($_GET['search_category_string'])){
                            ?>
                                <input type="text" name="search_category_string" placeholder="Введите id или название..." value="<?=$_GET['search_category_string']?>"/>
                            <?php
                                }
                                else{
                            ?>
                                <input type="text" name="search_category_string" placeholder="Введите id или название..."/>
                            <?php
                                }
                            ?>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <table class="additionalinfo-table">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
							if(isset($_GET['search_category_string'])){
								if(!formTableRows('SELECT * FROM typecategories WHERE id = \'' . $_GET['search_category_string'] . '\' or name like \'%' . $_GET['search_category_string'] . '%\'', true, true))
									showNoDataMessage(4);
							}
							else{
								if(!formTableRows('SELECT * FROM typecategories', true, true))
									showNoDataMessage(4);
							}
                        ?>
                    </table>
                    <form class="additionalinfo-form" method="POST">
                        <input type="hidden" name="form" value="category_form"/>
                        <h2 class="big-txt">Добавить/Изменить категорию товара</h2>
                        <label>ID</label>
                        <input type="text" name="id"/>
                        <label>Название<span class="required-field"></span></label>
                        <input type="text" required name="name"/>
                        <button>
                            Редактировать
                        </button>
                    </form>
                </div>
                <div class="additional-info">
                    <h2>Типы товаров</h2>
                    <div class="header-search">
                        <form name="search" method="GET" action="#">
                            <h2>Поиск</h2>
                            <?php
                                if(isset($_GET['search_type_string'])){
                            ?>
                                <input type="text" name="search_type_string" placeholder="Введите id или название..." value="<?=$_GET['search_type_string']?>"/>
                            <?php
                                }
                                else{
                            ?>
                                <input type="text" name="search_type_string" placeholder="Введите id или название..."/>
                            <?php
                                }
                            ?>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <table class="additionalinfo-table">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Категория</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
							if(isset($_GET['search_type_string'])){
								if(!formTableRows('SELECT * FROM appliancestypes WHERE id = \'' . $_GET['search_type_string'] . '\' or name like \'%' . $_GET['search_type_string'] . '%\'', true, true))
									showNoDataMessage(5);
							}
							else{
								if(!formTableRows('SELECT * FROM appliancestypes', true, true))
									showNoDataMessage(5);
							}
                        ?>
                    </table>
                    <form class="additionalinfo-form" method="POST" action="#">
                        <input type="hidden" name="form" value="type_form"/>
                        <h2 class="big-txt">Добавить/Изменить тип товара</h2>
                        <label>ID</label>
                        <input type="text" name="id"/>
                        <label>Категория<span class="required-field"></span></label>
                        <select required name="category">
                        <?php
                            require('modules/connection.php');
                            $result = $mysqli->query("SELECT * FROM typecategories");
                            if ($mysqli->errno){
                                die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                            }
                            while($row = mysqli_fetch_row($result)){
                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                            mysqli_free_result($result);
                        ?>
                        </select>
                        <label>Название<span class="required-field"></span></label>
                        <input type="text" required name="name"/>
                        <button>
                            Редактировать
                        </button>
                    </form>
                </div>
                <div class="additional-info">
                    <h2>Должности</h2>
                    <div class="header-search">
                        <form name="search" method="GET" action="#">
                            <h2>Поиск</h2>
                            <?php
                                if(isset($_GET['search_role_string'])){
                            ?>
                                <input type="text" name="search_role_string" placeholder="Введите id или название..." value="<?=$_GET['search_role_string']?>"/>
                            <?php
                                }
                                else{
                            ?>
                                <input type="text" name="search_role_string" placeholder="Введите id или название..."/>
                            <?php
                                }
                            ?>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <table class="additionalinfo-table">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
							if(isset($_GET['search_role_string'])){
								if(!formTableRows('SELECT * FROM positions WHERE id = \'' . $_GET['search_role_string'] . '\' or name like \'%' . $_GET['search_role_string'] . '%\'', true, true))
									showNoDataMessage(4);
							}
							else{
								if(!formTableRows('SELECT * FROM positions', true, true))
									showNoDataMessage(4);
							}
                        ?>
                    </table>
                    <form class="additionalinfo-form" method="POST" action="#">
                        <input type="hidden" name="form" value="role_form"/>
                        <h2 class="big-txt">Добавить/Изменить должность</h2>
                        <label>ID</label>
                        <input type="text" name="id"/>
                        <label>Название<span class="required-field"></span></label>
                        <input type="text" required name="name"/>
                        <button>
                            Редактировать
                        </button>
                    </form>
                </div>
                <div class="additional-info">
                    <h2>Статусы заказов</h2>
                    <div class="header-search">
                        <form name="search" method="GET" action="#">
                            <h2>Поиск</h2>
                            <?php
                                if(isset($_GET['search_status_string'])){
                            ?>
                                <input type="text" name="search_status_string" placeholder="Введите id или название..." value="<?=$_GET['search_status_string']?>"/>
                            <?php
                                }
                                else{
                            ?>
                                <input type="text" name="search_status_string" placeholder="Введите id или название..."/>
                            <?php
                                }
                            ?>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <table class="additionalinfo-table">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
							if(isset($_GET['search_status_string'])){
								if(!formTableRows('SELECT * FROM orderstatuses WHERE id = \'' . $_GET['search_status_string'] . '\' or name like \'%' . $_GET['search_status_string'] . '%\'', true, true))
									showNoDataMessage(4);
							}
							else{
								if(!formTableRows('SELECT * FROM orderstatuses', true, true))
									showNoDataMessage(4);
							}
                        ?>
                    </table>
                    <form class="additionalinfo-form" method="POST" action="#">
                        <input type="hidden" name="form" value="status_form"/>
                        <h2 class="big-txt">Добавить/Изменить статус</h2>
                        <label>ID</label>
                        <input type="text" name="id"/>
                        <label>Название<span class="required-field"></span></label>
                        <input type="text" required name="name"/>
                        <button>
                            Редактировать
                        </button>
                    </form>
                </div>
                <div class="additional-info">
                    <h2>Методы оплаты</h2>
                    <div class="header-search">
                        <form name="search" method="GET" action="#">
                            <h2>Поиск</h2>
                            <?php
                                if(isset($_GET['search_method_string'])){
                            ?>
                                <input type="text" name="search_method_string" placeholder="Введите id или название..." value="<?=$_GET['search_method_string']?>"/>
                            <?php
                                }
                                else{
                            ?>
                                <input type="text" name="search_method_string" placeholder="Введите id или название..."/>
                            <?php
                                }
                            ?>
                            <button type="submit">
                                <img src="images/Search.png" />
                            </button>
                        </form>
                    </div>
                    <table class="additionalinfo-table">
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        <?php
							if(isset($_GET['search_method_string'])){
								if(!formTableRows('SELECT * FROM paymentmethods WHERE id = \'' . $_GET['search_method_string'] . '\' or name like \'%' . $_GET['search_method_string'] . '%\'', true, true))
									showNoDataMessage(4);
							}
							else{
								if(!formTableRows('SELECT * FROM paymentmethods', true, true))
									showNoDataMessage(4);
							}
                        ?>
                    </table>
                    <form class="additionalinfo-form" method="POST" action="#">
                        <input type="hidden" name="form" value="method_form"/>
                        <h2 class="big-txt">Добавить/Изменить метод оплаты</h2>
                        <label>ID</label>
                        <input type="text" name="id"/>
                        <label>Название<span class="required-field"></span></label>
                        <input type="text" required name="name"/>
                        <button>
                            Редактировать
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/AdminChangeDB.js"></script>
</body>
</html>