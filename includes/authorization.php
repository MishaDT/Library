<?php
session_start();
include_once 'functions.php';
$user = new User;

if (isset($_SESSION['name'])) {
    header("Location: ../index.php");
} else {

    if (isset($_POST['submit'])) {
        extract($_POST);
        $login = $user->check_login($name, $password);
        if ($login) {
            header("Location: ../index.php");
        } else {
            $answer = "<span class='form__answer-danger'>Неверный логин или пароль</span>";
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
        <title>Авторизация</title>
    </head>

    <body>
        <?php include_once('navbar.php'); ?>
        <form class="form" action="" method="post" name="login">
            <?php if (isset($answer)) echo $answer; ?>
            <h1 class="form__title">Авторизация</h1>
            <input class="form__input" type="text" name="name" placeholder="Введите имя">
            <input class="form__input" type="password" name="password" placeholder="Введите пароль">
            <input class="form__input_submit" name="submit" type="submit" value="Войти" onclick="return(submitAuthorization());">
            <span class="form__account">У вас ещё нет аккаунта?<br>
                <a class="form__link" href="registration.php">Регистрация</a>
            </span>
        </form>

        <script src="../js/RegExp.js"></script>

    </body>

    </html>
<?php } ?>