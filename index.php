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

            <div class="books__list" id="books__list">
                <!-- Вывод каталога книг -->
                <?php
                $query = "SELECT * FROM `books` LIMIT 9";
                $result = $user->db->query($query) or die($user->db->error);
                $video_id = '';
                while ($read_books = $result->fetch_array(MYSQLI_ASSOC)) {
                    $video_id = $read_books['id'];
                    $img = $read_books['img'];
                    $title = $read_books['title'];
                    $author = $read_books['author'];
                    echo '<div class="books__item">
                    <div class="item-books__img">
                        <img src="../img/' . $img . '" alt="' . $title . '">
                    </div>
                    <h2 class="item-books__title">' . $title . '</h2>
                    <span class="item-books__author">' . $author . '</span>';
                    if (isset($_SESSION['name'])) {
                        echo "<a href=\"includes/book_reading_page.php?id=$video_id\" class='item-books__button'>Читать</a>";
                        echo "<a href=\"includes/i_will_read.php?id=$video_id?title=$title?author=$author\" style='text-decoration: underline; color: #000;' class='item-books__will_read'>Читать позже</a>";
                    }
                    echo '</div>';
                }
                ?>
            </div>
            <div id="remove_row">
                <button class='button__read_more form-control' type="button" name="btn_more" data-vid="<?php echo $video_id; ?>" id="btn_more">Ещё книги...</button>
            </div>
        </section>
    </div>
    <script src="js/book_output.js"></script>
</body>

</html>