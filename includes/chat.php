<?php
session_start();
require_once 'functions.php';
$user = new User();
$chat = new Chat();

if (isset($_SESSION['name'])) { // Если пользователь авторизован
    include_once 'header.php';
    $NameUser = $_SESSION['name'];
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="../js/AjaxChat.js" type="text/javascript"></script>
    </head>

    <body>
        <?php include_once('header.php'); ?>
        <div class="chat"> <!-- Чат -->
            <div id="BlockMessage" class="block_message"></div> <!-- Блок для вывода сообщений -->
            <div class="form__submission--message">
                <input id="InputMessage" name="InputMessage" class="form__input--chat" placeholder="Введите сообщение..." required="required"> <!-- Ввод сообщения -->
                <input type="submit" value="Отправить" name="submit" id="FormSub" class="form__input_submit--chat"> <!-- Отправка сообщения или нажать Enter -->
            </div>
        </div>
    </body>

    </html>
<?php } else {
    header("Location: ../index.php");
} ?>