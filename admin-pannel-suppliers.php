<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление поставщиками</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form class="search-form" method="GET">
                    <h2>Поиск</h2>
                    <?php
                        if(isset($_GET['search_supplier_string'])){
                    ?>
                        <input type="text" name="search_supplier_string" placeholder="Введите id или название..." value="<?=$_GET['search_supplier_string']?>"/>
                    <?php
                        }
                        else{
                    ?>
                        <input type="text" name="search_supplier_string" placeholder="Введите id или название..."/>
                    <?php
                        }
                    ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="manufacturers-table">
				<tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Email</th>
                    <th>Редактировать</th>
					<th>Удалить</th>
				</tr>
                <?php
					if(isset($_GET['search_supplier_string'])){
						if(!formTableRows('SELECT * FROM suppliers WHERE id = \'' . $_GET['search_supplier_string'] . '\' or Name like \'%' . $_GET['search_supplier_string'] . '%\'', true, true, [], [2]))
							showNoDataMessage(5);
					}
					else{
						if(!formTableRows('SELECT * FROM suppliers', true, true, [], [2]))
							showNoDataMessage(5);
					}
                ?>
            </table>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="supplier_form"/>
                <h2 class="big-txt">Добавить/Изменить поставщика</h2>
                <label>ID</label>
                <input type="text" name="id"/>
                <label>Название<span class="required-field"></span></label>
                <input type="text" required name="name"/>
                <label>Описание<span class="required-field"></span></label>
                <textarea name="desc" required></textarea>
                <label>Email</label>
                <input type="email" name="email"/>
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