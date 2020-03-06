<?php
    $TITLE = "Главная";
    include("layout_admintop.php");
    include("modules/tables.php");
?>
        <div class="content">
            <div class="main-header">
                <h1 class="big-txt">Управление сотрудниками</h1>
            </div>
            <p class="error-str"></p>
            <div class="header-search">
                <form name="search" method="GET" action="#">
                        <h2>Поиск</h2>
                        <?php
                            if(isset($_GET['search_staff_string'])){
                        ?>
                            <input type="text" name="search_staff_string" placeholder="Введите id или фамилию..." value="<?=$_GET['search_staff_string']?>"/>
                        <?php
                            }
                            else{
                        ?>
                            <input type="text" name="search_staff_string" placeholder="Введите id или фамилию..."/>
                        <?php
                             }
                        ?>
                    <button type="submit">
                        <img src="images/Search.png" />
                    </button>
                </form>
            </div>
            <table class="staff-table">
				<tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Отчество</th>
                    <th>Должность</th>
                    <th>Оклад</th>
                    <th>Email</th>
                    <th>Изменить</th>
					<th>Удалить</th>
				</tr>
                <?php
					if(isset($_GET['search_staff_string'])){
						if(!formTableRows('SELECT id, Name, Surname, Lastname, Position, Salary, Email FROM workers WHERE id = \'' . $_GET['search_staff_string'] . '\' or Surname like \'%' . $_GET['search_staff_string'] . '%\'', true, true, [ 4 => 'SELECT * FROM positions']))
							showNoDataMessage(9);
					}
					else{
						if(!formTableRows('SELECT id, Name, Surname, Lastname, Position, Salary, Email FROM workers', true, true, [ 4 => 'SELECT * FROM positions']))
							showNoDataMessage(9);
					}
                ?>
            </table>
            <form class="staff-add-form" method="POST">
                <input type="hidden" name="form" value="staff_form"/>
                <h2 class="big-txt">Добавить/Изменить сотрудника</h2>
                <h2 class="big-txt">(при добавлении сотрудника необходимо обязательно указать пароль)</h2>
                <label>ID</label>
                <input type="text" name="id"/>
                <label>Имя<span class="required-field"></span></label>
                <input type="text" required name="name"/>
                <label>Фамилия<span class="required-field"></span></label>
                <input type="text" required name="surname"/>
                <label>Отчество<span class="required-field"></span></label>
                <input type="text" required name="lastname"/>
                <label>Должность<span class="required-field"></span></label>
                <select required name="role">
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT * FROM positions");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
                <label>Оклад<span class="required-field"></span></label>
                <input type="text" required name="salary"/>
                <label>Email<span class="required-field"></span></label>
                <input type="email" required name="email"/>
                <label>Пароль</label>
                <input type="password" name="pass"/>
                <label>Повторите пароль</label>
                <input type="password" name="pass_conf"/>
                <button>
                    Добавить/редактировать
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