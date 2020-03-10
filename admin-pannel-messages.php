<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Просмотр сообщений</h1>
            </div>
            <table class="log-table">
				<tr>
                    <th>ID</th>
                    <th>Имя отправителя</th>
                    <th>Email</th>
                    <th>Тема</th>
                    <th>Сообщение</th>
                    <th>Удалить</th>
				</tr>
                <?php
					if(!formTableRows('SELECT * FROM contactmessage', false, true))
						showNoDataMessage(5);
                ?>
            </table>
            <form class="admin-form" method="POST">
                <input type="hidden" name="form" value="message_form"/>
            </form>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/AdminChangeDB.js"></script>
</body>
</html>