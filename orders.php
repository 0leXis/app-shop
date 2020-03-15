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
                <h1 class="big-txt">Заказы</h1>
            </div>
            <p class="error-str"></p>
			<table class="orders-table choosable">
				<tr>
					<th>Заказ</th>
					<th>Статус</th>
                </tr>
                <?php
                    require_once("modules/tables.php");
                    if(!formTableRows("SELECT CONCAT('Заказ №', id), status FROM orders WHERE customer = '" . htmlentities(mysqli_real_escape_string($mysqli, $_SESSION['user_id'])) . "'", false, false, [ 1 => 'SELECT id, name FROM orderstatuses']))
                        showNoDataMessage(2);
                ?>
            </table>
            <?php
                if(isset($_GET['choosed'])){
                    require('modules/connection.php');
                    $result = $mysqli->query("SELECT id, phone, (SELECT name FROM countries as c WHERE c.id = orders.deliverycountry) as deliverycountry, deliverycity, deliveryaddress, postcode, (SELECT name FROM paymentmethods as p WHERE p.id = orders.paymentmethod) as paymentmethod, cardnumber, (SELECT name FROM orderstatuses as os WHERE os.id = orders.status) as status FROM orders WHERE id = '" . htmlentities(mysqli_real_escape_string($mysqli, $_GET['choosed'])) . "'");
                    if ($mysqli->errno){
                        die('Select Error (' . $mysqli->errno . ') ' . $mysqli->error);
                    }
                    while($row = mysqli_fetch_array($result)){
            ?>
            <div class="order-details">
                <h2 class="big-txt">Заказ №<?=$row['id']?></h2>
                <div class="order-detail">
                    <span class="order-header">Телефон: </span>
                    <span><?=$row['phone']?></span>
                </div>
                <div class="order-detail">
                    <span class="order-header">Страна: </span>
                    <span><?=$row['deliverycountry']?></span>
                </div>
                <div class="order-detail">
                    <span class="order-header">Город: </span>
                    <span><?=$row['deliverycity']?></span>
                </div>
                <div class="order-detail">
                    <span class="order-header">Адрес: </span>
                    <span><?=$row['deliveryaddress']?></span>
                </div>
                <div class="order-detail">
                    <span class="order-header">Почтовый индекс: </span>
                    <span><?=$row['postcode']?></span>
                </div>
                <div class="order-detail">
                    <span class="order-header">Способ оплаты: </span>
                    <span><?=$row['paymentmethod']?></span>
                </div>
                <div class="order-detail">
                    <span class="order-header">Номер карты: </span>
                    <span><?=substr_replace($row['cardnumber'], ' ...******... ', 3, strlen($row['cardnumber']) - 3)?></span>
                </div>
                <div class="order-status">
                    <span>Статус: </span>
                    <span><?=$row['status']?></span>
                </div>
            </div>
            <?php
                    }
                    mysqli_free_result($result);
                }
            ?>
            <?php
                if(isset($_GET['choosed'])){
            ?>
			<div class="cart-totals">
				<h2 class="big-txt">Ваш заказ</h2>
				<div class="cart-totals-table">
                    <div class="cart-totals-row">
						<div class="cart-totals-header big-txt">Товар</div>
						<div class="cart-totals-header big-txt">Сумма</div>
                    </div>
                    <?php
                        require_once("modules/connection.php");
                        $result = $mysqli->query("SELECT a.name, IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * c.count as price FROM appliances as a, ordersappliances as c WHERE c.product = a.id and c.order = '" . htmlentities(mysqli_real_escape_string($mysqli, $_GET['choosed'])) . "'");
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

                        $result = $mysqli->query("SELECT SUM(IF(a.discount_cost IS NULL, a.cost, a.discount_cost) * c.count) as total FROM appliances as a, ordersappliances as c WHERE c.product = a.id and c.order = '" . htmlentities(mysqli_real_escape_string($mysqli, $_GET['choosed'])) . "'");
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
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
    <script src="scripts/Orders.js"></script>
</body>
</html>