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
			<table class="products-table">
				<tr>
                    <th>Товар</th>
                    <th>Артикул</th>
					<th>Цена</th>
					<th>Кол-во</th>
					<th>Итого</th>
					<th>Удалить</th>
                </tr>
                <?php
                    require_once("modules/tables.php");
				    if(!formTableRows('SELECT a.image, a.name, a.id, IF(a.discount_cost IS NULL, a.cost, a.discount_cost) as p_cost, c.count, IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * c.count as total FROM appliances as a, carts as c WHERE c.product = a.id and c.customer = ' . $_SESSION['user_id'], false, true, [], [], true))
                        showNoDataMessage(6);
                ?>
			</table>
			<div class="cart-totals">
				<h2 class="big-txt">Проверка заказа</h2>
				<div class="cart-totals-table">
                    <?php
                        require_once("modules/connection.php");
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
                <form action="checkout.php">
                    <button>К оплате</button>
                </form>
			</div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/DeleteCart.js"></script>
</body>
</html>