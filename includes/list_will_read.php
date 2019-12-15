<?php
session_start();
require_once 'functions.php';
$user = new User();
if (isset($_SESSION['name'])) { // Если пользователь авторизован
    include_once 'header.php';
    $book_id = $_GET['id'];
    ?>
    <div class="wrapper">
        <span id="button_top" onclick="return up()">&#9650; Наверх</span> <!-- Кнопка ScrollUp -->
        <section class="books">
            <h1 class="title" style="margin-bottom: 50px;">Буду читать позже</h1>
            <div class="books__list" id="books__list">
                <?php $user->willRead(); // Вызов функции вывода книг из каталога "Читать позже" 
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