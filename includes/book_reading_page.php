<?php
session_start();

if (isset($_SESSION['name'])) { // Если пользователь авторизован

    require_once 'functions.php';
    include_once 'header.php';
    $user = new User();

    if (isset($_GET['id'])) { // Поиск id книги
        ?>
        <div class="wrapper">
            <span id="button_top" onclick="return up()">&#9650; Наверх</span> <!-- Кнопка ScrollUp -->
            <section class="books">
                <?
                        $id = $_GET['id'];
                        $uid = $_SESSION['uid'];
                        ?>
                <button class="add_to_books_viewed" onClick="addBookRead('<?= $id ?>')">Добавить в прочитанные</button> <!-- Добавление книги в каталог "Прочитанные книги" -->
                <?php
                        $user->bookReadingPage($id); // Вызов функции вывода книги
                        $user->addToBooksViewed($id, $uid); // Добавление книги в каталог "Просмотренные книги"
                        ?>
            </section>
        </div>
        <script src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/ajax.js"></script>
        </body>

        </html>
<?php
    }
} else {
    header("Location: ../index.php");
}
