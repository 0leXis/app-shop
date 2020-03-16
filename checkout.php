<?php
    $TITLE = "Главная";
    require_once("modules/error_pages.php");
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        die();
    }
    if($_SESSION['user_isadmin'])
        error403();
    include("layout_top.php");
?>
    <div class="main">
        <div class="centered-container">
            <div class="main-header">
                <h1 class="big-txt">Корзина</h1>
            </div>
            <p class="error-str"></p>
            <form class="delivery-form" method="POST">
                <h2 class="big-txt">Детали доставки</h2>
                <label>Телефон<span class="required-field"></span></label>
                <input type="tel" required name="phone" maxlength="20" pattern="^(\+375|80)(29|25|44|33)(\d{3})(\d{2})(\d{2})$"/>
                <label>Страна<span class="required-field"></span></label>
                <select name="country">
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id, name FROM countries");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>   
                <label>Город<span class="required-field"></span></label>
                <input type="text" required name="city" maxlength="50"/>
                <label>Адрес<span class="required-field"></span></label>
                <input type="text" required name="address" maxlength="100"/>
                <label>Почтовый индекс<span class="required-field"></span></label>
                <input type="text" required name="post_code" maxlength="6" pattern="[0-9]{6}"/>
                <label>Способ оплаты<span class="required-field"></span></label>
                <select name="method">
                    <?php
                        require('modules/connection.php');
                        $result = $mysqli->query("SELECT id, name FROM paymentmethods");
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_row($result)){
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        mysqli_free_result($result);
                    ?>
                </select>
                <label>Номер карты<span class="required-field"></span></label>
                <input type="text" required name="card" maxlength="20" pattern="[0-9]{14,}"/>
            </form>
			<div class="cart-totals">
				<h2 class="big-txt">Ваш заказ</h2>
				<div class="cart-totals-table">
                    <div class="cart-totals-row">
						<div class="cart-totals-header big-txt">Товар</div>
						<div class="cart-totals-header big-txt">Сумма</div>
                    </div>
                    <?php
                        require_once("modules/connection.php");
                        $result = $mysqli->query('SELECT a.name, IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * c.count as price FROM appliances as a, carts as c WHERE c.product = a.id and c.customer = ' . $_SESSION['user_id']);
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        while($row = mysqli_fetch_array($result)){
                            echo '<div class="cart-totals-row">';
                            echo '<div class="cart-totals-value">' . $row['name'] . '</div>';
                            echo '<div class="cart-totals-value">' . $row['price'] . '</div>';
                            echo '</div>';
                        }
                        mysqli_free_result($result);

                        $result = $mysqli->query('SELECT SUM(IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * c.count) as total FROM appliances as a, carts as c WHERE c.product = a.id and c.customer = ' . $_SESSION['user_id']);
                        if ($mysqli->errno){
                            die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                        }
                        $row = mysqli_fetch_array($result);
                        mysqli_free_result($result);
                    ?>
					<div class="cart-totals-row">
						<div class="cart-totals-header big-txt">Итог (без доставки)</div>
						<div class="cart-totals-value">$<?=$row['total'] == null ? 0 : $row['total']?></div>
					</div>
					<div class="cart-totals-row">
						<div class="cart-totals-header big-txt">Доставка</div>
						<div class="cart-totals-value">$<?=$row['total'] == null ? 0 : 10?></div>
					</div>
					<div class="cart-totals-row">
						<div class="cart-totals-header big-txt">Общий итог</div>
						<div class="cart-totals-value">$<?=$row['total'] == null ? 0 : $row['total'] + 10?></div>
					</div>
				</div>
				<button name="pay_button">К оплате</button>
			</div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/Checkout.js"></script>
</body>
</html>