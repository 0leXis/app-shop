<?php
	require("modules/error_pages.php");
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!isset($_POST['user_name']) || !isset($_POST['email']) || !isset($_POST['subject']) || !isset($_POST['message'])){
			error400();
		}
		else{
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				return("Введен некорректный Email");
			require("modules/DB_utils.php");
			execProcedure('AddMessage', $_POST['user_name'], $_POST['email'], $_POST['subject'], $_POST['message']);
		}
	}
	else
		error400();
?>
<?php
    $TITLE = "Вход";
	include("layout_top.php");
?>
    <div class="main">
        <div class="centered-container">
            <div class="main-header">
                <h1 class="big-txt">Контакты</h1>
			</div>
			<div class="confirm-msg">
				<h2>Спасибо за Ваше сообщение!</h2>
			</div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
</body>
</html>