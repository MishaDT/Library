<?php
session_start();
include_once 'includes/functions.php';
$user = new User;
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

</head>

<body>
    <header class="header">
        <div class="wrapper">
            <ul class="header__menu">
                <li><a href="index.php" class="link">Каталог</a></li>
                <?php if (isset($_SESSION['name'])) { ?>
                    <li><a href="includes/read_the_book.php" class="link">Прочитанные книги</a></li>
                    <li><a href="includes/list_will_read.php" class="link">Буду читать</a></li>
                <?php } ?>
            </ul>
            <ul class="header__menu">
                <li>
                    <?php if (isset($_SESSION['name'])) { ?>
                        <a href="" class="link">
                            <?php echo $_SESSION['name']; ?>
                        </a>
                    <?php } else { ?>
                        <a href="includes/registration.php" class="link">Регистрация</a>
                    <?php } ?>
                </li>
                <li><?php if (isset($_SESSION['name'])) { ?>
                        <a href="includes/logout.php">Выйти</a>
                    <?php  } else { ?>
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

            <div class="books__list">
                <!-- Вывод каталога книг -->
                <?php $user->books(); ?>
                <button class="button__read_more"><?php if (isset($_SESSION['name'])) { ?> Читать ещё <?php } else { ?> Ещё книги <?php } ?></button>
            </div>
        </section>
    </div>

</body>

</html>