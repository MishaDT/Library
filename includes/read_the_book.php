<?php
session_start();
require_once 'functions.php';
$user = new User();

if (isset($_SESSION['name'])) { // Если пользователь авторизован
    include_once 'header.php';
    ?>
    <div class="wrapper">
        <span id="button_top" onclick="return up()">&#9650; Наверх</span> <!-- Кнопка ScrollUp -->
        <section class="books">
            <h1 class="title" style="margin-bottom: 50px;">Прочитанные книги</h1>
            <div class="books__list" id="books__list">
                <?php $user->readTheBook(); // Вызов функции вывода книг из каталога "Прочитанные книги" 
                    ?>
            </div>
        </section>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/ajax.js"></script>
    </body>

    </html>
<?php } else {
    header("Location: ../index.php");
} ?>