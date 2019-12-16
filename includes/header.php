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
    <!-- header -->
    <header class="header">
        <div class="wrapper">
            <ul class="header__menu">
                <li><span class="link logo">Library</span></li>
                <li><a href="../index.php" class="link">Каталог</a></li>
                <?php if (isset($_SESSION['name'])) { // Если пользователь авторизован 
                ?>
                    <?php if ($_SERVER['REQUEST_URI'] != "/includes/books_viewed.php") { ?>
                        <li><a href="books_viewed.php" class="link">Просмотренные книги</a></li>
                    <?php } else {
                    } ?>
                    <?php if ($_SERVER['REQUEST_URI'] != "/includes/read_the_book.php") { ?>
                        <li><a href="read_the_book.php" class="link">Прочитанные книги</a></li>
                    <?php } else {
                    } ?>
                    <?php if ($_SERVER['REQUEST_URI'] != "/includes/list_will_read.php") { ?>
                        <li><a href="list_will_read.php" class="link">Буду читать</a></li>
                    <?php } else {
                    } ?>
                <?php } ?>
            </ul>
            <ul class="header__menu">
                <li class="header__menu-elements">
                    <?php if (isset($_SESSION['name'])) { // Если пользователь авторизован 
                    ?>
                        <a href="/" class="link">
                            <?php echo $_SESSION['name']; ?>
                        </a>
                        <ul class="submenu">
                            <li><a href="chat.php">Сообщения</li>
                            <li><a href="logout.php">Выйти</a></li>
                        </ul>
                </li>
            <?php } else { ?>
                <li>
                    <a href="registration.php" class="link">Регистрация</a>
                <?php } ?>
                </li>
                <li><?php if (!isset($_SESSION['name'])) { // Если пользователь не авторизован 
                    ?>
                        <a href="authorization.php" class="link">Войти</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </header>