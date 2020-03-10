<?php
    $TITLE = "Вход";
    include("layout_top.php");
?>
    <div class="main">
        <div class="centered-container">
            <div class="main-header">
                <h1 class="big-txt">Контакты</h1>
            </div>
			<div class="contacts-container">
				<form class="contact-form" method="POST" action="contact-confirm.php">
					<h2 class="big-txt">Оставьте свое сообщение</h2>
					<label>Имя<span class="required-field"></span></label>
					<input type="text" required name="user_name"/>
					<label>Email<span class="required-field"></span></label>
					<input type="email" required name="email"/>
					<label>Тема<span class="required-field"></span></label>
					<input type="text" required name="subject"/>
					<label>Ваше сообщение<span class="required-field"></span></label>
                    <textarea name="message" required></textarea>
                    <input type="submit" value="Отправить"/>
				</form>
				<div class="contacts-info">
					<h2 class="big-txt">Контактная информация</h2>
					<div class="contactinfo-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt maiores fuga assumenda, nisi illo iste ab aliquam consequatur, quo possimus debitis provident distinctio velit praesentium nobis cumque molestias obcaecati minus.</div>
					<div class="storeinfo-info">
						<span class="storeinfo-desc">Адрес:</span>
						<span class="storeinfo-info">ул. Магазинная, 1а</span>
					</div>
					<div class="storeinfo-info">
						<span class="storeinfo-desc">Телефон:</span>
						<span class="storeinfo-info">+375 29 22-81-337</span>
					</div>
					<div class="storeinfo-info">
						<span class="storeinfo-desc">Email:</span>
						<span class="storeinfo-info">info@offliner.com</span>
					</div>
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15522.44859615186!2d-115.81312080440469!3d37.239644520109785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80b8138e1f929c37%3A0xc383a58e7f293e77!2sArea%2051%20Groom%20Lake%20Military%20Complex!5e1!3m2!1sru!2sby!4v1582122096526!5m2!1sru!2sby" width="100%" height="450" frameborder="0" style="border:1;" allowfullscreen=""></iframe>
				</div>
			</div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
</body>
</html>