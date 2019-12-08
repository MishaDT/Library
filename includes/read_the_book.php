<?php
session_start();
include_once 'functions.php';
$user = new User;

if (isset($_SESSION['name'])) {
    include_once 'header.php';
    $book_id = $_GET['id'];
    ?>
    <div class="wrapper">
        <span class="scrollup"></span>
        <section class="books">
            <h1 class="title" style="margin-bottom: 50px;">Прочитанные книги</h1>
            <div class="books__list">
                <?php $user->readTheBook(); // Функция вывода прочитанных книг 
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