<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        header('Location: ..\index.php');
        die();
    }

    function login(){
        if(isset($_POST['email']) && isset($_POST['password'])){
            require_once('modules/hash.php');
            require_once('modules/DB_utils.php');
            $users = execProcedure('GetLoginInfo', $_POST['email']);
            if($row = mysqli_fetch_array($users)){
                if(compareHash($_POST['password'], $row['password'], $row['salt'])){
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_email'] = $row['email'];
                    $_SESSION['user_isadmin'] = $row['admin'] == '1' ? true : false;
                    header('Location: ..\index.php');
                    mysqli_free_result($users);
                    die();
                }
                else{
                    return("Введен некорректный пароль");
                }
            }
            else{
                mysqli_free_result($users);
                return("Пользователя с таким Email не существует");
            }
        }
        else{
            error400();
        }
    }

    function registration(){
        //TODO: Registration
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['login']))
            $login_error = login();
        else
        if(isset($_POST['registration']))
            $registration_error = registration();
        else
            error400();
    }
?>
<?php
    $TITLE = "Вход";
    include("layout_top.php");
?>
    <div class="main">
        <div class="centered-container">
            <div class="main-header">
                <h1 class="big-txt">Вход в аккаунт</h1>
            </div>
			<div class="login-container">
                <form name="login" method="POST" action="login.php">
                    <input type="hidden" required name="login" value="login"/>
                    <h2 class="big-txt">Зарегистрированный пользователь</h2>
					<label>Email<span class="required-field"></span></label>
                    <input type="email" required name="email"/>
                    <label>Пароль<span class="required-field"></span></label>
                    <input type="password" required name="password"/>
                    <input type="submit" value="Вход"/>
                    <p class="error-str"><?php if(isset($login_error)) echo $login_error;?></p>
                </form>
                <form name="registration" method="POST" action="#">
                    <input type="hidden" required name="registration" value="registration"/>
                    <h2 class="big-txt">Не зарегистрированы? Нет проблем!</h2>
					<label>Имя<span class="required-field"></span></label>
                    <input type="text" required name="user_name"/>
                    <label>Фамилия<span class="required-field"></span></label>
                    <input type="text" required name="user_surname"/>
                    <label>Отчество<span class="required-field"></span></label>
					<input type="text" required name="user_lastname"/>
					<label>Email<span class="required-field"></span></label>
                    <input type="email" required name="email"/>
                    <label>Пароль<span class="required-field"></span></label>
                    <input type="password" required name="password"/>
                    <label>Повтор пароля<span class="required-field"></span></label>
                    <input type="password" required name="re_password"/>
                    <input type="submit" value="Зарегистрироваться"/>
                    <p class="error-str"><?php if(isset($registration_error)) echo $registration_error;?></p>
                </form>
            </div>
        </div>
    </div>
    <?php
        include("layout_footer.php");
    ?>
</body>
</html>