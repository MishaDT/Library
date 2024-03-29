<?php

session_start();
require_once 'functions.php';
$user = new User();

if (isset($_SESSION['name'])) { // Если пользователь авторизован
    header("Location: ../index.php"); // Переадресация на главную станицу
} else {
    if (isset($_POST['submit'])) { // Проверка отправки формы регистрации
        extract($_POST);
        $register = $user->registrationUser($uname, $uemail, $upass); // Вызов функции для регистрации пользователя
        if ($register) {
            header("Location: ../index.php");
        } else {
            $answer = "<span class='form__answer-danger'>Пользователь с таким именем или E-mail уже существует</span>";
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/fonts.css">
        <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
        <title>Регистрация</title>
    </head>

    <body>
        <?php include_once('navbar.php'); ?>

        <!-- Форма регистрации пользователя -->
        <form class="form" action="" method="post" name="registration">
            <?php if (isset($answer)) echo $answer; ?>
            <h1 class="form__title">Регистрация</h1>
            <input class="form__input" type="text" name="uname" placeholder="Введите имя">
            <input class="form__input" type="email" name="uemail" placeholder="Введите E-mail">
            <input class="form__input" type="password" name="upass" placeholder="Введите пароль">
            <input class="form__input_submit" name="submit" type="submit" value="Зарегистрироваться" onclick="return(submitRegistration());">
            <span class="form__account">У вас есть аккаунт?<br>
                <a class="form__link" href="authorization.php">Войти</a>
            </span>
        </form>

        <!-- JavaScript валидация формы регистрации -->
        <script src="../js/RegExp.js"></script>

    </body>

    </html>
<?php } ?>