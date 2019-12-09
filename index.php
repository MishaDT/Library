<?php
session_start();
include_once 'includes/functions.php';
$user = new User();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Библиотека</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <script src="js/jquery.min.js"></script>
</head>

<body>
    <header class="header">
        <div class="wrapper">
            <ul class="header__menu">
                <li><span class="link logo">Library</span></li>
                <?php if (isset($_SESSION['name'])) { ?>
                    <li><a href="includes/read_the_book.php" class="link">Прочитанные книги</a></li>
                    <li><a href="includes/list_will_read.php" class="link">Буду читать</a></li>
                <?php } ?>
            </ul>
            <ul class="header__menu">
                <li class="header__menu-elements">
                    <?php if (isset($_SESSION['name'])) { ?>
                        <a href="/" class="link">
                            <?php echo $_SESSION['name']; ?>
                        </a>
                        <ul class="submenu">
                            <li><a href="includes/chat.php">Сообщения</li>
                            <li><a href="includes/logout.php">Выйти</a></li>
                        </ul>
                </li>
            <?php } else { ?>
                <li>
                    <a href="includes/registration.php" class="link">Регистрация</a>
                <?php } ?>
                </li>
                <li><?php if (!isset($_SESSION['name'])) { ?>
                        <a href="includes/authorization.php" class="link">Войти</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </header>
    <div class="wrapper">
        <section class="books">
            <h1 class="title">Каталог книг</h1>
            <p class="description">Читайте книги совершенно бесплатно</p>
            <?php $user->books(); ?>
            <div class="margin_scroll">
                <div class="two_margin">
            <span class="scrollup"></span>
            <span class="scroll_up">Вверх</span>
            </div>
            </div>
        </section>
    </div>
    <script type="text/javascript" src="js/ajax.js"></script>
    <script src="js/book_output.js"></script>
</body>

</html>